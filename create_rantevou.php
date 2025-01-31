<?php
require_once "config.php";
$patients_sql = "SELECT id, name FROM patients";  
$patients_result = mysqli_query($link, $patients_sql);
$doctors_sql = "SELECT id, name FROM doctors";  
$doctors_result = mysqli_query($link, $doctors_sql);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $check_sql = "SELECT * FROM appointments WHERE doctor_id = ? AND appointment_date = ?";
    if ($stmt = mysqli_prepare($link, $check_sql)) {
        mysqli_stmt_bind_param($stmt, "is", $doctor_id, $appointment_date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error_message = "Υπάρχει ήδη ραντεβού για τον συγκεκριμένο γιατρό την ίδια ώρα!";
        } else {
            $insert_sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date) VALUES (?, ?, ?)";
            if ($stmt = mysqli_prepare($link, $insert_sql)) {
                mysqli_stmt_bind_param($stmt, "iis", $patient_id, $doctor_id, $appointment_date);
                if (mysqli_stmt_execute($stmt)) {
                    $success_message = "Το ραντεβού καταχωρήθηκε με επιτυχία!";
                } else {
                    $error_message = "Σφάλμα κατά την καταχώρηση του ραντεβού.";
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($link);
?>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        .form-container {
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.15);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }
        button {
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        select {
            width: 100%;
            height: 45px;
            border-radius: 8px;
            border: 1px solid gray;
            padding: 0 10px;
            font-size: 16px;
            color: #333;
            background-color: #f9f9f9;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            appearance: none;
            background-repeat: no-repeat;
            background-position: calc(100% - 10px) center;
            background-size: 12px;
        }
        select:focus {
            border-color: #007BFF;
            box-shadow: 0px 0px 8px rgba(0, 123, 255, 0.5);
            outline: none;
        }
        }
    </style>
    <meta charset="UTF-8">
    <title>Προσθήκη Ραντεβού</title>
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
    <div class="log">
        <h1>Προσθήκη Ραντεβού</h1>
        <?php 
        if (!empty($error_message)) {
            echo "<p style='color:red;'>$error_message</p>";
        } elseif (!empty($success_message)) {
            echo "<p style='color:green;'>$success_message</p>";
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <!-- Dropdown για Ασθενή -->
            <label for="patient_id">Επιλέξτε Ασθενή:</label>
            <select name="patient_id" id="patient_id" class="form-control" required>
                <?php
                if ($patients_result && mysqli_num_rows($patients_result) > 0) {
                    while ($row = mysqli_fetch_assoc($patients_result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Δεν βρέθηκαν ασθενείς</option>";
                }
                ?>
            </select>
            <label for="doctor_id">Επιλέξτε Γιατρό:</label>
            <select name="doctor_id" id="doctor_id" class="form-control" required>
                <?php
                if ($doctors_result && mysqli_num_rows($doctors_result) > 0) {
                    while ($row = mysqli_fetch_assoc($doctors_result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Δεν βρέθηκαν γιατροί</option>";
                }
                ?>
            </select>
            <label for="appointment_date">Ημερομηνία και Ώρα:</label>
            <input type="datetime-local" name="appointment_date" id="appointment_date" class="form-control" required>
            <button type="submit">Προσθήκη Ραντεβού</button>
        </form>
        <br>
        <a href="rantevou.php" style="text-align: center; display: block;">Πίσω</a>
    </div>
    <div class="footer">
        <p>&copy;</p>
    </div>
</body>
</html>
