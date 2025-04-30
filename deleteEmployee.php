<?php
    include "config.php";

    if (isset($_GET["id"])) {
        $id = intval ($_GET["id"]);

        $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header ("location: employees.php");
            exit();
        } else {
            echo "Грешка при изтриване";
        }
    } else {
        echo "Невалиден идентификатор.";
    }

?>

