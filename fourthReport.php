<?php
    include ("config.php");
    include ("navbar.php");
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/fourthReport.css">
    <link rel="stylesheet" href="styles/font.css">
    <title>Продажби за период</title>
</head>
    <body>
        <div class="container">
            <h1 style="padding-top: 20px">Продажби за период</h1>
            <form action="" method="post">
                <div class="period-input">
                    <label for="period">Период</label>
                    <input type="date" name="start" placeholder="начало">
                    <span>-</span>
                    <input type="date" name="end" placeholder="край">
                    <button type="submit">Търси</button>
                </div>
            </form>
        </div>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $start = $_POST["start"];
                $end = $_POST["end"];
                $query = "SELECT s.sale_date, CONCAT_WS(' ', e.first_name, e.last_name) as employee_name, p.name as p_name, 
                        CONCAT_WS(' ', cl.first_name, cl.last_name) as client_name, cl.phone, 
                        c.id, b.name as brand_name, m.name as model_name, c.price FROM sales s
                        JOIN employees e ON s.employee_id = e.id
                        JOIN clients cl ON s.client_id = cl.id
                        JOIN cars c ON s.car_id = c.id
                        JOIN positions p ON e.position_id = p.id
                        JOIN brands b ON c.brand_id = b.id
                        JOIN models m ON c.model_id = m.id
                        WHERE s.sale_date BETWEEN '$start' AND '$end'
                        ORDER BY s.sale_date DESC";
                $result = $conn->query($query);
                echo "<table>
                        <tr>
                            <th>Служител</th>
                            <th>Позиция</th>
                            <th>Дата</th>
                            <th>Клиент</th>
                            <th>Телефон на кл.</th>
                            <th>Номер на кола</th>
                            <th>Марка</th>
                            <th>Модел</th>
                            <th>Година</th>
                        </tr>";
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["employee_name"] . "</td>";
                        echo "<td>" . $row["p_name"] . "</td>";
                        echo "<td>" . $row["sale_date"] . "</td>";
                        echo "<td>" . $row["client_name"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["brand_name"] . "</td>";
                        echo "<td>" . $row["model_name"] . "</td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "</tr>";
                    }
                }
            }
        ?>
    </body>
</html>
