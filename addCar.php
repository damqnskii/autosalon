<?php
    include "config.php";
    include "navBar.php";
    include "Car.php";
?>

<!DOCTYPE html>
<link rel="stylesheet" href="styles/addCar.css">
<html lang="bg">
<body>
<div class="container">
    <form action="" method="Post">
        <h2>Създаване на Кола</h2>
        <label for="brand">Марка</label>
        <input type="text" name="brand" required>
        <label for="model">Модел</label>
        <input type="text" name="model" required>
        <label for="year">Година на производство</label>
        <input type="text" name="year" required>
        <label for="color">Цвят</label>
        <input type="text" name="color" required>
        <label for="mileage">Изминати километри</label>
        <input type="text" name="mileage" required>
        <label for="price">Цена</label>
        <input type="text" name="price" required>
        <label for="status">Статус</label>
        <select name="status">
            <option>Свободна</option>
            <option>Продадена</option>
        </select>
        <button type="submit">Добави кола</button>
    </form>
</div>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $color = $_POST['color'];
        $mileage = $_POST['mileage'];
        $price = $_POST['price'];
        $status = $_POST['status'];

        $car = new Car($brand, $model, $year, $color, $mileage, $price, $status);

        if (!$car->add($conn)) {
            echo "Има грешка при добавянето на кола!";
            header("Location: addCar.php");
            exit();
        } else {
            header ("location: cars.php");
            exit();
        }
    }
?>
