<?php
    include "config.php";
    include "navbar.php";
    include "Car.php";
    include "Client.php";
    include "Employee.php";
    include "Sell.php";
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/sellCar.css">
    <link rel="stylesheet" href="styles/font.css">
    <title>Продажба на кола</title>
</head>
<body>
    <h1 style="color: green; text-align: center; padding: 15px;">Продажба на кола</h1>
    <form action="sellCar.php" method="post">
    <div class="container">
        <div class="card client-side">
            <h2 style="color: #218838;">Клиент</h2>
            <p>Информация за клиент</p>
            <label for="clientFirstName">Име</label>
            <input type="text" name="clientFirstName" required>

            <label for="clientLastName">Фамилия</label>
            <input type="text" name="clientLastName" required>

            <label for="clientPhoneNumber">Телефонен Номер</label>
            <input type="text" name="clientPhoneNumber" required>

            <label for="clientEmail">Email</label>
            <input type="text" name="clientEmail" required>

            <label for="clientAddress">Адрес</label>
            <input type="text" name="clientAddress" required>
        </div>
        <div class="card car-side">
            <h2 style="color: #90522b">Кола</h2>
            <p>Информация за колата</p>
            <?php
            if (isset($_GET["id"])) {
                $carId = intval ($_GET["id"]);

                $query = "SELECT c.id, b.name as brand_name, m.name as model_name, c.year, co.name as color_name, c.mileage, c.price FROM cars c
                        JOIN brands b ON c.brand_id = b.id
                        JOIN colors co ON c.color_id = co.id
                        JOIN models m ON c.model_id = m.id
                        WHERE c.id = $carId";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);

                echo '
                    <label for="id">Номер на колата</label>
                    <input type="text" name="carId" value="'.$row['id'].'" disabled>
                    <label for="brand">Марка</label>
                    <input type="text" name="brand" value="'.$row['brand_name'].'" required>
                    <label for="model">Модел</label>
                    <input type="text" name="model" value="'.$row['model_name'].'" required>
                    <label for="year">Година</label>
                    <input type="text" name="year" value="'.$row['year'].'" required>
                    <label for="color">Цвят</label>
                    <input type="text" name="color" value="'.$row['color_name'].'" required>
                    <label for="mileage">Изминати километри</label>
                    <input type="text" name="mileage" value="'.$row['mileage'].'" required>
                    <label for="price">Цена</label>
                    <input type="text" name="price" value="'.$row['price'].'" required>
                        ';
            } else {
                echo '
                    <label for="id">Номер на колата</label>
                    <input type="text" name="carId">
                    <label for="brand">Марка</label>
                    <input type="text" name="brand" required>
                    <label for="model">Модел</label>
                    <input type="text" name="model" required>
                    <label for="year">Година</label>
                    <input type="text" name="year" required>
                    <label for="color">Цвят</label>
                    <input type="text" name="color" required>
                    <label for="mileage">Изминати километри</label>
                    <input type="text" name="mileage" required>
                    <label for="price">Цена</label>
                    <input type="text" name="price" required>
                        ';
            } ?>

        </div>
        <div class="card employee-side">
            <h2 style="color: #2980b9">Служител</h2>
            <p>Информация за служител</p>
            <label for="employeeFirstName">Име</label>
            <input type="text" name="employeeFirstName" required>
            <label for="employeeLastName">Фамилия</label>
            <input type="text" name="employeeLastName" required>
            <label for="employeePhoneNumber">Телефонен Номер</label>
            <input type="text" name="employeePhoneNumber" required>
            <label for="position">Позиция</label>
            <input type="text" name="position" required>
            <label for="sellingDate">Дата на продажба</label>
            <input type="date" name="sellingDate" required>
        </div>
    </div>
        <button class="btn" type="submit">Продай колата</button>
    </form>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["clientFirstName"]) && isset($_POST['employeeFirstName'])) {
        $clientFirstName = $_POST['clientFirstName'];
        $clientLastName = $_POST['clientLastName'];
        $clientPhoneNumber = $_POST['clientPhoneNumber'];
        $clientEmail = $_POST['clientEmail'];
        $clientAddress = $_POST['clientAddress'];

        $query1 = $conn->prepare("SELECT id FROM clients WHERE first_name = ? and last_name = ? and phone = ? and email = ?;");
        $query1->bind_param("ssss", $clientFirstName, $clientLastName, $clientPhoneNumber, $clientEmail);
        $query1->execute();
        $result = $query1->get_result();
        $clientId = $result->fetch_assoc();

        if (!$clientId) {
            echo ("няма такъв клиент");
        }

        $employeeFirstName = $_POST['employeeFirstName'];
        $employeeLastName = $_POST['employeeLastName'];
        $employeePhoneNumber = $_POST['employeePhoneNumber'];
        $employeePosition = $_POST['position'];
        $sellingDate = $_POST['sellingDate'];

        $query = $conn->prepare("SELECT e.id FROM employees e
        JOIN positions p ON e.position_id = p.id
          WHERE first_name = ? and last_name = ? and p.name = ?");
        $query->bind_param("sss", $employeeFirstName, $employeeLastName, $employeePosition);
        $query->execute();
        $result = $query->get_result();
        $employeeId = $result->fetch_assoc();


        if (!$employeeId) {
            echo ("няма такъв служител");
        }

        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $color = $_POST['color'];
        $mileage = $_POST['mileage'];
        $price = $_POST['price'];

        $stmt = $conn->prepare("SELECT c.id FROM cars c
            JOIN brands b ON c.brand_id = b.id
            JOIN colors co ON c.color_id = co.id
            JOIN models m ON c.model_id = m.id
            WHERE b.name = ? AND m.name = ? AND year = ? AND co.name = ? AND mileage = ? AND price = ?");
        $stmt->bind_param("ssisid",$brand, $model, $year, $color, $mileage, $price);
        $stmt->execute();
        $result = $stmt->get_result();
        $sellingCarId = $result->fetch_assoc();

        $sell = new Sell($clientId['id'], $sellingCarId['id'], $employeeId['id'], $sellingDate);

        if (!$sell->createSell($conn)) {
            die ("Проблем в продажбата на колата.");
        } else {
            header ("Location: cars.php");
            exit();
        }
    }
?>


