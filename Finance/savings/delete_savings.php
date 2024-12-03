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
</head>
<body>
    <h2>Deleted Savings Record</h2>
    <p>Savings ID <?php echo htmlspecialchars($_POST['SavingsID']); ?> was successfully deleted.</p>
</body>
</html>