<?php
// Database connectie file toevoegen
require_once  '../database.php';

// Pak het id van de user die verwijderd wordt
$id = $_GET['id'];

try {
    // Bereid de SQL query voor
    $stmt = $conn->prepare("DELETE FROM inschrijvingen WHERE id = :id");

    // Bind het id aan de parameter in de query
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Voer de query uit
    $stmt->execute();

    // Redirect terug naar de admin pagina
    header("Location: index3.php");
    exit();
} catch (PDOException $e) {
    // Hier kun je eventuele foutafhandeling toevoegen
    echo "Error: " . $e->getMessage();
}
// Sluit de databaseverbinding (niet strikt noodzakelijk vanwege PDO automatische sluiting, maar het kan nuttig zijn)
$conn = null;
?>
