<?php
include("config.php");
include("navbar.php");
include("Employee.php");
include("checkIfNumberIsValid.php");
include("emailValidationCheck.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phoneNumber = $_POST['phoneNumber'];
        $position = $_POST['position'];

        if (isNumber10Symbols($phoneNumber) || isNumberExistsForEdit($phoneNumber, $conn, $id, "employees")) {
            header ("Location: editEmployee.php?error=invalidPhoneNumber&id=$id");
            exit();
        }

        $employee = new Employee($firstName, $lastName, $phoneNumber, $position);

        if (!$employee->edit($conn, $id)) {
            echo "<h3 style='color:red; text-align:center;'>Проблем с редактирането на клиента!</h3>";
            exit();
        } else {
            header("Location: employees.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/editEmployee.css">
    <title>Редактиране на служител</title>
</head>
<body>
<h2 style="color: green; text-align: center">Редактиране на служител</h2>
<div class="container">
    <table>
        <tr>
            <th>Id</th>
            <th>Име</th>
            <th>Фамилия</th>
            <th>Позиция</th>
            <th>Телефон</th>
            <th></th>
        </tr>

        <?php
        $showForm = true;
        if (isset($_GET['error']) && $_GET['error'] == "invalidPhoneNumber") {
            $id = intval($_GET['id']);
            echo "<tr>
                     <td colspan='7'>
                         <div class='alert'><h3 style='text-align: center; color:red'>Невалиден номер или вече съществуващ такъв</h3></div>
                     </td>
                  </tr>";
            echo "<tr>
                    <td colspan='7'>
                    <div style='display:flex; justify-content: center'>
                    <a href='/autosalon/editEmployee.php?id=$id' style='text-align: center; margin:10px;  text-decoration: none; font-size: 18px; color:green'>Редактирай отново</a>
                    <a href='/autosalon/employees.php' style='text-align: center; margin: 10px; text-decoration: none; font-size: 18px; color:green'>Върни се към служители</a>
                    </div>
                  </tr>";
            $showForm = false;
        }

        if (isset($_GET["id"]) && $showForm) {
            $id = intval($_GET["id"]);
            $conn->select_db("autosalon");

            $query = "SELECT e.id, e.first_name, e.last_name, p.name, e.phone FROM employees e
                    JOIN positions p on e.position_id = p.id
                    WHERE e.id = $id;";
            $result = mysqli_query($conn, $query);

            if ($employee = mysqli_fetch_assoc($result)) {
                echo "<form  method='post'>
                        <tr>
                            <td>{$employee['id']}<input type='hidden' name='id' value='{$employee["id"]}'></td>
                            <td><input type='text' name='firstName' value='{$employee["first_name"]}'></td>
                            <td><input type='text' name='lastName' value='{$employee["last_name"]}'></td>
                            <td><input type='text' name='position' value='{$employee["name"]}'></td>
                            <td><input type='text' name='phoneNumber' value='{$employee["phone"]}'></td>
                            <td><button type='submit' class='btn'>Редактирай</button></td>
                        </tr>
                    </form>";
                echo "<tr>
                    <td colspan='7'>
                    <div style='display:flex; justify-content: center'>
                    <a href='/autosalon/editЕmployee.php?id=$id' style='text-align: center; margin:10px;  text-decoration: none; font-size: 18px; color:green'>Редактирай отново</a>
                    <a href='/autosalon/employees.php' style='text-align: center; margin: 10px; text-decoration: none; font-size: 18px; color:green'>Върни се към служители</a>
                    </div>
                  </tr>";

            } else {
                echo "<tr><td colspan='7' style='text-align:center; color:red;'>Служителят не е намерен.</td></tr>";
            }
        }
        ?>
    </table>

</div>
</body>
</html>
