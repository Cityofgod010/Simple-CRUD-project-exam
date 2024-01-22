<?php
session_start();
    require '../database.php';     // Database connectie
// datum selecteren van waar id = 1
// Gebruik van prepared statements
$id = 1;
$stmt = $conn->prepare("SELECT * FROM date WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

// Ophalen van de resultaten
$date = $stmt->fetch(PDO::FETCH_ASSOC);
$datum = $date['datum'];
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
    <div class="topnav">
        <a class="active" href="index.php">Home</a>

        <?php
        // Check als user ingelogd is
        if (isset($_SESSION['user_id'])) {
            $userLevel = $_SESSION['user_level'];

            if ($userLevel == 1) {
                // Admin (level 1) toegang index3.php
                echo "<a href='index3.php'>Alle inschrijvingen</a>";
            } elseif ($userLevel == 0) {
                // Normale user (level 0) toegang tot alleen index2.php
                echo "<a href='index2.php'>Mijn inschrijving</a>";
            }
        }
        echo "<a class='logout' href='logout.php'>Sign out <i class='fas fa-sign-out-alt'></i></a>";
        ?>
    </div>

</head>

<body>
  <div class="text">
  <p><?php
  // checken of de datum in de database al geweest is zo niet kan je je nog inschrijven en zo wel word hij gesloten
  if (date("d-M-Y") >= $datum){
    echo "Inschrijven is op dit moment niet mogelijk!";
  }
  else{
    echo "Inschrijven kan tot $datum";
  }
  ?> </p>
    <p>Nederland gaat zijn eerste wedstrijd EK voetbal 2024 spelen in het Volksparkstadion te Hamburg. De wedstrijd wordt gespeeld op 16 juni 2024 om 15:00. Het maximum capciteit in het Volksparkstadion is 1000 mensen. Het stadion gaat een uur van te voren open zodra u het stadion betreed krijgt u een ticket met de toegewezen zitplaats.</p>
  </div>
</body>
</html>