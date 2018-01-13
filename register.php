<!DOCTYPE HTML>
<html>
    <head>
        <title>Register</title>
        <link rel = "stylesheet" href = "css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <h2>Register</h2> 
      <div class = "container form-signin">
        <?php
            $msg = '';
            
            if (!empty($_POST['email']) && !empty($_POST['password'])) {

                include("users-db.php");

                $email = $_POST["email"];
                $password = $_POST["password"];
                
                $database = new UsuariosDatabase();
                
                $exists = $database->email_exists($email);
                
                if ($exists == true) {
                    $msg = "El email $email ya existe. Lo siento!";
                }
                else {
                    $database->add_user($email, $password);

                    $msg = "Usuario creado con éxito. Se ha enviado un email a $email con el código de activación.";
                }
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
      
         <form class = "form-signin"
               role = "form"
               action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
               method = "post">

            <h4 class = "form-signin-heading">
                <?php echo $msg; ?>
            </h4>

            <table>
                <tr>
                    <td>
                        <label for="email">E-mail</label>
                    </td>
                    <td>
                    <input type = "text" class = "form-control" 
                        name = "email" placeholder = "Escribe aquí tu email" 
                        required autofocus />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email">Password</label>
                    </td>
                    <td>
                    <input type = "password" class = "form-control" 
                        name = "password" placeholder = "Introduce tu password" 
                        required autofocus />
                    </td>
                </tr>
            </table>
 
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "register">Register</button>
         </form>
         
         <a class="btn btn-primary" href="index.php" role="button">Volver al Inicio</a>
      </div> 
      
   </body>
</html>