<?php
ini_set('display_errors', 1);
//Name: Caleb Yarborough
if (isset($_POST['submit'])) { // Form was submitted
    try {
        require_once('../../../pdo_connect.php'); // Adjust the relative path as necessary

        // Get the SavingsID from the form data
        $SavingsID = $_POST['SavingsID'];

        // Prepare the DELETE query
        $sql = "DELETE FROM Savings WHERE SavingsID = :SavingsID";
        $stmt = $dbc->prepare($sql);
        $stmt->bindParam(':SavingsID', $SavingsID, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Check affected rows
        $affected = $stmt->rowCount();

        if ($affected == 0) {
            echo "We could not delete the Savings row.";
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
    <title>Savings Submit Result</title>
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
    <h2>Deleted Savings Record</h2>
    <p>Savings ID <?php echo htmlspecialchars($_POST['SavingsID']); ?> was successfully deleted.</p>
    <a href="../index.html" class="back-button">Home</a>
</body>
</html>