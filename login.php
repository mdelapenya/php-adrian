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
            
            if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
				
               if ($_POST['email'] == 'Manu' && 
                  $_POST['password'] == '1234') {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['email'] = 'Manu';
                  
                  $msg = 'You have entered valid use name and password';
               }
               else {
                  $msg = 'Wrong email or password';
               }
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
      
         <form class = "form-signin"
               role = "form"
               action = "<?php echo htmlspecialchars('login-check.php'); ?>"
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
            
         <a class="btn btn-primary" href="index.php" role="button">Volver al Inicio</a>
         
      </div> 
      
   </body>
</html>