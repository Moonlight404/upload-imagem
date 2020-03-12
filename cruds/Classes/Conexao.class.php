<?php
 class Conexao {
    public static $con;
    public function __construct() {
        $this->conecta();
    }
    public function __destruct() {
        $this->desconecta();
    }
    public static function desconecta() {
        self::$con = null;
    }
    public static function conecta() {
        try {
            self::$con = new PDO('mysql:host=localhost;dbname=loja;', 'root', '');
            self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$con->exec("SET NAMES 'utf8';");
            return self::$con;
        }
        catch (PDOException $e) {
            echo 'ERROR: conexao ' . $e->getMessage();
        }
    }
 }