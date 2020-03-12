<?php
    require_once 'Classes/Funcionario.class.php';
    $funcionario = new Funcionario();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        if(!empty($_FILES['foto']))
           {
             $path = "upload/";
             $nome_file = md5(basename( $_FILES['foto']['name'])).'.jpg';
             $path = $path.$nome_file;
             
             if(move_uploaded_file($_FILES['foto']['tmp_name'], $path)) {
               $foto_funcionario = $nome_file;
             } else{
                 echo "error!";
             }
           }

        if(isset ($_POST['nome'])){ 
            //clicou no botao cadastrar ou editar
            if(isset($_GET['id_funcionarioup']) && !empty($_GET['id_funcionarioup'])){
                //editar
                $id_up = addslashes($_GET['id_funcionarioup']);
                $nome_funcionario = addslashes($_POST['nome']);
                $descricao_funcionario = addslashes($_POST['descricao']);
                $tipo_funcionario = addslashes($_POST['tipo']);

                $funcionarios = $funcionario->editarFuncionario($id_up, $nome_funcionario, $descricao_funcionario, $foto_funcionario, $tipo_funcionario);
                echo"<script>window.location.href='cadastro_funcionario.php'</script>";
            } else {
                //cadastrar
                $nome_funcionario = addslashes($_POST['nome']);
                $descricao_funcionario = addslashes($_POST['descricao']);
                $tipo_funcionario = addslashes($_POST['tipo']);

                $funcionarios = $funcionario->cadastrarFuncionario($nome_funcionario, $descricao_funcionario, $foto_funcionario, $tipo_funcionario);
            }
        } 
    ?>
    <?php
        if(isset($_GET['id_funcionarioup'])){
            $id_update = addslashes($_GET['id_funcionarioup']);
            $res = $funcionario->listarFuncionario($id_update);
        }
    ?>
    <div class="container-fluid">
        <div class="col-3 mb-5">
        <form method="POST" enctype="multipart/form-data">
            <h3>Cadastrar pessoa</h3>
            <div class="form-group">
                <label for="nome">Nome do funcionário</label>
                <input class="form-control" type="text" name="nome" id="nome" required value="<?php if(isset($res)){echo $res['nome_funcionario'];} ?>">
            </div>
            <div class="form-group">
                <label for="tipo">Tipo</label>
                <input type="text" class="form-control" placeholder="Ex.: Vendedor, Gerente, Líder" name="tipo" id="tipo" required value="<?php if(isset($res)){echo $res['tipo_funcionario'];} ?>"></input>
            </div>
            <div class="form-group">
                <label for="descricao">Descricao</label> 
                <textarea type="text" class="form-control" name="descricao" id="descricao" required><?php if(isset($res)){echo $res['descricao_funcionario'];} ?></textarea>
            </div>
            <div class="form-group">
                <label for="foto">Foto</label> <br/>
                <input type="file" name="foto" id="foto" required>
            </div>

            
            <div>
                <input type="submit" class="btn btn-success" id="btn__acao" value="<?php if(isset($res)){echo "Atualizar";} else{echo "Cadastrar";} ?>">
                <span class="botao__cancelar">
                    
                </span>
            </div>
        </form>

        </div>
    </div>
    <script>
       
        $(document).ready(function(){
            var valor = $('#btn__acao').val();
            if(valor === 'Atualizar'){
                $('.botao__cancelar').html('<a href="cadastro_funcionario.php" class="btn btn-danger">Cancelar</a>');
                $('#foto').removeAttr('required');
            }
        });
    </script>
    <table class="table">
        <thead>
            <tr>
                <td>Nome</td>
                <td>Tipo</td>
                <td>Descricao</td>
                <td colspan="2">Foto</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $funcionarios = $funcionario->buscarFuncionario();
                if(count($funcionarios) > 0){//se tem pessaos no db
                    for ($i= 0; $i < count($funcionarios); $i++){
                        echo "<tr>";
                            ?>
                            <td><?= $funcionarios[$i]['nome_funcionario']?></td>
                            <td><?= $funcionarios[$i]['tipo_funcionario']?></td>
                            <td><?= $funcionarios[$i]['descricao_funcionario']?></td>
                            <td><img src="upload/<?=$funcionarios[$i]['foto_funcionario']?>" width="50px" height="50px"></td>
                            <td>
                                <a class="btn btn-warning" href="cadastro_funcionario.php?id_funcionarioup=<?php echo $funcionarios[$i]['id_funcionario'];?>">Editar</a> 
                                <a class="btn btn-danger" href="cadastro_funcionario.php?id_funcionario=<?php echo $funcionarios[$i]['id_funcionario'];?>">Excluir</a>
                            </td>
                            <?php
                        echo "</tr>";
                    }
                }

                else{ //db vazio
                    echo "<td colspan='4' class='text-center'>Nenhum funcionário cadastrado</td>";
                }
            ?>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
<?php
    if(isset($_GET['id_funcionario'])){
        $id_funcionario = addslashes($_GET['id_funcionario']);
        $funcionario->excluirFuncionario($id_funcionario);
        echo"<script>window.location.href='cadastro_funcionario.php'</script>";
    }
?>