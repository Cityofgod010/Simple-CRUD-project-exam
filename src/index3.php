<?php
session_start();
require '../database.php';

// Checken voor bericht in de sessie for a message in the session
if (isset($_SESSION['message'])) {
    echo '<div id="successMessage" class="alert alert-success">' . $_SESSION['successMessage'] . '</div>';
    // Clear the message to avoid displaying it again
    unset($_SESSION['message']);
}

$stmt = $conn->prepare("SELECT * FROM inschrijvingen WHERE level = :level ORDER BY id ASC");
$level = 0;
$stmt->bindParam(':level', $level, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, password, level FROM inschrijvingen WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $loggedInUser = $records->fetch(PDO::FETCH_ASSOC);
}

$sql = "SELECT * FROM date WHERE id = 1";
$res = $conn->query($sql);
$date = $res->fetch(PDO::FETCH_ASSOC);
$datum = $date['datum'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<?php if (!empty($loggedInUser)): ?>
    <div class="container">
        <?php if (isset($_SESSION['successMessage'])): ?>
            <div class="alert alert-success" role="alert">
                <?= $_SESSION['successMessage'] ?>
            </div>
            <?php unset($_SESSION['successMessage']); ?>
        <?php endif; ?>

        <h1 class="text-center"> Welcome, <?= $loggedInUser['email']; ?>!</h1>

        <table class="table">
            <thead>
            <tr>
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
            <?php
            // Weergeven van de resultaten
            foreach ($users as $user_data) {
                echo "<tr>";
                echo "<td>".$user_data['id']."</td>";
                echo "<td>".$user_data['naam']."</td>";
                echo "<td>".$user_data['adres']."</td>";
                echo "<td>".$user_data['woonplaats']."</td>";
                echo "<td>".$user_data['email']."</td>";
                echo "<td>".$user_data['telefoonnummer']."</td>";
                echo "<td>".$user_data['Geboortedatum']."</td>";
                echo "<td>".$user_data['geslacht']."</td>";
                echo "<td> <a class='btn btn-primary' href='edit2.php?id=".$user_data['id']."'>Edit</a></td>";
                echo "<td> <a class='btn btn-primary' href='delete2.php?id=".$user_data['id']."'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>

        <div class="float-left mb-2">
            <a class="btn btn-secondary" href="index.php">Home</a>
            <a class="btn btn-danger" href="logout.php">Sign out</a>
        </div>
    </div>
<?php else: ?>
<!--    <h1 class="text-center"></h1>-->
    <a class="btn btn-secondary centered-button" href="login.php">Return</a>
<?php endif; ?>
</body>
</html>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $("#successMessage").fadeOut("slow", function() {
                $(this).remove();
            });
        }, 2500); // 2500 millisecondes (2.5 secondes)
    });
</script>
