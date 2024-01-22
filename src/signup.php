<?php
// DB connectie
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require '../database.php';
// de datum waar id 1 is pakken uit de database
$id = 1;
$stmt = $conn->prepare("SELECT * FROM date WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
// Ophalen van de resultaten
$date = $stmt->fetch(PDO::FETCH_ASSOC);
$datum = $date['datum'];
// als het na de inschrijf datum is word je terug gestuurd naar de home pagina
if (date("d-m-Y") >= $datum){
    header("location: index.php");
}

// hij telt alle gebruikers die level 0 zijn op zodat hij niet boven de 1000 inschrijvingen kan komen
$sql = ("SELECT COUNT(*) as aantal FROM inschrijvingen WHERE level ='0'");
$stmt = $conn->prepare($sql);
$stmt->execute();
$record = $stmt->fetch();

// als hij op de 1000 komt gaat hij dicht
if ($record["aantal"] >= 1000) {
    echo "<p> The maximum amount of visitors has been reached</p>";
} else {
if ($record["aantal"] < 1000) {

    $message = '';
    // stop alle informatie die je in je invoervelden stopt in de database
    if (!empty($_POST['naam']) && !empty($_POST['adres']) && !empty($_POST['woonplaats']) && !empty($_POST['email']) && !empty($_POST['telefoonnummer']) && !empty($_POST['geboortedatum']) && !empty($_POST['geslacht']) && !empty($_POST['password'])) {
        var_dump($_POST); // Debugging line
      $sql = ("INSERT INTO inschrijvingen (naam, adres, woonplaats, email, telefoonnummer, geboortedatum, geslacht, password, level) VALUES (:naam, :adres, :woonplaats, :email, :telefoonnummer, :geboortedatum, :geslacht, :password, :level)");
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':naam', $_POST['naam']);
      $stmt->bindParam(':adres', $_POST['adres']);
      $stmt->bindParam(':woonplaats', $_POST['woonplaats']);
      $stmt->bindParam(':email', $_POST['email']);
      $stmt->bindParam(':telefoonnummer', $_POST['telefoonnummer']);
      $stmt->bindParam(':geboortedatum', $_POST['geboortedatum']);
      $stmt->bindParam(':geslacht', $_POST['geslacht']);
      $level = 0; // Stel hier de gewenste waarde in.
      $stmt->bindParam(':level', $level);
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $stmt->bindParam(':password', $password);

      if ($stmt->execute()) {
          $message = '<div class="alert alert-success" role="alert">Successfully created new user.</div>';
          header("Location: index.php");
      } else {
          //            $errorInfo = $stmt->errorInfo(); // Checken via error info of er niks mist met de informatie die doorgestuurd wordt

          $message = '<div class="alert alert-danger" role="alert">Sorry, there must have been an issue creating your account.</div>';
      }
    }
?>
    <!DOCTYPE html>
    <html>

    <head>
      <meta charset="utf-8">
        <title>Sign Up</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    </head>

    <body>
      <?php if (!empty($message)) : ?>
        <p> <?= $message ?></p>
      <?php endif; ?>

      <h1 style="text-align:center">Aanmelden</h1>
      <!-- signup formulier -->
    </body>
    <form action="signup.php" method="POST" class="col-lg-6 offset-lg-3">
            <div class="row justify-content-center">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Naam:</label>
        <input type="text" class="form-control" name="naam" placeholder="Vul uw volledige naam in...">
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Adres:</label>
        <input type="text" class="form-control" name="adres" placeholder="Vul uw straatnaam & nr. in...">
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Woonplaats:</label>
        <input type="text" class="form-control" name="woonplaats" placeholder="Vul uw woonplaats in...">
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">E-mailadres:</label>
        <input type="email" class="form-control" name="email" placeholder="Vul uw email in...">
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Telefoonnummer:</label>
        <input type="text" class="form-control" name="telefoonnummer" placeholder="Vul uw telefoonnummer in..">
    </div>

    <div class="mb-3">
        <input class="form-control" name="geboortedatum" type="date">
    </div>

    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Selecteer uw geslacht:</label>
        <select class="form-select" name="geslacht" tabindex="3">
        <option value='man'>Man</option>
        <option value='vrouw'>Vrouw</option>
        <option value='genderneutraal'>Genderneutraal</option>
    </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Wachtwoord:</label>
        <input class="form-control" id="exampleInputPassword1" name="password" type="password" placeholder="Vul uw wachtwoord in...">
    </div>

    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Bevestig wachtwoord:</label>
        <input class="form-control" id="exampleInputPassword1" name="password" type="password" placeholder="Bevestig uw wachtwoord in...">
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Remember Me</label>
        <p style="text-align:center">Al een account? <a href="login.php">Login</a></p>
    </div>
    <input class="btn btn-primary" type="submit" value="Submit" style="width:10%">
    </form>
<?php
  }
}
?>
    </html>