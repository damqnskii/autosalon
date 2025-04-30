<?php
    include ("config.php");
    include ("navbar.php");
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/sales.css">
    <link rel="stylesheet" href="styles/font.css">
    <title>Редактиране на кола</title>
</head>
<body>
<div class="container">
    <h1>Продажба</h1>
    <form class="add-form" action="/autosalon/sellCar.php" method="Get">
        <div class="add-box-form">
            <button type="submit" class="btn">Продажба на автомобил</button>
        </div>
    </form>
    <div class="table-container">
        <table style="background-color: #90d8a3">
            <tr><th colspan="4">Клиент</th></tr>
            <tr>
                <th>Име</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Email</th>
            </tr>
            <?php

                $query = "SELECT CONCAT_WS(' ', cl.first_name, cl.last_name) as name, cl.address, cl.phone, cl.email FROM sales
                    JOIN clients cl ON sales.client_id = cl.id;";
                    $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <table style="background-color: #3498db">
            <tr><th colspan="4">Автомобил</th></tr>
            <tr>
                <th>Номер</th>
                <th>Марка</th>
                <th>Модел</th>
                <th>Година</th>
            </tr>
            <?php
                $query = "SELECT c.id, c.brand, c.model, c.year FROM sales
                    JOIN cars c ON sales.car_id = c.id;";
                $result = mysqli_query($conn, $query);

                while($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['brand'] . "</td>";
                    echo "<td>" . $row['model'] . "</td>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "</tr>";
                }

            ?>
        </table>
        <table style="background-color: crimson">
            <tr><th colspan="4">Служител</th></tr>
            <tr>
                <th>Име</th>
                <th>Телефон</th>
                <th>Позиция</th>
                <th>Дата на продажба</th>
            </tr>
            <?php
                $query = "SELECT CONCAT_WS(' ', e.first_name, e.last_name) as name, e.phone, e.position, sale_date FROM sales
                    JOIN employees e ON sales.employee_id = e.id;";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['position'] . "</td>";
                    echo "<td>" . $row['sale_date'] . "</td>";
                    echo "</tr>";
                }
            ?>

        </table>
    </div>
</div>
</body>
</html>