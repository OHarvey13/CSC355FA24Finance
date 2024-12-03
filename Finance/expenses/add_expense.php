<?php
ini_set('display_errors', 1);

// Name: Riley Simpson
// Error handling added for demonstration purposes

if (isset($_POST['submit'])) { // Check if form was submitted
    try {
        require_once('../../../pdo_connect.php'); 

        // Retrieve and validate input data
        $ExpenseID = filter_input(INPUT_POST, 'ExpenseID', FILTER_VALIDATE_INT);
        $UserID = filter_input(INPUT_POST, 'UserID', FILTER_VALIDATE_INT);
        $ExpenseType = strip_tags($_POST['ExpenseType']);
        $Amount = filter_input(INPUT_POST, 'Amount', FILTER_VALIDATE_FLOAT);
        $Date = $_POST['ExpenseDate'];

        // Error handling for input validation
        if ($ExpenseID === false || $UserID === false || $Amount === false || empty($ExpenseType) || empty($Date)) {
            echo "<h2>Invalid data. Please check your inputs and try again.</h2>";
            exit;
        }

        // SQL query
        $sql = "INSERT INTO Expenses (ExpenseID, UserID, ExpenseType, Amount, Date) 
                VALUES (:ExpenseID, :UserID, :ExpenseType, :Amount, :Date)";

        $stmt = $dbc->prepare($sql);
        $stmt->bindParam(':ExpenseID', $ExpenseID, PDO::PARAM_INT);
        $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
        $stmt->bindParam(':ExpenseType', $ExpenseType, PDO::PARAM_STR);
        $stmt->bindParam(':Amount', $Amount, PDO::PARAM_STR);
        $stmt->bindParam(':Date', $Date, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        echo "<h2>An error occurred:</h2>";
        echo "<p>" . $e->getMessage() . "</p>";
        exit;
    }

    $affected = $stmt->rowCount();
    if ($affected > 0) {
        echo "Expense added successfully.";
    } else {
        echo "An error occurred. Please try again.";
    }
} else {
    echo "<h2>You have reached this page in error.</h2>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Expense Submit Result</title>
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
            background-color: #145B55;
        }
    </style>
</head>
<body>
    <h2>Inserted Data:</h2>
    <table border="1">
        <tr>
            <th>Expense ID</th>
            <th>User ID</th>
            <th>Expense Type</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($_POST['ExpenseID']); ?></td>
            <td><?php echo htmlspecialchars($_POST['UserID']); ?></td>
            <td><?php echo htmlspecialchars($_POST['ExpenseType']); ?></td>
            <td><?php echo htmlspecialchars($_POST['Amount']); ?></td>
            <td><?php echo htmlspecialchars($_POST['ExpenseDate']); ?></td>
        </tr>
    </table>
    <a href="../index.html" class="back-button">Home</a>
</body>
</html>
