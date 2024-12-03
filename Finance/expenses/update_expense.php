<?php
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    try {
        require_once('../../../pdo_connect.php'); // Adjust path to your database connection file

        $ExpenseID = filter_input(INPUT_POST, 'ExpenseID', FILTER_VALIDATE_INT);
        $Amount = filter_input(INPUT_POST, 'Amount', FILTER_VALIDATE_FLOAT);
        $ExpenseType = strip_tags($_POST['ExpenseType']);
        $Date = $_POST['ExpenseDate'];

        if ($ExpenseID === false || $Amount === false || empty($ExpenseType) || empty($Date)) {
            echo "<h2>Invalid input. Please check your data and try again.</h2>";
            exit;
        }

        $sql = "UPDATE Expenses SET ExpenseType = :ExpenseType, Amount = :Amount, Date = :Date WHERE ExpenseID = :ExpenseID";
        $stmt = $dbc->prepare($sql);
        $stmt->bindParam(':ExpenseID', $ExpenseID, PDO::PARAM_INT);
        $stmt->bindParam(':ExpenseType', $ExpenseType, PDO::PARAM_STR);
        $stmt->bindParam(':Amount', $Amount, PDO::PARAM_STR);
        $stmt->bindParam(':Date', $Date, PDO::PARAM_STR);
        $stmt->execute();

        $affected = $stmt->rowCount();
        if ($affected > 0) {
            echo "<div id='modal' class='modal'>
                    <div class='modal-content'>
                        <h2>Expense Updated Successfully</h2>
                        <p><strong>Expense ID:</strong> $ExpenseID</p>
                        <a href='../index.html' class='home-btn'>Go to Home</a>
                    </div>
                  </div>";
        } else {
            echo "<h2>No updates were made for Expense ID: $ExpenseID.</h2>";
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
