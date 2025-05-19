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
        $query = "SELECT s.sale_date, CONCAT_WS(' ', e.first_name, e.last_name) as employee_name, p.name as p_name, 
                CONCAT_WS(' ', cl.first_name, cl.last_name) as client_name,cl.phone, 
                c.id, b.name as brand_name, m.name as model_name, c.price FROM sales s
                JOIN employees e ON s.employee_id = e.id
                JOIN clients cl ON s.client_id = cl.id
                JOIN cars c ON s.car_id = c.id
                JOIN positions p ON e.position_id = p.id
                JOIN brands b ON c.brand_id = b.id
                JOIN models m ON c.model_id = m.id
                ORDER BY s.sale_date DESC, c.price DESC
                LIMIT 5;";

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["employee_name"] . "</td>";
                echo "<td>" . $row["p_name"] . "</td>";
                echo "<td>" . $row["sale_date"] . "</td>";
                echo "<td>" . $row["client_name"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["brand_name"] . "</td>";
                echo "<td>" . $row["model_name"] . "</td>";
                echo "<td>" . $row["price"] . " лв</td>";
                echo "</tr>";
            }
        }

    ?>

</body>
</html>

