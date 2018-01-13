<?php

include("users-db.php");

$email = $_POST["email"];
$password = $_POST["password"];

$database = new UsuariosDatabase();

$exists = $database->email_exists($email);

if ($exists == true) {
    echo "<h1>$email Ya existe. Lo siento!</h1>";
}
else {
    $database->add_user($email, $password);
}
?>