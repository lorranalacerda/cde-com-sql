<?php
//Configurações de bamco de dados
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "cde";
//Criando a conexão
$conexao = new mysqli($servidor, $usuario, $senha, $banco);

//Verificando a conexão
if ($conexao->connect_error) {
    die("Falha na conexão:" . $conexao->connect_error);
}

?>