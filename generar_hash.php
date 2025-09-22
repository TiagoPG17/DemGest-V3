<?php
require_once 'vendor/autoload.php';

// Generar el hash real para la contraseña '123456789'
$password = '123456789';
$hash = password_hash($password, PASSWORD_BCRYPT);

echo "Hash Bcrypt para '$password':\n";
echo $hash;
echo "\n\n";
echo "Copia este hash y pégalo en phpMyAdmin";
?>
