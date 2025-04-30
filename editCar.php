<?php
    include "Car.php";
    include "config.php";
    include "navbar.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        $id = intval ($_POST['id']);
        $brand = $_POST["brand"];
        $model = $_POST["model"];
        $year = $_POST["year"];
        $color = $_POST["color"];
        $mileage = $_POST["mileage"];
        $price = $_POST["price"];
        $status = $_POST["status"];

        $car = new Car($brand, $model, $year, $color, $mileage, $price, $status);
        if (!$car->edit($conn, $id)) {
            echo "<h3 style='color:red; text-align:center;'>Проблем с редактирането на автомобила!</h3>";
            exit();
        } else {
            header("Location: cars.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/editCar.css">
    <title>Редактиране на кола</title>
</head>
<body>
<h2 style="color: green; text-align: center">Редактиране на кола</h2>
<div class="container">
    <table>
        <tr>
            <th>Id</th>
            <th>Марка</th>
            <th>Модел</th>
            <th>Година</th>
            <th>Цвят</th>
            <th>Километри</th>
            <th>Цена</th>
            <th>Статус</th>
            <th></th>
        </tr>
        <?php
            if (isset($_GET['id']) && $_GET['id'] != "") {
                $id = intval($_GET['id']);

                mysqli_select_db($conn, "autosalon");
                $query = "SELECT c.id, b.name as brand_name, m.name as model_name, c.year, co.name as color_name, c.mileage, c.price, c.status FROM cars c
                        JOIN brands b ON c.brand_id = b.id
                        JOIN colors co ON c.color_id = co.id
                        JOIN models m ON c.model_id = m.id
                        WHERE c.id = $id;";
                $result = mysqli_query($conn, $query);

                if ($row = mysqli_fetch_assoc($result)) {
                    $currentStatus = $row['status'];
                    echo "<form method='POST'>";
                    echo "<tr>";
                    echo "<td>{$row['id']}<input type='hidden' name='id' value='{$row["id"]}'></td>";
                    echo "<td><input type='text' name='brand' value='{$row["brand_name"]}'></td>";
                    echo "<td><input type='text' name='model' value='{$row["model_name"]}'></td>";
                    echo "<td><input type='text' name='year' value='{$row["year"]}'></td>";
                    echo "<td><input type='text' name='color' value='{$row["color_name"]}'></td>";
                    echo "<td><input type='text' name='mileage' value='{$row["mileage"]}'></td>";
                    echo "<td><input type='text' name='price' value='{$row["price"]}'></td>";
                    echo "<td><select name='status'>
                            <option value='свободна' " . ($currentStatus == "свободна" ? "selected" : "") . ">свободна</option>
                            <option value='продадена' " . ($currentStatus == "продадена" ? "selected" : "") . ">продадена</option>
                            </select></td>";
                    echo "<td><button type='submit' class='btn'>Редактирай</button></td></form></tr>";
                    echo "<tr>
                    <td colspan='9'>
                    <div style='display:flex; justify-content: center'>
                        <a href='/autosalon/editCar.php?id=$id' style='text-align: center; margin:10px;  text-decoration: none; font-size: 18px; color:green'>Редактирай отново</a>
                        <a href='/autosalon/cars.php' style='text-align: center; margin: 10px; text-decoration: none; font-size: 18px; color:green'>Върни се към автомобили</a>
                    </div>
                  </tr>";
                } else {
                    echo "Няма такава кола.";
                }
            }
        ?>

    </table>
</div>
</body>
</html>