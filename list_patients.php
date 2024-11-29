<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>List of Patients</title>
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
            max-width: 1200px;
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

        .sort-form {
            background-color: #f8faf8;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border: 1px solid #e0e0e0;
        }

        .form-group {
            margin: 10px 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .form-group label {
            font-weight: bold;
            color: #2c5530;
            min-width: 80px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .submit-btn {
            background-color: #2c5530;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background-color: #1a331d;
            transform: translateY(-2px);
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
    </style>
</head>
<body>

<?php
include 'connectdb.php';

$order_by = isset($_POST['order_by']) ? $_POST['order_by'] : 'lastname';
$order_dir = isset($_POST['order_dir']) ? $_POST['order_dir'] : 'ASC';

$query = "SELECT patient.*, doctor.firstname AS doctor_firstname, doctor.lastname AS doctor_lastname
          FROM patient
          LEFT JOIN doctor ON patient.treatsdocid = doctor.docid
          ORDER BY $order_by $order_dir";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>

<div class="container">
    <a href="mainmenu.php" class="back-btn">← Back to Main Menu</a>
    
    <h1>List of Patients</h1>

    <form method="post" action="list_patients.php" class="sort-form">
        <div class="form-group">
            <label>Sort By:</label>
            <div class="radio-group">
                <div class="radio-option">
                    <input type="radio" name="order_by" value="lastname" <?php if ($order_by == 'lastname') echo 'checked'; ?> id="sort-lastname">
                    <label for="sort-lastname">Last Name</label>
                </div>
                <div class="radio-option">
                    <input type="radio" name="order_by" value="firstname" <?php if ($order_by == 'firstname') echo 'checked'; ?> id="sort-firstname">
                    <label for="sort-firstname">First Name</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Order:</label>
            <div class="radio-group">
                <div class="radio-option">
                    <input type="radio" name="order_dir" value="ASC" <?php if ($order_dir == 'ASC') echo 'checked'; ?> id="sort-asc">
                    <label for="sort-asc">Ascending</label>
                </div>
                <div class="radio-option">
                    <input type="radio" name="order_dir" value="DESC" <?php if ($order_dir == 'DESC') echo 'checked'; ?> id="sort-desc">
                    <label for="sort-desc">Descending</label>
                </div>
            </div>
        </div>

        <input type="submit" name="sort" value="Apply Sort" class="submit-btn">
    </form>

    <table>
        <tr>
            <th>OHIP Number</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Weight (kg / lbs)</th>
            <th>Height (cm / ft'in")</th>
            <th>Doctor</th>
        </tr>

        <?php
        function kg_to_lbs($kg) {
            return round($kg * 2.20462, 2);
        }

        function meters_to_feet_inches($meters) {
            $cm = $meters * 100;
            $inches = $cm * 0.393701;
            $feet = floor($inches / 12);
            $remaining_inches = round($inches % 12);
            return "{$feet}'{$remaining_inches}\"";
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $weight_kg = $row['weight'];
            $weight_lbs = kg_to_lbs($weight_kg);

            $height_meters = $row['height'];
            $height_feet_inches = meters_to_feet_inches($height_meters);

            echo "<tr>
                    <td>{$row['ohip']}</td>
                    <td>{$row['firstname']}</td>
                    <td>{$row['lastname']}</td>
                    <td>{$weight_kg} kg / {$weight_lbs} lbs</td>
                    <td>{$height_meters} m / {$height_feet_inches}</td>
                    <td>Dr. {$row['doctor_firstname']} {$row['doctor_lastname']}</td>
                  </tr>";
        }
        ?>
    </table>
</div>

<?php
mysqli_close($connection);
?>

</body>
</html>