// html css part for visual
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delete Patient</title>
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

        select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        select:focus, input[type="submit"]:focus {
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
include 'connectdb.php';  // Include the database connection

// Check if the form has been submitted for deletion
if (isset($_POST['delete'])) {
    $ohip = $_POST['ohip'];

    // Check if the OHIP number exists in the database
    $check_ohip_query = "SELECT * FROM patient WHERE ohip = '$ohip'";
    $check_result = mysqli_query($connection, $check_ohip_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Proceed with deletion
        $delete_query = "DELETE FROM patient WHERE ohip = '$ohip'";
        if (mysqli_query($connection, $delete_query)) {
            echo "<div class='success-message'>Patient with OHIP number $ohip has been successfully deleted.</div>";
        } else {
            echo "<div class='error-message'>Error: Could not delete patient. " . mysqli_error($connection) . "</div>";
        }
    } else {
        echo "<div class='error-message'>Error: Patient with OHIP number $ohip does not exist in the database.</div>";
    }
}

// Fetch all patients for the dropdown list
$patients_query = "SELECT ohip, firstname, lastname FROM patient";
$patients_result = mysqli_query($connection, $patients_query);
?>

<div class="container">
    <a href="mainmenu.php" class="back-btn">← Back to Main Menu</a>
    
    <h1>Delete a Patient</h1>

    <form method="post" action="delete_patient.php">
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
        
        <input type="submit" name="delete" value="Delete Patient" class="submit-btn" onclick="return confirm('Are you sure you want to delete this patient? This action cannot be undone.');">
    </form>
</div>

<?php
// Close the database connection
mysqli_close($connection);
?>

</body>
</html>
