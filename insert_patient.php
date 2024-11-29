<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Insert New Patient</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f7f0;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
        }

        h1 {
            color: #2c5530;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5em;
            border-bottom: 3px solid #2c5530;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #2c5530;
            font-weight: bold;
        }

        .ohip-container {
            display: flex;
            gap: 4px;
            margin-bottom: 20px;
        }

        .ohip-container input {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 1.2em;
            border: 2px solid #2c5530;
            border-radius: 5px;
            text-transform: uppercase;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus,
        .ohip-container input:focus {
            outline: none;
            border-color: #2c5530;
            box-shadow: 0 0 5px rgba(44, 85, 48, 0.2);
        }

        .submit-btn {
            background-color: #2c5530;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background-color: #1a331d;
            transform: translateY(-2px);
        }

        .back-btn {
            display: inline-block;
            background-color: #2c5530;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background-color: #1a331d;
            transform: translateY(-2px);
        }

        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #d6e9c6;
        }

        .error-message {
            background-color: #f2dede;
            color: #a94442;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #ebccd1;
        }
    </style>
</head>
<body>

<?php
include 'connectdb.php';

if (isset($_POST['submit'])) {
    $ohip = strtoupper($_POST['ohip1'] . $_POST['ohip2'] . $_POST['ohip3'] . $_POST['ohip4'] . $_POST['ohip5'] . $_POST['ohip6'] . $_POST['ohip7'] . $_POST['ohip8'] . $_POST['ohip9']);
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $weight = $_POST['weight'];
    $birthdate = $_POST['birthdate'];
    $height = $_POST['height'];
    $doctor_id = $_POST['doctor'];

    $check_ohip_query = "SELECT * FROM patient WHERE ohip = '$ohip'";
    $check_result = mysqli_query($connection, $check_ohip_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<div class='error-message'>Error: The OHIP number $ohip is already in use. Please enter a unique OHIP number.</div>";
    } else {
        $insert_query = "INSERT INTO patient (ohip, firstname, lastname, weight, birthdate, height, treatsdocid)
                         VALUES ('$ohip', '$firstname', '$lastname', '$weight', '$birthdate', '$height', '$doctor_id')";

        if (mysqli_query($connection, $insert_query)) {
            echo "<div class='success-message'>Patient successfully added!</div>";
        } else {
            echo "<div class='error-message'>Error: Could not add patient. " . mysqli_error($connection) . "</div>";
        }
    }
}

$doctors_query = "SELECT docid, firstname, lastname FROM doctor";
$doctors_result = mysqli_query($connection, $doctors_query);
?>

<div class="container">
    <a href="mainmenu.php" class="back-btn">← Back to Main Menu</a>
    
    <h1>Insert New Patient</h1>

    <form method="post" action="insert_patient.php">
        <div class="form-group">
            <label>OHIP Number:</label>
            <div class="ohip-container">
                <?php
                for ($i = 1; $i <= 9; $i++) {
                    echo "<input type='text' name='ohip$i' maxlength='1' pattern='[A-Za-z0-9]' title='Only numbers and letters allowed' required>";
                }
                ?>
            </div>
        </div>

        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="firstname" required>
        </div>

        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="lastname" required>
        </div>

        <div class="form-group">
            <label>Weight (kg):</label>
            <input type="number" step="0.01" name="weight" required>
        </div>

        <div class="form-group">
            <label>Birthdate:</label>
            <input type="date" name="birthdate" required>
        </div>

        <div class="form-group">
            <label>Height (meters):</label>
            <input type="number" step="0.01" name="height" required>
        </div>

        <div class="form-group">
            <label>Assign Doctor:</label>
            <select name="doctor" required>
                <option value="">Select a doctor</option>
                <?php
                while ($row = mysqli_fetch_assoc($doctors_result)) {
                    echo "<option value='" . $row['docid'] . "'>Dr. " . $row['firstname'] . " " . $row['lastname'] . "</option>";
                }
                ?>
            </select>
        </div>

        <input type="submit" name="submit" value="Add Patient" class="submit-btn">
    </form>
</div>

<?php
mysqli_close($connection);
?>

<script>
// Add automatic focus movement for OHIP input fields
document.querySelectorAll('.ohip-container input').forEach((input, index) => {
    input.addEventListener('input', function() {
        if (this.value && index < 8) {
            document.querySelector(`input[name="ohip${index + 2}"]`).focus();
        }
    });
    
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value && index > 0) {
            document.querySelector(`input[name="ohip${index}"]`).focus();
        }
    });
});
</script>

</body>
</html>