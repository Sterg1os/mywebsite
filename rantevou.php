<?php 
session_start();
if (empty($_SESSION['logged_in'])) {
    header("Location:login.php");
    exit;
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Διαχείριση Κλινικής</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>

<div class="nav" align="center">
    <a href="giatroi.php">Γιατροί</a>
    <a href="astheneis.php">Ασθενείς</a>
    <a href="rantevou.php">Ραντεβού</a>
    <a href="logout.php" class="logout-link"><div class="logoutb">Logout</div></a>
    <div class="menu-name"><a href="menu.php"><u>Διαχείριση Κλινικής</u></a></div>
</div>

<?php 
require_once "config.php";

// Ερώτημα για τα διαθέσιμα ραντεβού (με τα ονόματα ασθενών και γιατρών)
$sql = "SELECT a.id, a.appointment_date, d.name AS doctor_name, p.name AS patient_name
        FROM appointments a 
        JOIN doctors d ON a.doctor_id = d.id
        JOIN patients p ON a.patient_id = p.id
        WHERE a.appointment_date > NOW() 
        ORDER BY a.appointment_date ASC";

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo '<table>';
        echo "<caption>Διαθέσιμα Ραντεβού</caption>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Γιατρός</th>";
        echo "<th>Ασθενής</th>";
        echo "<th>Ημερομηνία Ραντεβού</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        // Εμφάνιση των διαθέσιμων ραντεβού
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['doctor_name'] . "</td>";
            echo "<td>" . $row['patient_name'] . "</td>";
            echo "<td>" . $row['appointment_date'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "";
    }
} else {
    echo "Σφάλμα κατά την εκτέλεση του αιτήματος.";
}

mysqli_close($link);
?>
<center>
<a href="create_rantevou.php" class="add-button">Προσθήκη Ραντεβού</a>
</center>
<div class="footer">
  <p>&copy;</p>
</div>

</body>
</html>
