<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $dui = $_POST["dui"];
    $tarjeta = $_POST["tarjeta"];
    $fecha = $_POST["fecha"];
    $correo = $_POST["correo"];

    echo "<h2>✅ Compra realizada con éxito</h2>";
    echo "<p><strong>Nombre:</strong> $nombre</p>";
    echo "<p><strong>DUI:</strong> $dui</p>";
    echo "<p><strong>Tarjeta:</strong> $tarjeta</p>";
    echo "<p><strong>Fecha de vencimiento:</strong> $fecha</p>";
    echo "<p><strong>Correo:</strong> $correo</p>";
} else {
    echo "<p>❌ Acceso no válido.</p>";
}
?>
