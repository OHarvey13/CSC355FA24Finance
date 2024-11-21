<?php
    ini_set('display_errors', 1);
// Name: Omari Harvey
// This is the add_income.php file that will insert data into the Income table in the database.
    if (isset($_POST['submit'])) {

        try {
            require_once('../pdo_connect.php');

            $IncomeID = $_POST['IncomeID'];
            $UserID = $_POST['UserID'];
            $IncomeType = $_POST['IncomeType'];
            $Amount = $_POST['Amount'];
            $Frequency = $_POST['Frequency'];
            $DateReceived = $_POST['DateReceived'];

            $insert = "INSERT INTO Income (IncomeID, UserID, IncomeType, Amount, Frequency, DateReceived) 
            VALUES (:IncomeID, :UserID, :IncomeType, :Amount, :Frequency, :DateReceived)";

            $stmt = $dbc->prepare($insert);

            $stmt -> bindParam(':IncomeID', $IncomeID, PDO::PARAM_INT);
            $stmt -> bindParam(':UserID', $UserID, PDO::PARAM_INT);
            $stmt -> bindParam(':IncomeType', $IncomeType, PDO::PARAM_STR);
            $stmt -> bindParam(':Amount', $Amount, PDO::PARAM_STR);
            $stmt -> bindParam(':Frequency', $Frequency, PDO::PARAM_STR);
            $stmt -> bindParam(':DateReceived', $DateReceived, PDO::PARAM_STR);

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
            <th>Income Amount</th>
        <?php foreach ($stmt as $income) { 
            echo "<tr>";
            echo "<td>".$_POST['IncomeID']."</td>";
            echo "<td>".$_POST["UserID"]."</td>";
            echo "<td>".$_POST['Amount']."</td>";
            echo "</tr>";
        }
        ?> 
    </table>
</body>
</html>