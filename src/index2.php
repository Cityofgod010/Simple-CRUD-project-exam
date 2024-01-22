<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<style>
    body {
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
    }

    .content-container {
        text-align: center;
        margin-top: 20px;
    }

    .centered-button {
        margin: 0 10px;
    }
</style>

<body>
<?php
session_start();
// ini_set('display_errors', 1);
// ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once '../database.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare('SELECT * FROM inschrijvingen WHERE id = :id ORDER BY id DESC');
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // User data oppakken
    if (!empty($result)) {
        $user = $result[0];
    } else {
        $user = null;
    }
} else {
    $user = null;
}

// Check als formulier is verstuurd voor de user geupdate data
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

        // Succes bericht voor geupdate data
        $successMessage = "Je gegevens zijn succesvol gewijzigd!";
    } catch (PDOException $e) {
        $errorMessage = "Er is een fout opgetreden bij het wijzigen van je gegevens: " . $e->getMessage();
    }
}
?>

<?php if(!empty($user)): ?>
    <div class="container">
        <h1 class="text-center">Welkom, <?= $user['naam'] ?>!</h1>

        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success" id="successMessage">
                <strong>Succes:</strong> <?= $successMessage ?>
            </div>
        <?php endif; ?>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID #</th>
                <th scope="col">Naam</th>
                <th scope="col">Adres</th>
                <th scope="col">Woonplaats</th>
                <th scope="col">Email</th>
                <th scope="col">Telefoonnummer</th>
                <th scope="col">Geboortedatum</th>
                <th scope="col">Geslacht</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['naam'] ?></td>
                <td><?= $user['adres'] ?></td>
                <td><?= $user['woonplaats'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['telefoonnummer'] ?></td>
                <td><?= $user['Geboortedatum'] ?></td>
                <td><?= $user['geslacht'] ?></td>
                <td><a class='btn btn-primary' href='edit.php?id=<?= $user['id'] ?>'>Edit</a></td>
                <td><a class='btn btn-primary' href='delete2.php?id=<?= $user['id'] ?>'>Delete</a></td>
            </tr>
            </tbody>
        </table>

        <a class="btn btn-secondary" href="index.php">Home</a>
        <span>
                <a class="btn btn-danger" href="logout.php">Sign out</a>
            </span>
    </div>
<?php else: ?>
    <div class="content-container">
        <h1>Tot ziens</h1>
        <div class="button-container">
            <a class="btn btn-secondary centered-button" href="login.php">Log in</a>
            or
            <a class="btn btn-primary centered-button" href="signup.php">Sign up</a>
        </div>
    </div>
<?php endif; ?>
</body>
</html>