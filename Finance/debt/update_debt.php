<?php
	ini_set('display_errors', 1);
//Name: 
/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
	if(isset($_POST['submit'])) { //Form was submitted
		
		try{
			require_once('../../../pdo_connect.php'); //adjust the relative path as necessary to find your connect file
			$sql = '';
			
			$Amount = filter_input(INPUT_POST, 'Amount', FILTER_VALIDATE_FLOAT);
			$InterestRate = filter_input(INPUT_POST, 'InterestRate'. FILTER_VALIDATE_FLOAT);
			if ($Amount == false || empty($PaymentDueDate) && !empty($InterestRate)) {
                $sql = 'UPDATE Debt SET InterestRate = :InterestRate WHERE DebtID = :DebtID';
            }
			elseif ($InterestRate == false || empty($InterestRate) && !empty($amount)){
				$sql = 'UPDATE Debt SET Amount = :Amount WHERE DebtID = :DebtID';
			}
			else{
				$sql = 'UPDATE Debt SET InterestRate = :InterestRate, Amount = :Amount WHERE DebtID = :DebtID';
			}
			
			$stmt = $dbc->prepare($sql);
			$stmt->bindParam(':DebtID', $_POST['DebtID'], PDO::PARAM_INT);
			$stmt->bindParam(':Amount', $_POST['Amount'], PDO::PARAM_STR);
			$stmt->bindParam(':InterestRate', $_POST['InterestRate'], PDO::PARAM_STR);

			$stmt->execute();	
		} catch (PDOException $e){
			echo $e->getMessage();
		}	
		$affected = $stmt->RowCount();
		if ($affected == 0){
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
              
			echo "We could not update Debt.";
			exit;
		}
		//end isset
	else {
		echo "<h2>You have reached this page in error</h2>";
		exit;
	}
