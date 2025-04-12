<?php
$servidor ="localhost";
$user ="root";
$pass = "";
$db = "desafio2dss";

$conexion = new mysqli($servidor, $user, $pass, $db);
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>