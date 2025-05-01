<?php
    include ("config.php");
    include ("navbar.php");
    ?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/fifthReport.css">
    <link rel="stylesheet" href="styles/font.css">
    <title>Топ 5 служители</title>
</head>
    <body>
        <div class="container">
            <h1 style="padding-top: 20px">Топ 5 служители </h1>
            <?php
            $query = "SELECT 
                    CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
                    p.name AS p_name,
                    COUNT(s.id) AS total_sales
                    FROM sales s
                    JOIN employees e ON s.employee_id = e.id
                    LEFT JOIN positions p ON e.position_id = p.id
                    GROUP BY e.id
                    ORDER BY total_sales DESC
                    LIMIT 5;";
            $result = mysqli_query($conn, $query);


            echo "<table>
                        <tr>
                            <th>Служител</th>
                            <th>Позиция</th>
                            <th>Брой продажби</th>
                        </tr>";
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['employee_name'] . "</td>";
                    echo "<td>" . $row['p_name'] . "</td>";
                    echo "<td>" . $row['total_sales'] . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </div>
    </body>
</html>

