<?php
    ini_set('display_errors', 1);
    //Name: Laura Estremera
    /* This code also assumes user input is valid (as per debt view) - it does NOT validate form data. */
    if (isset($_POST['submit'])) { // Form was submitted
        try {
            require_once('../../../pdo_connect.php'); // Adjust the relative path as necessary to find your connect file

            $BudgetID = filter_input(INPUT_POST, 'BudgetID', FILTER_VALIDATE_INT); // Using 'DebtID' as provided in the form

            if ($BudgetID === false) {
                echo "<h2>Invalid data. Please check your data and try again.</h2>";
                exit;
            }

            $stmt = $dbc->prepare("SELECT * FROM Budget WHERE BudgetID = :BudgetID ORDER BY BudgetID");
            $stmt->bindParam(':BudgetID', $BudgetID, PDO::PARAM_INT);
            $stmt->execute();

            $results = $stmt->fetchAll();
            if ($results) {
                echo '<h1>Budget</h1>';
                echo '<table border="1">';
                echo '<tr><th>BudgetID</th><th>UserID</th><th>Category</th><th>Budget Amount</th><th>StartDate</th><th>EndDate</th></tr>';
                foreach ($results as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['BudgetID'] . '</td>';
                    echo '<td>' . $row['UserID'] . '</td>';
                    echo '<td>' . $row['Category'] . '</td>';
                    echo '<td>' . $row['BudgetAmount'] . '</td>';
                    echo '<td>' . $row['StartDate'] . '</td>';
                    echo '<td>' . $row['EndDate'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<h2>No budget found with the provided BudgetID.</h2>';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<h2>You have reached this page in error</h2>";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Budget</title>
    <meta charset="utf-8">
    <style>
        .back-button {
            display: inline-block;
            background-color: #1C3F3A;
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #124532;
        }
    </style>
</head>
<body>
    <a href="../index.html" class="back-button">Home</a>
</body>
</html>
