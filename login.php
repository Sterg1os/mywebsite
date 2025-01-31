<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = "admin";
    $password = "1234";

    $inputUsername = $_POST['username'] ?? '';
    $inputPassword = $_POST['password'] ?? '';

    if ($inputUsername === $username && $inputPassword === $password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: menu.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Διαχείριση Κλινικής - Login</title>
    <style>
        body{
            background-image: radial-gradient(circle,lightblue,blue);
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <div class="log">
        <h1>Login</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="username"><font color="black">Username</font></label><br>
            <input type="text" name="username" id="username" required><br>
            <label for="password"><font color="black">Password</font></label><br>
            <input type="password" name="password" id="password" required><br>
            <br>
            <br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>