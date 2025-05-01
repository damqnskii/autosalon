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
    <title>Продажби на служител</title>
</head>
    <body>
        <div class="container">
            <form action="" method="get">
                <label for="firstName">Въведете името на служителя</label>
                <input type="text" name="firstName">
                <label for="lastName">Въведете фамилията на служителя</label>
                <input type="text" name="lastName">
                <button type="submit">Търси</button>
            </form>


            <?php
                if (isset($_GET["firstName"], $_GET["lastName"]) && trim($_GET["lastName"]) !== "") {
                    $firstName = $_GET["firstName"];
                    $lastName = $_GET["lastName"];
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

                    $query = $conn->prepare("SELECT s.sale_date, CONCAT_WS(' ', e.first_name, e.last_name) as employee_name, p.name as p_name,
                            CONCAT_WS(' ', cl.first_name, cl.last_name) as client_name,cl.phone, 
                            c.id, b.name as brand_name, m.name as model_name, c.year FROM sales s
                            JOIN employees e ON s.employee_id = e.id
                            JOIN positions p ON e.position_id = p.id
                            JOIN clients cl ON s.client_id = cl.id
                            JOIN cars c ON s.car_id = c.id
                            JOIN models m ON c.model_id = m.id
                            JOIN brands b ON c.brand_id = b.id
                            WHERE e.first_name = ? AND e.last_name = ?
                            ORDER BY s.sale_date;");
                    $query->bind_param("ss", $firstName, $lastName);

                    $query->execute();
                    $result = $query->get_result();
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
                            echo "<td>" . $row["year"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        die ("nqma");
                    }
                }
            ?>
            </table>
        </div>

    </body>
</html>

