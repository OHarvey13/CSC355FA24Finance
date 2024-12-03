<?php
ini_set('display_errors', 1);

// Check if the form was submitted
if (isset($_POST['submit'])) {
    try {
        require_once('../../../pdo_connect.php'); // Adjust path to your database connection file

        // Retrieve and validate input data
        $ExpenseID = filter_input(INPUT_POST, 'ExpenseID', FILTER_VALIDATE_INT);

        if ($ExpenseID === false || empty($ExpenseID)) {
            echo "<h2>Invalid Expense ID. Please check your input and try again.</h2>";
            exit;
        }

        // Delete query
        $delete = "DELETE FROM Expenses WHERE ExpenseID = :ExpenseID";
        $stmt = $dbc->prepare($delete);
        $stmt->bindParam(':ExpenseID', $ExpenseID, PDO::PARAM_INT);
        $stmt->execute();

        $affected = $stmt->rowCount();
        if ($affected > 0) {
            echo "<div id='modal' class='modal'>
                    <div class='modal-content'>
                        <h2>Expense Deleted Successfully</h2>
                        <p><strong>Expense ID:</strong> $ExpenseID</p>
                        <a href='../index.html' class='home-btn'>Go to Home</a>
                    </div>
                  </div>";
        } else {
            echo "<h2>Expense ID: $ExpenseID not found.</h2>";
        }
    } catch (PDOException $e) {
        echo "An error occurred. Please try again later.";
        error_log($e->getMessage());
    }
} else {
    echo "<h2>You have reached this page in error.</h2>";
    exit;
}
?>
