<?php
ini_set('display_errors', 1);

if (isset($_POST['submit'])) { // Form was submitted
    $result = [];
	try {
        require_once('../../pdo_connect.php'); // Adjust the path to your database connection file

        $sql = "
            SELECT 
                Savings.*,
                Income.*
            FROM Savings
            INNER JOIN Income ON Savings.UserID = Income.UserID
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
    <title>Income and Savings Data</title>
    <meta charset="utf-8">
</head>
<body>
    <a href="index.html" class="back-button">Home</a>
    <h2>Income and Savings Data</h2>
        <table border="1">
            <thead>
            <tr>
                <?php
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