<?php

include("users-db.php");

$email = $_POST["email"];
$password = $_POST["password"];

$database = new UsuariosDatabase();

$loginOk = $database->is_valid_login($email, $password);

if ($loginOk) {
    echo "<h1>Login Correct</h1>";
}
else {
    echo "<h1>Login Incorrect</h1>";
}
?>