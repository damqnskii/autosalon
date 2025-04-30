<?php
    include ("config.php");
    include ("navbar.php");
?>

<!DOCTYPE html>
<html lang="bg">
<link rel="stylesheet" href="styles/cars.css">
<link rel="stylesheet" href="styles/font.css">
<link rel="stylesheet" href="styles/tableforseachAuto.css">
<body>

<div class="container">
    <h1>Автомобили</h1>
    <form class="add-form" action="/autosalon/addCar.php" method="Get">
        <div class="add-box-form">
            <button type="submit" class="btn">Добавяне на нов автомобил</button>
        </div>
    </form>
    <table>
        <tr>
            <th>#</th>
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
            $stmt = $conn->prepare("SELECT c.id, b.name as brand_name, m.name as model_name, c.year, co.name as color_name, c.mileage, c.price, c.status FROM cars c
                    JOIN brands b ON c.brand_id = b.id
                    JOIN colors co ON c.color_id = co.id
                    JOIN models m ON c.model_id = m.id ;");
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['brand_name'] . "</td>";
                echo "<td>" . $row['model_name'] . "</td>";
                echo "<td>" . $row['year'] . "</td>";
                echo "<td>" . $row['color_name'] . "</td>";
                echo "<td>" . $row['mileage'] . ' км' ."</td>";
                echo "<td>" . $row['price'] . ' лв.' . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td style='display: flex; flex-direction-column;align-content: center;justify-content: space-evenly;'>
                    <form action='editCar.php' method='get'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button class='btn' type='submit'>Редактиране</button>
                    </form>
                    
                    <form action='deleteCar.php?id={$row['id']}' method='post'>
                        <button class='btn' type='submit'>Изтриване</button>
                    </form>";
                if ($row['status'] == 'свободна') {
                    echo "<form action='sellCar.php?id={$row['id']}' method='post'>
                        <button class='btn' type='submit'>Продаване</button>
                    </form>";
                }
                echo "</td>";
            }
        ?>
    </table>
</div>
</body>
</html>
