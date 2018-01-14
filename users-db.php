<?php 

include("email-sender.php");

class UsuariosDatabase { 
    var $path = '/tmp/database.txt';

    // constructor por defecto de PHP
    function __construct() {
        if (!file_exists($this->path)) {
            $database = fopen($this->path, 'w');
            fclose($database);
        }
    }

    function activate_user($email, $code) {
        try {
            $database = fopen($this->path, 'r');

            if ($database) {
                $array = explode("\n", fread($database, filesize($this->path)));
            }

            $newContent = '';

            $result = false;

            foreach ($array as $linea) {
                if (strpos($linea, $email) === 0) { // la línea comienza por el email
                    if ($this->lineEndsWith($linea, 'ACTIVADO')) { // usuario YA activado
                        // salimos del método sin reescribir el fichero de usuarios
                        return "El usuario $email ya ha sido activado con anterioridad";
                    }
                    else if ($this->lineEndsWith($linea, $code)) { // el código coincide
                        $linea = str_replace($code, "ACTIVADO", $linea);

                        // definimos el mensaje de salida al haber encontrado el usuario y su código
                        $result = "Usuario activado con éxito. ¡Ya puedes iniciar sesión!";
                    }
                    else { // en cualquier otro caso
                        // salimos del método sin reescribir el fichero de usuarios
                        return "El email $email no posee el código $code";
                    }
                }

                $newContent .= $linea."\n";
            }

            fclose($database);

            $database = fopen($this->path, 'w');

            fwrite($database, $newContent) or die("Could not write file!");

            return $result;
        }
        finally {
            fclose($database);
        }
    }

    private function lineEndsWith($cadena, $suffix) {
        // coge desde la última aparición de '#' hasta el final, sin incluirla,
        // quitando los espacios
        $fin = trim(substr(strrchr($cadena, "#"), 1));

        return (strcmp($fin, $suffix) === 0);
    }

    function add_user($email, $password) {
        $activation_code = $this->_generate_activation_code();

        $userLine = '';

        $userLine .= $email;
        $userLine .= '#';
        $userLine .= $password;
        $userLine .= '#';
        $userLine .= $activation_code;
        $userLine .= "\n";

        if (is_writable($this->path)) {

            // In our example we're opening database in append mode.
            // The file pointer is at the bottom of the file hence
            // that's where $userLine will go when we fwrite() it.
            if (!$databaseFile = fopen($this->path, 'a')) {
                 echo "Cannot open file ($this->path)";
                 exit;
            }
        
            // Write $userLine to our opened file.
            if (fwrite($databaseFile, $userLine) === FALSE) {
                echo "Cannot save $email to the database";
                exit;
            }
                    
            $emailSender = new EmailSender();

            $emailSender->send_activation($email, $activation_code);

            fclose($databaseFile);
        }
        else {
            echo "The file $this->path is not writable";
        }
    }

    function _generate_activation_code($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    function email_exists($email) {
        try {
            $database = fopen($this->path, 'r'); 

            if ($database) {
                $array = explode("\n", fread($database, filesize($this->path)));
            }

            foreach ($array as &$linea) {
                if (strpos($linea, $email) === 0) {
                    return true;
                }
            }

            return false;
        }
        finally {
            fclose($database);
        }
    }

    function is_valid_login($email, $password) {
        try {
            $database = fopen($this->path, 'r'); 

            if ($database) {
                $array = explode("\n", fread($database, filesize($this->path)));
            }

            foreach ($array as &$linea) {
                if (strpos($linea, $email) === 0) {
                    if ($this->check_login($linea, $email, $password)) {
                        return true; // salir del bucle al haber hecho login válido
                    }
                }
            }

            return false;
        }
        finally {
            fclose($database);
        }
    }

    private function check_login($userLine, $email, $password) {
        $array = explode("#", $userLine);

        if ($email === $array[0]) {
            if ($password === $array[1]) {
                if ("ACTIVADO" === $array[2]) {
                    echo "<h1>Usuario Activado</h1>";
                }
                else {
                    echo "<h1>Usuario NO activado!!</h1>";
                }

                return true;
            }
        }

        return false;
    }

} 

?> 