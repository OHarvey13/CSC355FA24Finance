<?php
ini_set('display_errors', 1);

if (isset($_POST['submit'])) { // Form was submitted
    $result = [];
	try {
        require_once('../../pdo_connect.php'); // Adjust the path to your database connection file

        $sql = "
            SELECT 
                Savings.*,
                Debt.*,
                Income.*,
                Transactions.*,
                Expenses.*,
                Budget.*
            FROM Savings
            INNER JOIN Debt ON Savings.UserID = Debt.UserID
            INNER JOIN Income ON Savings.UserID = Income.UserID
            INNER JOIN Transactions ON Savings.UserID = Transactions.UserID
            INNER JOIN Expenses ON Savings.UserID = Expenses.UserID
            INNER JOIN Budget ON Savings.UserID = Budget.UserID
            WHERE Savings.UserID = :UserID";

        $stmt = $dbc->prepare($sql);
        $stmt->bindParam(':UserID', $_POST['UserID'], PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		
		if (empty($result)) {
            echo "We could not pull all the tables for this user";
            exit;
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<h2>You have reached this page in error</h2>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Data</title>
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
    <a href="index.html" class="back-button">Home</a>
    <h2>User Data</h2>
        <table border="1">
            <thead>
            <tr>
                <?php
                // Generate table headers dynamically based on the first row
                if (!empty($result)) {
                    foreach (array_keys($result[0]) as $column) {
                        echo "<th>" . htmlspecialchars($column) . "</th>";
                    }
                }
                ?>
            </tr>
			</thead>
			<tbody>
            <?php
            // Generate table rows dynamically
            foreach ($result as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value ?? '') . "</td>";
                }
                echo "</tr>";
            }
            ?>
			</tbody>
        </table>
    
</body>
</html>