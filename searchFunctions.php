    <?php
        include ("config.php");
    function filterTheCars($conn, $brand, $model, $lowestYear, $highestYear, $color, $lowestMileage, $highestMileage, $minPrice, $maxPrice) {
        $query = "SELECT *, b.name as brand_name, m.name as model_name, co.name as color_name FROM cars c
                JOIN brands b ON c.brand_id = b.id
                JOIN colors co ON c.color_id = co.id
                JOIN models m ON c.model_id = m.id
                WHERE 1=1";
        $types = "";
        $params = [];
        if (!empty($brand)) {
            $query .= " AND b.name LIKE CONCAT('%', ?, '%')";
            $types .= "s";
            $params[] = $brand;
        }


        if (!empty($model)) {
            $query .= " AND m.name LIKE CONCAT('%', ?, '%')";
            $types .= "s";
            $params[] = $model;
        }

        if (!empty($color)) {
            $query .= " AND co.name LIKE CONCAT('%', ?, '%')";
            $types .= "s";
            $params[] = $color;
        }
        if (!empty($lowestYear) && !empty($highestYear)) {
            $query .= " AND year BETWEEN ? AND ?";
            $types .= 'ii';
            $params[] = (int)$lowestYear;
            $params[] = (int)$highestYear;
        } elseif (!empty($lowestYear)) {
            $query .= " AND year >= ?";
            $types .= 'i';
            $params[] = (int)$lowestYear;
        } elseif (!empty($highestYear)) {
            $query .= " AND year <= ?";
            $types .= 'i';
            $params[] = (int)$highestYear;
        }

        if (!empty($lowestMileage) && !empty($highestMileage)) {
            $query .= " AND mileage BETWEEN ? AND ?";
            $types .= 'ii';
            $params[] = (int)$lowestMileage;
            $params[] = (int)$highestMileage;

        } elseif (!empty($lowestMileage)) {
            $query .= " AND mileage >= ?";
            $types .= 'i';
            $params[] = (int)$lowestMileage;

        } elseif (!empty($highestMileage)) {
            $query .= " AND mileage <= ?";
            $types .= 'i';
            $params[] = (int)$highestMileage;

        }

        if (!empty($minPrice) && !empty($maxPrice)) {
            $query .= " AND price BETWEEN ? AND ?";
            $types .= 'dd';
            $params[] = (double)$minPrice;
            $params[] = (double)$maxPrice;

        } elseif (!empty($minPrice)) {
            $query .= " AND price >= ?";
            $types .= 'd';
            $params[] = (double)$minPrice;

        } elseif (!empty($maxPrice)) {
            $query .= " AND price <= ?";
            $types .= 'd';
            $params[] = (double)$maxPrice;
        }

        $stmt = $conn->prepare($query);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    ?>
