<?php
    include ("config.php");
    include ("navbar.php");
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/firstReport.css">
    <link rel="stylesheet" href="styles/font.css">
    <title>Последните 5 продажби</title>
</head>
<body>
    <h1 style="text-align: center">Последните 5 продажби подредени по цена</h1>
    <table>
        <tr>
            <th>Служител</th>
            <th>Позиция</th>
            <th>Дата</th>
            <th>Клиент</th>
            <th>Телефон</th>
            <th>Номер на кола</th>
            <th>Марка</th>
            <th>Модел</th>
            <th>Цена</th>
        </tr>

    <?php
        $query = "SELECT s.sale_date, CONCAT_WS(' ', e.first_name, e.last_name) as employee_name, e.position, 
                CONCAT_WS(' ', cl.first_name, cl.last_name) as client_name,cl.phone, 
                c.id, c.brand, c.model, c.price FROM sales s
                JOIN employees e ON s.employee_id = e.id
                JOIN clients cl ON s.client_id = cl.id
                JOIN cars c ON s.car_id = c.id
                ORDER BY s.sale_date DESC, c.price DESC
                LIMIT 5;";

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["employee_name"] . "</td>";
                echo "<td>" . $row["position"] . "</td>";
                echo "<td>" . $row["sale_date"] . "</td>";
                echo "<td>" . $row["client_name"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["brand"] . "</td>";
                echo "<td>" . $row["model"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "</tr>";
            }
        }

    ?>

</body>
</html>

