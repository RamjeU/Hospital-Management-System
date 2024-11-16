<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ramje Uthayakumaar Hospital</title>
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
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
        }

        h1, h2 {
            color: #2c5530;
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 2.5em;
            border-bottom: 3px solid #2c5530;
            padding-bottom: 10px;
        }

        .menu-container {
            display: grid;
            gap: 15px;
            padding: 20px;
        }

        .menu-item {
            background-color: #ffffff;
            border: 2px solid #2c5530;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: #2c5530;
        }

        .menu-item:hover {
            background-color: #2c5530;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .footer {
            text-align: center;
            color: #666;
            padding: 20px;
            margin-top: auto;
            font-size: 0.9em;
            width: 100%;
            background-color: #e8f3e8;
            border-top: 1px solid #2c5530;
        }

        .logo {
            width: 100px;
            height: 100px;
            background-color: #2c5530;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2em;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php
   include 'connectdb.php';
?>

<div class="container">
    <div class="logo">RU</div>
    <h1>Welcome to Ramje Uthayakumaar's Hospital</h1>
    <h2>Main Menu</h2>
    
    <div class="menu-container">
        <a href="list_patients.php" class="menu-item">
            List All Patients
        </a>
        <a href="insert_patient.php" class="menu-item">
            Insert New Patient
        </a>
        <a href="delete_patient.php" class="menu-item">
            Delete a Patient
        </a>
        <a href="modify_patient.php" class="menu-item">
            Modify Patient Details
        </a>
        <a href="doctors_without_patients.php" class="menu-item">
            Doctors Without Patients
        </a>
        <a href="doctor_patient_list.php" class="menu-item">
            List of Doctors and Their Patients
        </a>
        <a href="nurse_report.php" class="menu-item">
            Nurse Report
        </a>
    </div>
</div>

<footer class="footer">
    <p>© 2024 Ramje Uthayakumaar Hospital. All rights reserved.</p>
    <p>Providing Excellence in Healthcare Since 2024</p>
</footer>

</body>
</html>
