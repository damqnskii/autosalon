<?php
    include ("config.php");
    include ("navbar.php");
    ?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/thirdReport.css">
    <link rel="stylesheet" href="styles/font.css">
    <title>Закупени автомобили от клиент</title>
</head>
<body>
<div class="container">
    <div class="container">
        <form action="" method="get">
            <label for="firstName">Въведете името на клиента</label>
            <input type="text" name="firstName">
            <label for="lastName">Въведете фамилията на клиента</label>
            <input type="text" name="lastName">
            <button type="submit">Търси</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['firstName']) && isset($_GET['lastName'])) {
            $firstName = $_GET['firstName'];
            $lastName = $_GET['lastName'];

            echo "<h2 style='text-align: center'>Закупени коли от клиент</h2>";
            echo "<h3 style='text-align: center; color: green; font-size: 26px'>" . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName) . "</h3>";

            $query = $conn->prepare("SELECT c.id, b.name AS brand_name, m.name AS model_name, c.year, c.mileage, co.name AS color_name, c.price 
                    FROM sales s
                    JOIN cars c ON s.car_id = c.id
                    JOIN clients cl ON s.client_id = cl.id
                    JOIN brands b ON c.brand_id = b.id
                    JOIN models m ON c.model_id = m.id
                    JOIN colors co ON c.color_id = co.id
                    WHERE cl.first_name = ? AND cl.last_name = ?");
            $query->bind_param("ss", $firstName, $lastName);
            $query->execute();
            $result = $query->get_result();

            echo "<table>
            <tr>
                <th>Номер</th>
                <th>Марка</th>
                <th>Модел</th>
                <th>Година</th>
                <th>Цвят</th>
                <th>Километри</th>
                <th>Цена</th>
            </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["brand_name"] . "</td>";
                echo "<td>" . $row["model_name"] . "</td>";
                echo "<td>" . $row["year"] . "</td>";
                echo "<td>" . $row["color_name"] . "</td>";
                echo "<td>" . $row["mileage"] . "</td>";
                echo "<td>" . $row["price"] . " лв.</td>";
                echo "</tr>";
            }

            echo "</table>";
        }
        ?>
