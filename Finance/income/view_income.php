<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
// Name: Omari Harvey
// This file is to display all the income(s) of the user based off their userID

if (isset($_POST['submit'])){
    try{
        require_once('../../../pdo_connect.php');

        $UserID = filter_input(INPUT_POST,'UserID', FILTER_VALIDATE_INT);
        
        if ($UserID === false){
            echo 'Invalid UserID';
            exit;
        }
        // Intialize the query
        $q = "SELECT * FROM Income WHERE UserID = :UserID ORDER BY IncomeID";

        // Prepare the query
        $stmt = $dbc->prepare($q);
        $stmt->bindParam(":UserID", $UserID); // bind the parameter

        $stmt->execute(); // execute the quert
        $results = $stmt->fetchAll(); // fetch all the results

        // Display the results
        if ($results) {
            echo '<h1>Income</h1>';
            echo '<table border="1">';
            echo '<tr><th>IncomeID</th><th>UserID</th><th>Amount</th><th>Date Receieved</th><th>Income Type</th></tr>';
            foreach ($results as $row){
                echo '<tr>';
                echo '<td>' . $row['IncomeID'] . '</td>';
                echo '<td>' . $row['UserID'] . '</td>';
                echo '<td>' . $row['Amount'] . '</td>'; 
                echo '<td>' . $row['DateReceived'] . '</td>'; 
                echo '<td>' . $row['IncomeType'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'No results found';
        }

        // Call stored procedure to get financial summary
        $proc = "CALL GetFinancialSummary(:UserID)";
        $stmt = $dbc->prepare($proc);
        $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
        $stmt->execute();

        // Display the financial summary
        $summary = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($summary) {
            echo '<h1>Financial Summary</h1>';
            echo '<table border="1">';
            echo '<tr><th>UserID</th><th>Total Income</th><th>Total Expenses</th><th>Net Balance</th></tr>';
            echo '<tr>';
            echo '<td>' . htmlspecialchars($summary['UserID']) . '</td>';
            echo '<td>' . number_format($summary['TotalIncome'],2) . '</td>';
            echo '<td>' . number_format($summary['TotalExpenses'],2) . '</td>';
            echo '<td>' . number_format($summary['NetBalance'],2) . '</td>';
            echo '</tr>';
            echo '</table>';
        } else {
            echo 'Unable to retrieve financial summary.';
        }

    } catch(Exception $e){
        error_log($e->getMessage());
        echo 'An error has occured. Please try again later';
}
} else {
    echo "Form was not submitted properly";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Income</title>
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
            background-color: #1C3F3A;
        }
    </style>
</head>
<body>
    <a href="../index.html" class="back-button">Home</a>
</body>
</html>