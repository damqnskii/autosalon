<?php
    include("config.php");
    include("navbar.php");
    include("Employee.php");
    include("checkIfNumberIsValid.php");
    ?>
<!DOCTYPE html>
<link rel="stylesheet" href="styles/addClient.css">
<html lang="bg">
<body>
<div class="container">
    <form action="" method="Post">
        <h2>Създаване на служител</h2>
        <label for="firstName">Име</label>
        <input type="text" name="firstName" required>
        <label for="lastName">Фамилия</label>
        <input type="text" name="lastName" required>
        <label for="phoneNumber">Телефонен Номер</label>
        <input type="text" name="phoneNumber" required>
        <label for="position">Позиция</label>
        <input type="text" name="position" required>
        <button type="submit">Добави служител</button>
    </form>
    <?php
        if (isset($_GET['error']) && $_GET['error'] == "wrongPhoneNumber") {
            echo "<div class='alert'><h3 style='text-align: center; color:red'>Невалиден формат на телефония номер</h3></div>";
        }
        if (isset($_GET['error']) && $_GET['error'] == "phoneNumberAlreadyExists") {
            echo "<div class='alert'><h3 style='text-align: center; color:red'>Този номер вече съществува</h3></div>";
        }
    ?>
</div>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phoneNumber = $_POST['phoneNumber'];
        $position = $_POST['position'];

        if (isNumber10Symbols($phoneNumber)) {
            header ("Location: addEmployee.php?error=wrongPhoneNumber");
            exit();
        }
        if (isNumberExists($phoneNumber, $conn, "employees")) {
            header ("Location: addEmployee.php?error=phoneNumberAlreadyExists");
            exit();
        }

        $employee = new Employee($firstName, $lastName, $phoneNumber, $position);

        $conn->select_db("autosalon");

        if(!$employee->add($conn)) {
            header("Location: addEmployee.php");
            exit();
        } else {
            header("Location: employees.php");
        }
    }
?>
</body>
</html>
