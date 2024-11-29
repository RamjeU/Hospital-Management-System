<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Doctor-Patient List</title>
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

        h2 {
            color: #2c5530;
            margin-top: 20px;
            font-size: 1.5em;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 5px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        li {
            background-color: #f8faf8;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
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

        .no-patient {
            color: #a94442;
        }
    </style>
</head>
<body>

<?php
include 'connectdb.php';  // Include the database connection

// Query to fetch doctors and their patients
$query = "SELECT doctor.docid, doctor.firstname AS doctor_firstname, doctor.lastname AS doctor_lastname, 
                 patient.firstname AS patient_firstname, patient.lastname AS patient_lastname
          FROM doctor
          LEFT JOIN patient ON doctor.docid = patient.treatsdocid
          ORDER BY doctor.docid";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($connection));
}
?>

<div class="container">
    <a href="mainmenu.php" class="back-btn">← Back to Main Menu</a>

    <h1>Doctor-Patient List</h1>

    <?php
    // Initialize variables to track the current doctor
    $current_doctor_id = null;

    // Loop through results to display doctor and patient information
    while ($row = mysqli_fetch_assoc($result)) {
        // Check if we are displaying a new doctor
        if ($row['docid'] !== $current_doctor_id) {
            // Close previous list if it exists
            if ($current_doctor_id !== null) {
                echo "</ul>";
            }

            // Display doctor information
            echo "<h2>Dr. " . $row['doctor_firstname'] . " " . $row['doctor_lastname'] . " (ID: " . $row['docid'] . ")</h2>";
            echo "<ul>";
            $current_doctor_id = $row['docid'];
        }

        // Display patient information if the doctor has patients
        if ($row['patient_firstname'] !== null) {
            echo "<li>Patient: " . $row['patient_firstname'] . " " . $row['patient_lastname'] . "</li>";
        } else {
            echo "<li class='no-patient'>No patients assigned</li>";
        }
    }

    // Close the last list
    if ($current_doctor_id !== null) {
        echo "</ul>";
    }
    ?>
</div>

<?php
// Close the database connection
mysqli_close($connection);
?>

</body>
</html>
