<!DOCTYPE HTML>
<html>
    <head>
        <title>Activate</title>
        <link rel = "stylesheet" href = "css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <h2>Activate User</h2> 
      <div class = "container form-signin">
        <?php
            $msg = '';
            
            if (!empty($_POST['email']) && !empty($_POST['code'])) {

                include("users-db.php");

                $email = $_POST["email"];
                $code = $_POST["code"];
                
                $database = new UsuariosDatabase();
                
                $exists = $database->email_exists($email);
                
                if ($exists == false) {
                    $msg = "El email $email no existe. Lo siento!";
                }
                else {
                    $msg = $database->activate_user($email, $code);
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
                        <label for="code">Code</label>
                    </td>
                    <td>
                    <input type = "text" class = "form-control" 
                        name = "code" placeholder = "Introduce tu código de activación" 
                        required autofocus />
                    </td>
                </tr>
            </table>
 
            <button class="btn btn-lg btn-primary btn-block"
                type="submit" name="activate">
                    Activate
            </button>
         </form>
         
         <a class="btn btn-primary" href="index.php" role="button">Volver al Inicio</a>
      </div> 
      
   </body>
</html>