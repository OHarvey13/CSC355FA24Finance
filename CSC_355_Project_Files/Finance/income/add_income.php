<?php
    ini_set('display_errors', 1);
// Name: Omari Harvey
// This is the add_income.php file that will insert data into the Income table in the database.
    if (isset($_POST['submit'])) {

        try {
            require_once('../../../pdo_connect.php');

            $IncomeID = $_POST['IncomeID'];
            $UserID = $_POST['UserID'];
            $Amount = $_POST['Amount'];
            $DateReceived = $_POST['DateReceived'];
            $IncomeType = $_POST['IncomeType'];

            $insert = "INSERT INTO Income (IncomeID, UserID, Amount, DateReceived, IncomeType) 
            VALUES (:IncomeID, :UserID, :Amount, :DateReceived, :IncomeType)";

            $stmt = $dbc->prepare($insert);

            $stmt -> bindParam(':IncomeID', $IncomeID, PDO::PARAM_INT);
            $stmt -> bindParam(':UserID', $UserID, PDO::PARAM_INT);
            $stmt -> bindParam(':Amount', $Amount, PDO::PARAM_STR);
            $stmt -> bindParam(':DateReceived', $DateReceived, PDO::PARAM_STR);
            $stmt -> bindParam(':IncomeType', $IncomeType, PDO::PARAM_STR);

            $stmt->execute();        
        

        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo "An error has occured. Please try again later.";
        }
        $affected = $stmt->RowCount();
        if ($affected > 0) {
            echo "Data inserted successfully.";
        } else {
            echo "We could not insert into Income.";
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
    <title>Income Submit result</title>
    <meta charset ="utf-8">
<body>
    <h2> Inserted Data: </h2>
    <table>
        <tr>
            <th>Income ID</th>
            <th>User ID</th>
            <th>Amount</th>
            <th>Date Received</th>
            <th>Income Type</th>
        <?php
            echo "<tr>";
            echo "<td>".$_POST['IncomeID']."</td>";
            echo "<td>".$_POST["UserID"]."</td>";
            echo "<td>".$_POST['Amount']."</td>";
            echo "<td>".$_POST["DateReceived"]."</td>";
            echo "<td>".$_POST["IncomeType"]."</td>";
            echo "</tr>";
        ?> 
    </table>
</body>
</html>