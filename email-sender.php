<?php
class EmailSender {
    function __construct() {
    }

    function send_activation($to, $activation_code) {
        $title = "Activación de Usuario";

        $message = "Bienvenido a la web!\r\n\r\n";
        $message .= "Por favor activa tu usuario con el siguinte código de activación $activation_code ";

        $this->send($to, $title, $message);
    }

    private function send($to, $title, $message) {
        $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $title, $message, $headers);
    }
}
?>