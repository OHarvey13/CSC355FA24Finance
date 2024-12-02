<?php
	ini_set('display_errors', 1);
//Name: 
/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
	if(isset($_POST['submit'])) { //Form was submitted
		
		
		try {
            require_once('../../../pdo_connect.php');

            // Error handling for data types. Checks if the data is valid.
            $DebtID = filter_input(INPUT_POST, 'DebtID', FILTER_VALIDATE_INT);

            // Error handling for data types. Checks if the data is valid.
            if ($DebtID === false || empty($DebtID)) {
                echo "<h2>Invalid data. Please check your data and try again.</h2>";
                exit;
            }
            // Prepare Delete query
            $delete = "DELETE FROM Debt WHERE DebtID = :DebtID";
            $stmt = $dbc->prepare($delete);
            $stmt->bindParam(':DebtID', $DebtID, PDO::PARAM_INT);

            $stmt->execute();

        
        // Catch any errors
        } 
        catch (PDOException $e) {
            error_log($e->getMessage());
            echo "An error has occured. Please try again later.";
        }
        // Check if the data was deleted
        $affected = $stmt->RowCount();
        if ($affected > 0) {
            // Display a modal to show the user that the data was deleted
            echo "<div id='modal' class='modal'>
            <div class='modal-content'>
                <h2>Data Deletion Successfully</h2>
                <p><strong>Income ID:</strong> $DebtID</p>
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
            /* Modal Content */
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
		}
		else { // If the data was not deleted
            echo "<h2>Debt ID: $DebtID was not found.</h2>";
        }
	} //end isset
	else {
		echo "<h2>You have reached this page in error</h2>";
		exit;
	}
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Debt Deletion result</title>
    <meta charset ="utf-8">
<head>
</html>