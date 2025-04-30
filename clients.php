<?php
include("config.php");
include("navbar.php");
?>
<!DOCTYPE html>
<html lang="bg">
<link rel="stylesheet" href="styles/clients.css">
<link rel="stylesheet" href="styles/font.css">
<link rel="stylesheet" href="styles/tableforseachAuto.css">
<body>

<div class="container">
    <h1>Клиенти</h1>
    <form class="add-form" action="/autosalon/addClient.php" method="Get">
        <div class="add-box-form">
            <button type="submit" class="btn">Добавяне на нов клиент</button>
        </div>
    </form>
        <table>
            <tr>
                <th>#</th>
                <th>Име</th>
                <th>Фамилия</th>
                <th>Адрес</th>
                <th>Телефон</th>
                <th>Email</th>
                <th></th>
            </tr>

            <?php

            $conn->select_db("autosalon");
            $result = mysqli_query($conn, "SELECT * FROM clients");
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                <td>{$i}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['address']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['email']}</td>
                <td style='display: flex; flex-direction-column;align-content: center;justify-content: space-evenly;'>
                    <form action='editClient.php' method='get'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button class='btn' type='submit' value='{$row['id']}'>Редактиране</button>
                    </form>
                    
                    <form action='deleteClient.php?id={$row['id']}' method='post'>
                        <button class='btn' type='submit'>Изтриване</button>
                    </form>
                </td>
            </tr>";
                $i++;
            }
            ?>
        </table>
</div>

</body>
</html>