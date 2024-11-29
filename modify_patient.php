<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Modify Patient</title>
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

        select, input[type="text"], input[type="number"], input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        select:focus, input[type="text"]:focus, input[type="number"]:focus, input[type="date"]:focus {
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

// Function to convert pounds to kilograms
function pounds_to_kg($pounds) {
    return round($pounds * 0.453592, 2);
}

// Function to convert feet and inches to meters
function feet_inches_to_meters($feet, $inches) {
    $total_inches = ($feet * 12) + $inches;
    return round($total_inches * 0.0254, 2);
}

// Fetch patient details if a patient is selected
if (isset($_POST['select_patient'])) {
    $ohip = $_POST['ohip'];
    $patient_query = "SELECT * FROM patient WHERE ohip = '$ohip'";
    $patient_result = mysqli_query($connection, $patient_query);
    $patient = mysqli_fetch_assoc($patient_result);
}

// Update patient details if modifications are submitted
if (isset($_POST['modify_patient'])) {
    $ohip = $_POST['ohip'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthdate = $_POST['birthdate'];
    $treatsdocid = $_POST['treatsdocid'];

    // Handle weight (convert to kg if entered in pounds)
    if ($_POST['weight_unit'] == 'pounds') {
        $weight = pounds_to_kg($_POST['weight']);
    } else {
        $weight = $_POST['weight'];
    }

    // Handle height (convert to meters if entered in feet/inches)
    if ($_POST['height_unit'] == 'feet_inches') {
        $height = feet_inches_to_meters($_POST['height_feet'], $_POST['height_inches']);
    } else {
        $height = $_POST['height'];
    }

    // Update the patient record
    $update_query = "UPDATE patient SET firstname = '$firstname', lastname = '$lastname', weight = '$weight', birthdate = '$birthdate', height = '$height', treatsdocid = '$treatsdocid' WHERE ohip = '$ohip'";
    if (mysqli_query($connection, $update_query)) {
        echo "<div class='success-message'>Patient details successfully updated!</div>";
    } else {
        echo "<div class='error-message'>Error updating patient details: " . mysqli_error($connection) . "</div>";
    }
}

// Fetch all patients for the dropdown list
$patients_query = "SELECT ohip, firstname, lastname FROM patient";
$patients_result = mysqli_query($connection, $patients_query);

?>

<div class="container">
    <a href="mainmenu.php" class="back-btn">← Back to Main Menu</a>

    <h1>Modify Patient Details</h1>

    <form method="post" action="modify_patient.php">
        <div class="form-group">
            <label>Select Patient:</label>
            <select name="ohip" required>
                <option value="">Select a patient</option>
                <?php
                while ($row = mysqli_fetch_assoc($patients_result)) {
                    echo "<option value='" . $row['ohip'] . "'>" . $row['firstname'] . " " . $row['lastname'] . " (OHIP: " . $row['ohip'] . ")</option>";
                }
                ?>
            </select>
        </div>
        <input type="submit" name="select_patient" value="Load Details" class="submit-btn">
    </form>

    <?php if (isset($patient)) : ?>
    <form method="post" action="modify_patient.php">
        <input type="hidden" name="ohip" value="<?php echo $patient['ohip']; ?>">

        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="firstname" value="<?php echo $patient['firstname']; ?>" required>
        </div>

        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="lastname" value="<?php echo $patient['lastname']; ?>" required>
        </div>

        <div class="form-group">
            <label>Birthdate:</label>
            <input type="date" name="birthdate" value="<?php echo $patient['birthdate']; ?>" required>
        </div>

        <div class="form-group">
            <label>Weight:</label>
            <input type="number" name="weight" value="<?php echo $patient['weight']; ?>" step="0.01" required>
            <label>
                <input type="radio" name="weight_unit" value="kg" checked> kg
                <input type="radio" name="weight_unit" value="pounds"> pounds
            </label>
        </div>

        <div class="form-group">
            <label>Height:</label>
            <input type="number" name="height" value="<?php echo $patient['height']; ?>" step="0.01" required>
            <label>
                <input type="radio" name="height_unit" value="meters" checked> meters
                <input type="radio" name="height_unit" value="feet_inches"> feet/inches
            </label>
            <div>
                <label>If feet/inches:</label>
                <input type="number" name="height_feet" placeholder="Feet" style="width: 50px;">
                <input type="number" name="height_inches" placeholder="Inches" style="width: 50px;">
            </div>
        </div>

        <div class="form-group">
            <label>Doctor ID (Treats Doc ID):</label>
            <input type="text" name="treatsdocid" value="<?php echo $patient['treatsdocid']; ?>" required>
        </div>

        <input type="submit" name="modify_patient" value="Update Patient" class="submit-btn">
    </form>
    <?php endif; ?>
</div>

<?php
// Close the database connection
mysqli_close($connection);
?>

</body>
</html>
