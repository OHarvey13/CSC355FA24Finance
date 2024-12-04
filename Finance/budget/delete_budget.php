<?php
//Name: Laura Estremera
    ini_set('display_errors', 1);

    if (isset($_POST['submit'])) { // Form was submitted
        try {
            require_once('../../../pdo_connect.php');

            // Retrieve and validate BudgetID
            $BudgetID = filter_input(INPUT_POST, 'DebtID', FILTER_VALIDATE_INT);

            if ($BudgetID === false || empty($BudgetID)) {
                echo "<h2>Invalid Budget ID. Please check your input and try again.</h2>";
                exit;
            }

            // Prepare the DELETE query
            $delete = "DELETE FROM Budget WHERE BudgetID = :BudgetID";
            $stmt = $dbc->prepare($delete);
            $stmt->bindParam(':BudgetID', $BudgetID, PDO::PARAM_INT);
            $stmt->execute();

        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo "An error has occurred. Please try again later.";
        }

        // Check if the data was deleted
        $affected = $stmt->rowCount();
        if ($affected > 0) {
            // Show success modal
            echo "<div id='modal' class='modal'>
                <div class='modal-content'>
                    <h2>Data Deletion Successful</h2>
                    <p><strong>Budget ID:</strong> $BudgetID</p>
                    <a href='index.html' class='home-btn'>Go to Home</a>
                </div>
            </div>
            <style>
                .modal {
                    display: block;
                    position: fixed;
                    z-index: 1;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
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
            echo "<h2>Budget ID: $BudgetID was not found.</h2>";
        }

    } else {
        echo "<h2>You have reached this page in error</h2>";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Budget Delete Result</title>
    <meta charset="utf-8">
</head>
<body>
    <h2>Deleted Data:</h2>
    <table>
        <tr>
            <th>Deleted Budget ID</th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($_POST['DebtID']); ?></td>
        </tr>
    </table>
</body>
</html>
