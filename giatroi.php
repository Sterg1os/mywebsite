<?php 
session_start();
if (empty($_SESSION['logged_in'])) {
	header("Location:login.php");
	exit;
}
$username = $_SESSION['username'];
?>
<htmL>
<head>
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
$sql = "SELECT * FROM doctors";
if ($result = mysqli_query($link, $sql)) {
	if (mysqli_num_rows($result) > 0) {
		echo '<table>';
		echo "<caption>Γιατροί</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>Id</th>";
		echo "<th>Όνομα</th>";
		echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<tr>";
		echo "<td>" . $row['id'] . "</td>";
		echo "<td>" . $row['name'] . "</td>";
	echo "</tr>";
	}
}
}
?>
</table>
<br>
<center>
<a href="create_doctors.php" class="add-button">Προσθήκη Γιατρού</a>
</center>
<div class="footer">
  <p>&copy;</p>
</div>
</body>
</html>