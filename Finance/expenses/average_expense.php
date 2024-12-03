<?php
ini_set('display_errors', 1);
// Name: Caleb Yarborough
/* This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data. */

if (isset($_POST['submit'])) { 
    try {
        require_once('../../../pdo_connect.php'); 

        $UserID = filter_input(INPUT_POST, 'UserID', FILTER_VALIDATE_INT);
        if ($UserID === false) {
            echo "Invalid UserID.";
            exit;
        }

        // SQL Query to calculate the average expense amount
        $sql = "SELECT AVG(Amount) AS AverageExpenseAmount
                FROM Expenses
                WHERE UserID = :UserID";

        $stmt = $dbc->prepare($sql);
        $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result || $result['AverageExpenseAmount'] === null) {
            echo "No expenses found for the provided UserID.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
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
    <title>Average Expense</title>
    <meta charset="utf-8">
</head>
<body>
    <h2>Average Expense for UserID: <?php echo htmlspecialchars($UserID); ?></h2>
    <table border="1">
        <tr>
            <th>User ID</th>
            <th>Average Expense Amount</th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($UserID); ?></td>
            <td><?php echo "$" . number_format($result['AverageExpenseAmount'], 2); ?></td>
        </tr>
    </table>
    <a href="../index.html" class="back-button">Home</a>
</body>
</html>
