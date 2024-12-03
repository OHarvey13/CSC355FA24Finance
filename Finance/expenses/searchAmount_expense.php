<?php
ini_set('display_errors', 1);
// Name: Caleb Yarborough
/* This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data. */

if (isset($_POST['submit'])) { // Form was submitted
    try {
        require_once('../../../pdo_connect.php'); 

        $UserID = filter_input(INPUT_POST, 'UserID', FILTER_VALIDATE_INT);
        $amount = filter_input(INPUT_POST, 'Amount', FILTER_VALIDATE_FLOAT); 

        if ($UserID === false || $amount === false || $amount <= 0) {
            echo "Invalid UserID or Amount entered.";
            exit;
        }

        // SQL Query to get the total expenses for the given UserID greater than or equal to the specified amount
        $sql = "SELECT UserID, SUM(Amount) AS TotalExpenses 
                FROM Expenses 
                WHERE UserID = :UserID 
                GROUP BY UserID 
                HAVING SUM(Amount) >= :amount";

        $stmt = $dbc->prepare($sql);
        $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            echo "No results found for UserID " . htmlspecialchars($UserID) . " with total expenses greater than " . htmlspecialchars($amount) . ".";
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
    <title>Total Expenses</title>
    <meta charset="utf-8">
</head>
<body>
    <h2>Total Expenses for UserID: <?php echo htmlspecialchars($UserID); ?></h2>
    <table border="1">
        <tr>
            <th>User ID</th>
            <th>Total Expenses</th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($UserID); ?></td>
            <td><?php echo "$" . number_format($result['TotalExpenses'], 2); ?></td>
        </tr>
    </table>
    <p>The total expenses are greater than or equal to <?php echo "$" . htmlspecialchars(number_format($amount, 2)); ?>.</p>
    <a href="../index.html" class="back-button">Home</a>
</body>
</html>
