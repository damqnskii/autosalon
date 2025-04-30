<?php
include("navbar.php");
include("config.php");
include("Client.php");
include("checkIfNumberIsValid.php");
include("emailValidationCheck.php");
?>

<!DOCTYPE html>
<link rel="stylesheet" href="styles/addClient.css">
<html lang="bg">
<body>
    <div class="container">
        <form action="" method="Post">
            <h2>Създаване на клиент</h2>
            <label for="firstName">Име</label>
            <input type="text" name="firstName" required>
            <label for="lastName">Фамилия</label>
            <input type="text" name="lastName" required>
            <label for="address">Адрес</label>
            <input type="text" name="address" required>
            <label for="phoneNumber">Телефонен Номер</label>
            <input type="text" name="phoneNumber" required>
            <label for="email">Email</label>
            <input type="text" name="email" required>
            <button type="submit">Създай клиент</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $address = $_POST["address"];
            $phoneNumber = $_POST["phoneNumber"];
            if (isNumber10Symbols($phoneNumber)) {
                header ("Location: addClient.php?error=wrongPhoneNumber");
                exit();
            }
            if (isNumberExists($phoneNumber, $conn, "clients")) {
                header ("Location: addClient.php?error=phoneNumberAlreadyExists");
                exit();
            }

            $email = $_POST["email"];

            if (!isEmailValid($email)) {
                header ("Location: addClient.php?error=notValidEmail");
                exit();
            }
            if (isEmailAlreadyExists($conn, $email, "clients")) {
                header ("Location: addClient.php?error=emailAlreadyExists");
                exit();
            }

            $client = new Client($firstName, $lastName, $phoneNumber, $email, $address);
            if (!$client->add($conn)) {
                $message = "Проблем със създаването на клиент";
                header ("Location: addClient.php?error=database");
                exit();
            } else {
                header("Location: clients.php");
                exit();
            }
        }
        ?>
        <?php
            if (isset($_GET['error']) && $_GET['error'] == "wrongPhoneNumber") {
                echo "<div class='alert'><h3 style='text-align: center; color:red'>Невалиден формат на телефония номер</h3></div>";
            }
            if (isset($_GET['error']) && $_GET['error'] == "database") {
                echo "<div class='alert'><h3 style='text-align: center; color:red'>Възникна проблем при създаването на клиент</h3></div>";
            }
            if (isset($_GET['error']) && $_GET['error'] == "phoneNumberAlreadyExists") {
                echo "<div class='alert'><h3 style='text-align: center; color:red'>Този номер вече съществува</h3></div>";
            }
            if (isset($_GET['error']) && $_GET['error'] == "notValidEmail") {
                echo "<div class='alert'><h3 style='text-align: center; color:red'>Невалиден имейл</h3></div>";
            }
            if (isset($_GET['error']) && $_GET['error'] == "emailAlreadyExists") {
                echo "<div class='alert'><h3 style='text-align: center; color:red'>Имейла вече съществува</h3></div>";
            }
        ?>
    </div>

</body>
</html>

