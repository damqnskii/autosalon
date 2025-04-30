<?php
    include("config.php");
    include("navbar.php");
?>

<!DOCTYPE html>
<html lang="bg">
<link rel="stylesheet" href="styles/employees.css">
<link rel="stylesheet" href="styles/tableforseachAuto.css">
<link rel="stylesheet" href="styles/font.css">
<body>

<div class="container">
    <h1>Служители</h1>
    <form class="add-form" action="/autosalon/addEmployee.php" method="Get">
        <div class="add-box-form">
            <button type="submit" class="btn">Добавяне на нов служител</button>
        </div>
    </form>
    <table>
        <tr>
            <th>#</th>
            <th>Име</th>
            <th>Фамилия</th>
            <th>Телефон</th>
            <th>Позиция</th>
            <th></th>
        </tr>

        <?php

        $conn->select_db("autosalon");
        $result = mysqli_query($conn, "SELECT * FROM employees");
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$i}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['position']}</td>
                <td style='display: flex; flex-direction-column;align-content: center;justify-content: space-evenly;'>
                    <form action='editEmployee.php' method='get'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button class='btn' type='submit' value='{$row['id']}'>Редактиране</button>
                    </form>
                    
                    <form action='deleteEmployee.php?id={$row['id']}' method='post'>
                        <button class='btn' type='submit'>Изтриване</button>
                    </form>
                </td>
            </tr>";
            $i++;
        }
        ?>
    </table>
    </form>
</div>

</body>
</html>

