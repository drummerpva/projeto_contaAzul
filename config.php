<?php
require './environment.php';
    $config = array();
    if(ENVIRONMENT == "development"){
        define("BASE_URL", "http://localhost/projeto_contaAzul/");
        $config['dbname'] = "projeto_contaazul";
        $config['host'] = "localhost";
        $config['dbuser'] = "root";
        $config['dbpass'] = "";
    }else{
        define("BASE_URL", "http://meusite.com.br/");
        $config['dbname'] = "estrutura_mvc";
        $config['host'] = "localhost";
        $config['dbuser'] = "root";
        $config['dbpass'] = "";
    }
    global $db;
    try{
        $db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'].";charset=utf8",$config['dbuser'],$config['dbpass']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $ex) {
        die("Erro BD: ".$ex->getMessage());
    }