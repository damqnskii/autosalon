<?php
    include "config.php";

    if (isset($_GET["id"])) {
        $id = intval ($_GET["id"]);

        $stmt = $conn->prepare("DELETE FROM cars WHERE id = ?");

        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header ("Location: cars.php");
            exit();
        } else {
            echo "Грешка при изтриване на автомобил.";
        }
    } else {
        echo "Грешен индетификатор";
    }

?>
