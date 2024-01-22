<?php
session_start();
require '../database.php';

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    $userLevel = $_SESSION['user_level'];

    if ($userLevel == 1) {
        header("Location: index3.php");
        exit();
    } else {
        header("Location: index2.php");
        exit();
    }
}

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email, password, level FROM inschrijvingen WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute([':email' => $_POST['email']]);
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = 'Successful log in!';

    $count = $records->rowCount();
    if ($count > 0 && password_verify($_POST['password'], $results['password'])) {
        $_SESSION['user_id'] = $results['id'];
        $_SESSION['user_level'] = $results['level'];
        $level = $results['level'];

        if ($level == 1) {
            header("Location: index.php");
            exit();
        } else {
            header("Location: index.php");
            exit();
        }
    } else {
        $message = '<div id="errorMessage" class="alert alert-danger" role="alert">Login credentials wrong.</div>';
    }
}
//if ($stmt->execute()) {
//    $message = '<div class="alert alert-success" role="alert">Successfully created new user.</div>';
//    header("Location: index.php");
//} else {
//    //            $errorInfo = $stmt->errorInfo(); // Checken via error info of er niks mist met de informatie die doorgestuurd wordt
//
//    $message = '<div class="alert alert-danger" role="alert">Sorry, there must have been an issue creating your account.</div>';
//}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Log In</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
<?php if(!empty($message)): ?>
    <?= $message ?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<?php endif; ?>

<h1 style="text-align:center">Login</h1>
<!-- Inlog formulier -->
<form action="login.php" method="POST" class="col-lg-6 offset-lg-4">
    <div class="row justify-content-center">

            <div class="mb-3">
                <label for="email" class="form-label">E-mailadres:</label>
                <input type="text" class="form-control" name="email" placeholder="Vul uw email in...">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Wachtwoord:</label>
                <input class="form-control" name="password" type="password" placeholder="Vul uw wachtwoord in...">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input">
                <label class="form-check-label" for="check">Remember Me</label>
                <p style="text-align:center">Nog geen account? <a href="signup.php">Hier aanmelden</a></p>
            </div>
            <input class="btn btn-primary" type="submit" value="Submit" style="width:10%">
    </form>
  </body>
</html>

<script>
    $(document).ready(function() {
        // Use JavaScript/jQuery to hide the alert after a certain time
        setTimeout(function() {
            $("#errorMessage").fadeOut("slow", function() {
                // Optional: You can remove the alert from the DOM after fading out
                $(this).remove();
            });
        }, 2500); // 5000 milliseconds (5 seconds) - adjust as needed
    });
</script>
