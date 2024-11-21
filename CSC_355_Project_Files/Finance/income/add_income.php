<?php
    ini_set('display_errors', 1);
// Name: Omari Harvey
// This is the add_income.php file that will insert data into the Income table in the database.
    if (isset($_POST['submit'])) {

        try {
            require_once('../../../pdo_connect.php');

            // Error handling for data types. Checsk if the data is valid.
            // filter_input() is used to filter and validate the data that is being inputted into the database.
            $IncomeID = filter_input(INPUT_POST, 'IncomeID', FILTER_VALIDATE_INT);
            $UserID = filter_input(INPUT_POST, 'UserID', FILTER_VALIDATE_INT);
            $Amount = filter_input(INPUT_POST, 'Amount', FILTER_VALIDATE_FLOAT);
            $DateReceived = strip_tags($_POST['DateReceived']); // Date format: YYYY-MM-DD
            $IncomeType = strip_tags($_POST['IncomeType']);// Income Type: Salary, Bonus, Investment, etc.

            if ($IncomeID === false || $UserID === false || $Amount == false || empty($DateReceived) || empty($IncomeType)) {
                echo "<h2>Invalid data. Please check your data and try again.</h2>";
                exit;
            }

            $insert = "INSERT INTO Income (IncomeID, UserID, Amount, DateReceived, IncomeType) 
            VALUES (:IncomeID, :UserID, :Amount, :DateReceived, :IncomeType)";

            $stmt = $dbc->prepare($insert);
            $stmt -> bindParam(':IncomeID', $IncomeID, PDO::PARAM_INT);
            $stmt -> bindParam(':UserID', $UserID, PDO::PARAM_INT);
            $stmt -> bindParam(':Amount', $Amount, PDO::PARAM_STR);
            $stmt -> bindParam(':DateReceived', $DateReceived, PDO::PARAM_STR);
            $stmt -> bindParam(':IncomeType', $IncomeType, PDO::PARAM_STR);

            $stmt->execute();        
        

        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo "An error has occured. Please try again later.";
        }
        $affected = $stmt->RowCount();
        if ($affected > 0) {
            echo // this displays the added data into a table format for the user to see
        "<div id='modal' class='modal'>
            <div class='modal-content'>
                <h2>Data Inserted Successfully</h2>
                <p><strong>Income ID:</strong> $IncomeID</p>
                <p><strong>User ID:</strong> $UserID</p>
                <p><strong>Amount:</strong> $Amount</p>
                <p><strong>Date Received:</strong> $DateReceived</p>
                <p><strong>Income Type:</strong> $IncomeType</p>
                <a href='index.html' class='home-btn'>Go to Home</a>
            </div>
        </div>
        <style>
            /* Modal styles */
            .modal {
                display: block; /* Show the modal */
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5); /* Dark background */
                justify-content: center;
                align-items: center;
                text-align: center;
            }

            .modal-content {
                background-color: white;
                padding: 20px;
                border-radius: 5px;
                width: 300px;
                margin: 0 auto;
            }

            .home-btn {
                display: inline-block;
                background-color: #4CAF50;
                color: white;
                padding: 10px 20px;
                margin-top: 20px;
                text-decoration: none;
                border-radius: 5px;
                font-size: 16px;
            }

            .home-btn:hover {
                background-color: #45a049;
            }
        </style>";
        } else {
            echo "<h2>Data Insertion Unsuccessful<h2><p>We could not insert into Income.!<p>";
            exit;
        }

} else {
    echo "<h2>You have reached this page in error</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Income Submit result</title>
    <meta charset ="utf-8">
<head>
</html>