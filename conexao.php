<?php

$usuario = 'root';
$senha = '';
$database = 'cantina';
$host = 'localhost:3406';

$mysqli = new mysqli($host, $usuario, $senha, $databse);

if ($mysqli->connect_error) {
    die("Falha ao conectar ao banco de dados!". $mysqli->connect_error);
}

?>
