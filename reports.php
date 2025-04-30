<?php
    include ("config.php");
    include ("navbar.php");
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/reports.css">
    <link rel="stylesheet" href="styles/font.css">
    <title>Редактиране на кола</title>
</head>
<body>
    <div class="container">
        <div class="report">
            <form action="firstReport.php" method="get">
                <h2>Продадени автомобили от служител, подредени по дата на продажба</h2>
                <button type="submit">Търси</button>
            </form>
        </div>
        <div class="report">
            <form action="secondReport.php" method="get">
                <h2>Последните 5 продажби подредени по дата</h2>
                <button type="submit">Търси</button>
            </form>
        </div>
        <div class="report">
            <form action="thirdReport.php" method="get">
                <h2>Закупени автомобили от клиент</h2>
                <button type="submit">Търси</button>
            </form>
        </div>
        <div class="report">
            <form action="fourthReport.php" method="get">
                <h2>Продажби за период</h2>
                <button type="submit">Търси</button>
            </form>
        </div>
        <div class="report">
            <form action="fifthReport.php" method="get">
                <h2>Топ 5 служители с най-много продажби</h2>
                <button type="submit">Търси</button>
            </form>
        </div>
    </div>
</body>
</html>
