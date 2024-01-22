<?php
require_once '../database.php';

// Check als formulier verstuurd is voor user update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $naam = $_POST['naam'];
    $adres = $_POST['adres'];
    $woonplaats = $_POST['woonplaats'];
    $email = $_POST['email'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $geboortedatum = $_POST['geboortedatum'];
    $geslacht = $_POST['geslacht'];

    try {
        // SQL prepared statement gebruiken
        $stmt = $conn->prepare("UPDATE inschrijvingen SET naam=?, adres=?, woonplaats=?, email=?, telefoonnummer=?, geboortedatum=?, geslacht=? WHERE id=?");
        $stmt->execute([$naam, $adres, $woonplaats, $email, $telefoonnummer, $geboortedatum, $geslacht, $id]);

        // Plaats een success message in de sessie
        $_SESSION['message'] = "Gebruiker is succesvol geüpdate!";

        // User doorsturen naar desbetreffende pagina met geupdate data
        header("Location: index2.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// User data pakken gebaseerd op ID van URL
$id = $_GET['id'];

try {
    // SQL prepared statement gebruiken
    $stmt = $conn->prepare("SELECT * FROM inschrijvingen WHERE id=?");
    $stmt->execute([$id]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    $naam = $user_data['naam'];
    $adres = $user_data['adres'];
    $woonplaats = $user_data['woonplaats'];
    $email = $user_data['email'];
    $telefoonnummer = $user_data['telefoonnummer'];
    $geboortedatum = $user_data['geboortedatum'];
    $geslacht = $user_data['geslacht'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UEFA EURO 2024</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
            body {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
            }
            .custom-form-container {
                width: 50%; /* Breedte van formulier verkleinen */
            }
    </style>
</head>
<body>
<div class="container custom-form-container">
    <h1 class="text-center">Wijzig hier uw gegevens</h1>
    <!-- Form for updating user's own data -->
    <form name="update_user" method="post" action="edit.php">
        <div class="mb-3">
            <label for="naam" class="form-label">Naam:</label>
            <input type="text" class="form-control" name="naam" value="<?= $naam ?>">
        </div>
        <div class="mb-3">
            <label for="adres" class="form-label">Adres:</label>
            <input type="text" class="form-control" name="adres" value="<?= $adres ?>">
        </div>
        <div class="mb-3">
            <label for="woonplaats" class="form-label">Woonplaats:</label>
            <input type="text" class="form-control" name="woonplaats" value="<?= $woonplaats ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="text" class="form-control" name="email" value="<?= $email ?>">
        </div>
        <div class="mb-3">
            <label for="telefoonnummer" class="form-label">Telefoonnummer:</label>
            <input type="text" class="form-control" name="telefoonnummer" value="<?= $telefoonnummer ?>">
        </div>
        <div class="mb-3">
            <label for="geboortedatum" class="form-label">Geboortedatum:</label>
            <input type="date" class="form-control" name="geboortedatum" value="<?= $geboortedatum ?>">
        </div>
        <div class="mb-3">
            <label for="geslacht" class="form-label">Geslacht:</label>
            <select class="form-select" name="geslacht">
                <option <?= ($geslacht == "Man") ? "selected" : "" ?> value='Man'>Man</option>
                <option <?= ($geslacht == "Vrouw") ? "selected" : "" ?> value='Vrouw'>Vrouw</option>
                <option <?= ($geslacht == "Genderneutraal") ? "selected" : "" ?> value='Genderneutraal'>Genderneutraal</option>
            </select>
        </div>
        <div class="mb-3">
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            <a class="btn btn-secondary" href="index2.php">Return</a>
            <input type="submit" class="btn btn-primary" name="update" value="Update">
        </div>
    </form>
</div>
</body>
</html>