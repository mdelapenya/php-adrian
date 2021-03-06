<!DOCTYPE HTML>
<html>
    <head>
        <title>Ejemplo</title>
        <link rel = "stylesheet" href = "css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <h2>Enter Username and Password</h2> 
      <div class = "container form-signin">
         
         <?php
            $msg = '';
            
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
				
                include("users-db.php");

                $email = $_POST["email"];
                $password = $_POST["password"];
                
                $database = new UsuariosDatabase();
                
                $msg = $database->is_valid_login($email, $password);

                if (strcmp($msg, "Usuario Activado") === 0) {
                    session_start();
                }
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">

        <?php
            if (!isset($_SESSION) ) {
        ?>      
         <form class = "form-signin"
               role = "form"
               action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
               method = "post">

            <h4 class = "form-signin-heading">
                <?php echo $msg; ?>
            </h4>

            <input type = "text" class = "form-control" 
               name = "email" placeholder = "Introduce tu email" 
               required autofocus />
            <br />
            <input type = "password" class = "form-control"
               name = "password" placeholder = "Introduce tu password" required />
            <br />
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
         </form>
        <?php
        }
        else {
            echo "<h1>Usuario: $email ha entrado en el sistema.</h1>";
        }
        ?>
         <a class="btn btn-primary" href="index.php" role="button">Volver al Inicio</a>
         
      </div> 
      
   </body>
</html>