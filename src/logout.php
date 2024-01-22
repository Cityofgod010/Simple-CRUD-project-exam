<?php
// het uitloggen je sessie met jou id word gedestroyed en je word terug gestuurt naar de login
  session_start();
  session_unset();
  session_destroy();
  header('Location: login.php'); // stuurt gebruiker weer terug naar login pagina
?>
