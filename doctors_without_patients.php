<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Doctors Without Patients</title>
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

        .no-results {
            color: #a94442;
            font-size: 1.1em;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php
include 'connectdb.php';  // Include the database connection

// Query to find doctors without patients
$query = "SELECT doctor.docid, doctor.firstname, doctor.lastname
          FROM doctor
          LEFT JOIN patient ON doctor.docid = patient.treatsdocid
          WHERE patient.treatsdocid IS NULL";
          
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($connection));
}
?>

<div class="container">
    <a href="mainmenu.php" class="back-btn">← Back to Main Menu</a>

    <h1>Doctors Without Patients</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>Doctor ID</th>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['docid']; ?></td>
                    <td><?php echo $row['firstname']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p class="no-results">No doctors without patients found.</p>
    <?php endif; ?>
</div>

<?php
// Close the database connection
mysqli_close($connection);
?>

</body>
</html>
