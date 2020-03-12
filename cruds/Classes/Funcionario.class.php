<?php
include('Conexao.class.php');
class Funcionario extends Conexao{
    public function __construct() {}

        public function __destruct() {}
        
        public static function cadastrarFuncionario($nome_funcionario, $descricao_funcionario, $foto_funcionario = array(), $tipo_funcionario ){
            $pdo = self::conecta()->prepare("INSERT INTO tbl_funcionario (nome_funcionario, tipo_funcionario, descricao_funcionario, foto_funcionario) VALUE (:nome, :tipo, :descricao, :foto)");
            $pdo->bindValue(":nome",$nome_funcionario);
            $pdo->bindValue(":descricao",$descricao_funcionario);
            $pdo->bindValue(":foto",$foto_funcionario);
            $pdo->bindValue(":tipo",$tipo_funcionario);
            $pdo->execute();
        }
       
        public static function excluirFuncionario($id_funcionario){
            $pdo = self::conecta()->prepare("DELETE FROM tbl_funcionario WHERE id_funcionario = :id_funcionario");
            $pdo->bindValue(":id_funcionario",$id_funcionario);
            $pdo->execute();
        }

        public static function buscarFuncionario(){
            $pdo = self::conecta()->query("SELECT * FROM tbl_funcionario ORDER BY nome_funcionario");
            $res = $pdo->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        //busca apenas uma pessoa para editar
        public static function listarFuncionario($id_funcionario){
            $res = array();
            $pdo = self::conecta()->prepare("SELECT * FROM  tbl_funcionario WHERE id_funcionario = :id_funcionario");
            $pdo->bindValue(":id_funcionario", $id_funcionario);
            $pdo->execute();
            $res = $pdo->fetch(PDO::FETCH_ASSOC);
            return $res;
        }

        public static function editarFuncionario($id_funcionario, $nome_funcionario, $descricao_funcionario, $foto_funcionario = array(), $tipo_funcionario){
            $pdo = self::conecta()->prepare("UPDATE tbl_funcionario SET nome_funcionario = :nome_funcionario, tipo_funcionario = :tipo_funcionario, descricao_funcionario = :descricao_funcionario, foto_funcionario = :foto_funcionario  WHERE id_funcionario = :id_funcionario");
            $pdo->bindValue(":nome_funcionario",$nome_funcionario);
            $pdo->bindValue(":descricao_funcionario",$descricao_funcionario);
            $pdo->bindValue(":foto_funcionario",$foto_funcionario);
            $pdo->bindValue(":tipo_funcionario",$tipo_funcionario);
            $pdo->bindValue(":id_funcionario",$id_funcionario);
            $pdo->execute();
        }
}