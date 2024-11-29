<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nurse Report</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #2c5530;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f8faf8;
        }

        tr:hover {
            background-color: #f0f7f0;
        }

        .submit-btn, .back-btn {
            background-color: #2c5530;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        .submit-btn:hover, .back-btn:hover {
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

// Fetch all nurses for the dropdown list
$nurses_query = "SELECT nurseid, firstname, lastname FROM nurse";
$nurses_result = mysqli_query($connection, $nurses_query);

// Fetch details of the selected nurse
if (isset($_POST['select_nurse'])) {
    $nurseid = $_POST['nurseid'];

    // Fetch nurse's personal information and supervisor details
    $nurse_info_query = "
        SELECT n1.firstname AS nurse_firstname, n1.lastname AS nurse_lastname, 
               n2.firstname AS supervisor_firstname, n2.lastname AS supervisor_lastname
        FROM nurse n1
        LEFT JOIN nurse n2 ON n1.reporttonurseid = n2.nurseid
        WHERE n1.nurseid = '$nurseid'
    ";
    $nurse_info_result = mysqli_query($connection, $nurse_info_query);

    if (!$nurse_info_result) {
        die("Error fetching nurse information: " . mysqli_error($connection));
    }

    $nurse_info = mysqli_fetch_assoc($nurse_info_result);

    // Fetch doctors the nurse works with and hours worked
    $doctor_hours_query = "
        SELECT doctor.firstname AS doctor_firstname, doctor.lastname AS doctor_lastname, 
               workingfor.hours
        FROM workingfor
        JOIN doctor ON workingfor.docid = doctor.docid
        WHERE workingfor.nurseid = '$nurseid'
    ";
    $doctor_hours_result = mysqli_query($connection, $doctor_hours_query);

    $total_hours = 0;
    $doctor_hours = []; // Store each doctor-hour record in an array
    while ($row = mysqli_fetch_assoc($doctor_hours_result)) {
        $total_hours += $row['hours'];
        $doctor_hours[] = $row;
    }
}
?>

<div class="container">
    <a href="mainmenu.php" class="back-btn">← Back to Main Menu</a>

    <h1>Nurse Report</h1>

    <form method="post" action="nurse_report.php">
        <label>Select Nurse:</label>
        <select name="nurseid" required>
            <option value="">Select a nurse</option>
            <?php
            while ($row = mysqli_fetch_assoc($nurses_result)) {
                echo "<option value='" . $row['nurseid'] . "'>" . $row['firstname'] . " " . $row['lastname'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" name="select_nurse" value="Generate Report" class="submit-btn">
    </form>

    <?php if (isset($nurse_info)) : ?>
        <h2>Nurse Information</h2>
        <p><strong>Name:</strong> <?php echo $nurse_info['nurse_firstname'] . " " . $nurse_info['nurse_lastname']; ?></p>
        <p><strong>Supervisor:</strong> <?php echo $nurse_info['supervisor_firstname'] . " " . $nurse_info['supervisor_lastname']; ?></p>

        <h2>Doctors and Hours Worked</h2>
        <?php if (!empty($doctor_hours)) : ?>
            <table>
                <tr>
                    <th>Doctor First Name</th>
                    <th>Doctor Last Name</th>
                    <th>Hours Worked</th>
                </tr>
                <?php foreach ($doctor_hours as $doctor) : ?>
                    <tr>
                        <td><?php echo $doctor['doctor_firstname']; ?></td>
                        <td><?php echo $doctor['doctor_lastname']; ?></td>
                        <td><?php echo $doctor['hours']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <p><strong>Total Hours Worked:</strong> <?php echo $total_hours; ?></p>
        <?php else : ?>
            <p class="no-patient">This nurse has not worked with any doctors yet.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php
// Close the database connection
mysqli_close($connection);
?>

</body>
</html>
