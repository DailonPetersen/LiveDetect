<?php

Class Conexao {
    
    private $pdo;
    public $msgErro = "";

    public function connect(){
        global $pdo;
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=livedetect", "root", "");
        }catch (PDOException $e){
            $msgErro = $e->getMessage();
        }

    }

}
?>