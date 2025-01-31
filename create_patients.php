<?php 
require_once "config.php";
$name = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    if (!empty($name)) {
        $sql = "INSERT INTO patients (name) VALUES (?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            $param_name = $name;
            if (mysqli_stmt_execute($stmt)) {
                header("location: astheneis.php");
                exit();
            } else {
                echo "Oops! Κάτι πήγε στραβά. Δοκιμάστε ξανά.";
            }
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Παρακαλώ εισάγετε ένα όνομα.";
    }
}
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Προσθήκη Ασθενή</title>
    <link rel="stylesheet" href="css.css"> <!-- Εισαγωγή του υπάρχοντος CSS -->
</head>
<body>
    <!-- Navigation Bar -->
    <div class="nav" align="center">
        <a href="giatroi.php">Γιατροί</a>
        <a href="astheneis.php">Ασθενείς</a>
        <a href="rantevou.php">Ραντεβού</a>
        <a href="logout.php" class="logout-link"><div class="logoutb">Logout</div></a>
        <div class="menu-name"><a href="menu.php"><u>Διαχείριση Κλινικής</u></a></div>
    </div>

    <!-- Form Section -->
    <div class="log">
        <h1>Προσθήκη Ασθενή</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Όνομα</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo $name; ?>" placeholder="Εισάγετε όνομα">
            <button type="submit">Προσθήκη</button>
        </form>
        <br>
        <a href="astheneis.php" style="text-align: center; display: block;">Άκυρο</a>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy;</p>
    </div>
</body>
</html>
