<?php 
class UsuariosDatabase { 
    var $path = '/tmp/database.txt';

    // constructor por defecto de PHP
    function __construct() {
        if (!file_exists($this->path)) {
            $adtabase = fopen($this->path, 'w');
            fclose($database);
        }
    }

    function add_user($email, $password) {
        $activation_code = $this->_generate_activation_code();

        $userLine = '';

        $userLine .= $email;
        $userLine .= '#';
        $userLine .= $password;
        $userLine .= '#';
        $userLine .= $activation_code;
        $userLine .= "\r\n";

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

            fclose($databaseFile);
        }
        else {
            echo "The file $this->path is not writable";
        }

        return $activation_code;
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