<?php

ini_set('display_errors', 1);

// Author Name: Omari Harvey
// This file updates the income table in the database
if (isset($_POST['submit'])) {
    try {
        require_once('../../../pdo_connect.php');

        // Check if the income ID is set
        $IncomeID = filter_input(INPUT_POST, 'IncomeID', FILTER_VALIDATE_INT);
        $updatedField = $_POST['fieldToUpdate']; // Field to update
        $newValue = $_POST['newValue']; // New value to update the field with

        if ($IncomeID === false || empty($updatedField) || empty($newValue)) {
            echo "Invalid income ID or field to update or new value";
            exit;
        }

        // Prepare the query based on the updated field
        $query = ""; // Query to execute, empty by default
        switch ($updatedField) {
            case "UserID": // Check if the user ID exists
                $newValue = filter_var($newValue, FILTER_VALIDATE_INT);
                if ($newValue === false) { // Check if the value is a valid integer
                    echo "Invalid value for UserID";
                    exit;
                }
                // Call the query based on the case
                $query = "UPDATE Income SET UserID = :UserID WHERE IncomeID = :IncomeID";
                break;
            case "Amount": // Check if the amount is a valid float
                $newValue = filter_var($newValue, FILTER_VALIDATE_FLOAT);
                if ($newValue === false) { // Check if the value is a valid float
                    echo "Invalid value for Amount";
                    exit;
                }
                // Call the query based on the case
                $query = "UPDATE Income SET Amount = :Amount WHERE IncomeID = :IncomeID";
                break;
            case "DateReceived":
                $newValue = strip_tags($newValue);
                if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $newValue)) {
                    echo "Invalid value for DateReceived";
                    exit;
                }
                // Call the query based on the case
                $query = "UPDATE Income SET DateReceived = :DateReceived WHERE IncomeID = :IncomeID";
                break;
            case "IncomeType":
                $validIncomeTypes = ["Salary", "Bonus", "Other"];
                $newValue = strip_tags($newValue);
                if (!in_array($newValue, $validIncomeTypes)) {
                    echo "Invalid value for IncomeType";
                    exit;
                }
                // Call the query based on the case
                $query = "UPDATE Income SET IncomeType = :IncomeType WHERE IncomeID = :IncomeID";
                break;
            default:
                echo "Unknown field to update";
                exit;
        }

        // Prepare and bind the statement
        $stmt = $dbc->prepare($query);
        switch ($updatedField) {
            case "UserID":
                $stmt->bindParam(':UserID', $newValue, PDO::PARAM_INT);
                break;
            case "Amount":
                $stmt->bindParam(':Amount', $newValue, PDO::PARAM_STR);
                break;
            case "DateReceived":
                $stmt->bindParam(':DateReceived', $newValue, PDO::PARAM_STR);
                break;
            case "IncomeType":
                $stmt->bindParam(':IncomeType', $newValue, PDO::PARAM_STR);
                break;
        }
        $stmt->bindParam(':IncomeID', $IncomeID, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo "<div id='modal' class='modal'>
            <div class='modal-content'>
                <h2>Data Updated Successfully</h2>
                <a href='../index.html' class='home-btn'>Home</a>
            </div>
        </div>
        <style>
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
                background-color: #1C3F3A;
                color: white;
                padding: 10px 20px;
                margin-top: 20px;
                text-decoration: none;
                border-radius: 5px;
                font-size: 16px;
            }
            .home-btn:hover {
                background-color: #1C3F3A;
            }
        </style>";
        } else {
            echo "Error: " . implode(", ", $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "Form was not submitted";
}
?>
