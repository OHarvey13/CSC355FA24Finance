<?php
    ini_set('display_errors', 1);
    // Name: Laura Estremera
    if (isset($_POST['submit'])) { // Form was submitted
        try {
            require_once('../../../pdo_connect.php'); // Adjust the path as needed

            // Error handling and filtering inputs
            $BudgetID = filter_input(INPUT_POST, 'BudgetID', FILTER_VALIDATE_INT);
            $UserID = filter_input(INPUT_POST, 'UserID', FILTER_VALIDATE_INT);
            $Category = strip_tags($_POST['Category']);
            $BudgetAmount = filter_input(INPUT_POST, 'BudgetAmount', FILTER_VALIDATE_FLOAT);
            $StartDate = strip_tags($_POST['StartDate']);
            $EndDate = strip_tags($_POST['EndDate']);

            // Validate input data
            if ($BudgetID === false || $UserID === false || $BudgetAmount === false || empty($Category) || empty($StartDate) || empty($EndDate)) {
                echo "<h2>Invalid data. Please check your input and try again.</h2>";
                exit;
            }

            // SQL statement to insert budget data
            $sql = "INSERT INTO Budget (BudgetID, UserID, Category, BudgetAmount, StartDate, EndDate) 
                    VALUES (:BudgetID, :UserID, :Category, :BudgetAmount, :StartDate, :EndDate)";
            
            $stmt = $dbc->prepare($sql);
            $stmt->bindParam(':BudgetID', $BudgetID, PDO::PARAM_INT);
            $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
            $stmt->bindParam(':Category', $Category, PDO::PARAM_STR);
            $stmt->bindParam(':BudgetAmount', $BudgetAmount, PDO::PARAM_STR);
            $stmt->bindParam(':StartDate', $StartDate, PDO::PARAM_STR);
            $stmt->bindParam(':EndDate', $EndDate, PDO::PARAM_STR);

            $stmt->execute();

            $affected = $stmt->rowCount();
            if ($affected > 0) {
                echo "Data inserted successfully.";
            } else {
                echo "An error occurred. Please try again later.";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<h2>You have reached this page in error.</h2>";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Budget Submit Result</title>
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
            background-color: #133D39;
        }
    </style>
</head>
<body>
    <h2>Inserted Data:</h2>
    <table border="1">
        <tr>
            <th>Budget ID</th>
            <th>User ID</th>
            <th>Budget Type</th>
            <th>Amount</th>
            <th>Start Date</th>
            <th>End Date</th>
        </tr>
        <tr>
            <?php
                echo "<td>" . htmlspecialchars($_POST['BudgetID']) . "</td>";
                echo "<td>" . htmlspecialchars($_POST['UserID']) . "</td>";
                echo "<td>" . htmlspecialchars($_POST['Category']) . "</td>";
                echo "<td>" . number_format($_POST['BudgetAmount'], 2) . "</td>";
                echo "<td>" . htmlspecialchars($_POST['StartDate']) . "</td>";
                echo "<td>" . htmlspecialchars($_POST['EndDate']) . "</td>";
            ?>
        </tr>
    </table>
    <a href="../index.html" class="back-button">Home</a>
</body>
</html>

