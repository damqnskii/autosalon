<?php
include("config.php");
include("navbar.php");
include("Client.php");
include("checkIfNumberIsValid.php");
include("emailValidationCheck.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $address = $_POST['address'];
        $phoneNumber = $_POST['phoneNumber'];
        $email = $_POST['email'];

        if (isNumber10Symbols($phoneNumber) || isNumberExistsForEdit($phoneNumber, $conn, $id, "clients")) {
            header ("Location: editClient.php?error=invalidPhoneNumber&id=$id");
            exit();
        }
        if (isEmailAlreadyExistsForEdit($conn, $email, $id, "clients") || !isEmailValid($email)) {
            header("Location: editClient.php?error=invalidEmail&id=$id");
            exit();
        }

        $client = new Client($firstName, $lastName, $phoneNumber, $email, $address);

        if (!$client->edit($conn, $id)) {
            echo "<h3 style='color:red; text-align:center;'>Проблем с редактирането на клиента!</h3>";
            exit();
        } else {
            header("Location: clients.php");
            exit();
        }
    }
    ?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/editClient.css">
    <title>Редактиране на клиент</title>
</head>
<body>
<h2 style="color: green; text-align: center">Редактиране на клиент</h2>
<div class="container">
    <table>
        <tr>
            <th>Id</th>
            <th>Име</th>
            <th>Фамилия</th>
            <th>Телефон</th>
            <th>Email</th>
            <th>Адрес</th>
            <th></th>
        </tr>

        <?php
        $showForm = true;
        if (isset($_GET['error']) && $_GET['error'] == "invalidPhoneNumber") {
            $id = intval($_GET['id']);
            echo "<tr>
                     <td colspan='7'>
                         <div class='alert'><h3 style='text-align: center; color:red'>Невалиден Номер или вече съществуващ такъв</h3></div>
                     </td>
                  </tr>";
            echo "<tr>
                    <td colspan='7'>
                    <div style='display:flex; justify-content: center'>
                    <a href='/autosalon/editClient.php?id=$id' style='text-align: center; margin:10px;  text-decoration: none; font-size: 18px; color:green'>Редактирай отново</a>
                    <a href='/autosalon/clients.php' style='text-align: center; margin: 10px; text-decoration: none; font-size: 18px; color:green'>Върни се към клиенти</a>
                    </div>
                  </tr>";
            $showForm = false;
        }
        if (isset($_GET['error']) && $_GET['error'] == "invalidEmail") {
            $id = intval($_GET['id']);
            echo "<tr>
                     <td colspan='7'>
                         <div class='alert'><h3 style='text-align: center; color:red'>Невалиден email или вече съществуващ такъв</h3></div>
                     </td>
                  </tr>";
            echo "<tr>
                    <td colspan='7'>
                    <div style='display:flex; justify-content: center'>
                    <a href='/autosalon/editClient.php?id=$id' style='text-align: center; margin:10px;  text-decoration: none; font-size: 18px; color:green'>Редактирай отново</a>
                    <a href='/autosalon/clients.php' style='text-align: center; margin: 10px; text-decoration: none; font-size: 18px; color:green'>Върни се към клиенти</a>
                    </div>
                  </tr>";
            $showForm = false;
        }

        if (isset($_GET["id"]) && $showForm) {
            $id = intval($_GET["id"]);
            $conn->select_db("autosalon");

            $query = "SELECT * FROM clients WHERE id = $id";
            $result = mysqli_query($conn, $query);

            if ($client = mysqli_fetch_assoc($result)) {
                echo "<form method='post'>
                        <tr>    
                            <td>{$client['id']}<input type='hidden' name='id' value='{$client["id"]}'></td>
                            <td><input type='text' name='firstName' value='{$client["first_name"]}'></td>
                            <td><input type='text' name='lastName' value='{$client["last_name"]}'></td>
                            <td><input type='text' name='phoneNumber' value='{$client["phone"]}'></td>
                            <td><input type='text' name='email' value='{$client["email"]}'></td>
                            <td><input type='text' name='address' value='{$client["address"]}'></td>
                            <td><button type='submit' class='btn'>Редактирай</button></td>
                        </tr>
                    </form>";
                echo "<tr>
                    <td colspan='7'>
                    <div style='display:flex; justify-content: center'>
                    <a href='/autosalon/editClient.php?id=$id' style='text-align: center; margin:10px;  text-decoration: none; font-size: 18px; color:green'>Редактирай отново</a>
                    <a href='/autosalon/clients.php' style='text-align: center; margin: 10px; text-decoration: none; font-size: 18px; color:green'>Върни се към клиенти</a>
                    </div>
                  </tr>";

            } else {
                echo "<tr><td colspan='7' style='text-align:center; color:red;'>Клиентът не е намерен.</td></tr>";
            }
        }
        ?>
    </table>

</div>
</body>
</html>
