<?php
    include ("config.php");
    include ("navbar.php");
    include ("searchFunctions.php");
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/searchAuto.css">
    <link rel="stylesheet" href="styles/font.css">
    <link rel="stylesheet" href="styles/tableforseachAuto.css">

    <title>Търсене на кола</title>
</head>
<body>
    <h1>Търсене на автомобил</h1>
    <div class="container">
        <form action="" method="post">
            <div class="filter-box">
                <label for="brand">Марка</label>
                <input type="text" name="brand">
                <label for="model">Модел</label>
                <input type="text" name="model">
                <label for="color">Цвят</label>
                <input type="text" name="color">
                <div class="price-input">
                    <label for="year">Година</label>
                    <input type="text" name="lowestYear" placeholder="начална година">
                    <span>-</span>
                    <input type="text" name="highestYear" placeholder="крайна година">
                </div>
                <div class="price-input">
                    <label for="year">Километри</label>
                    <input type="number" name="lowestMileage" placeholder="0km">
                    <span>-</span>
                    <input type="number" name="highestMileage" placeholder="999999km">
                </div>
                <div class="price-input">
                    <label for="">Цена</label>
                    <input type="number" name="minPrice" placeholder="0 лв." min="0" step="any">
                    <span>-</span>
                    <input type="number" name="maxPrice" placeholder="250000 лв." min="0" step="any">
                </div>
                    <div class="btn">
                        <button type="submit">Търси</button>
                    </div>
            </div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $brand = $_POST['brand'];
                $model = $_POST['model'];
                $color = $_POST['color'];
                $highestYear = $_POST['highestYear'];
                $lowestYear = $_POST['lowestYear'];
                $lowestMileage = $_POST['lowestMileage'];
                $highestMileage = $_POST['highestMileage'];
                $minPrice = $_POST['minPrice'];
                $maxPrice = $_POST['maxPrice'];
                $cars = filterTheCars($conn, $brand, $model, $lowestYear, $highestYear, $color, $lowestMileage, $highestMileage, $minPrice, $maxPrice);
                echo "<table><tr>
                     <th>Номер</th>
                     <th>Марка</th>
                     <th>Модел</th>
                     <th>Година</th>
                     <th>Цвят</th>
                     <th>Километри</th>
                     <th>Цена</th>
                     <th>Статус</th>
                    </tr>";
                if (sizeof($cars) == 0) {
                    echo "<tr><td colspan='8'>Няма намерена кола</td></tr>";
                } else {
                    foreach ($cars as $car) {
                        echo "<tr>";
                        echo "<td>" . ($car['id']) . "</td>";
                        echo "<td>" . ($car['brand']) . "</td>";
                        echo "<td>" . ($car['model']) . "</td>";
                        echo "<td>" . ($car['year']) . "</td>";
                        echo "<td>" . ($car['color']) . "</td>";
                        echo "<td>" . ($car['mileage']) . "</td>";
                        echo "<td>" . ($car['price']) . "</td>";
                        if ($car['status'] === 'продадена') {
                            echo "<td style='color: red'>" . ($car['status']) . "</td>";
                        } else {
                            echo "<td>" . ($car['status']) . "</td>";
                        }
                        echo "</tr>";
                    }
                }
                echo "</tr></table>";
            }
            ?>
        </form>
    </div>
        </body>
</html>
