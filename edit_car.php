<?php
header('Content-Type: text/html; charset=utf-8');
include 'db.php';

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

$car_id = intval($_GET['car_id'] ?? 0);
if ($car_id <= 0) {
    exit('Invalid car ID.');
}

// Fetch car data
$stmt = $db->prepare("SELECT * FROM Cars WHERE car_id = ?");
$stmt->execute([$car_id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$car) {
    exit('Car not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("UPDATE Cars SET make=?, model=?, variant=?, year=?, month_registered=?, engine_capacity=?, horsepower=?, fuel_type=?, transmission=?, mileage_km=?, base_price=?, customs_fee=?, registration_fee=?, delivery_fee=?, service_fee=?, fuel_bonus=?, warranty_included=?, location=?, monthly_financing=?, description=? WHERE car_id=?");
    $stmt->execute([
        $_POST['make'],
        $_POST['model'],
        $_POST['variant'],
        $_POST['year'],
        $_POST['month_registered'],
        $_POST['engine_capacity'],
        $_POST['horsepower'],
        $_POST['fuel_type'],
        $_POST['transmission'],
        $_POST['mileage_km'],
        $_POST['base_price'],
        $_POST['customs_fee'],
        $_POST['registration_fee'],
        $_POST['delivery_fee'],
        $_POST['service_fee'],
        isset($_POST['fuel_bonus']) ? true : false,
        isset($_POST['warranty_included']) ? true : false,
        $_POST['location'],
        $_POST['monthly_financing'],
        $_POST['description'],
        $car_id
    ]);
    echo "<script>window.opener.location.reload(); window.close();</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Edit Car #<?= $car_id ?></title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            color: #2c3e50;
            max-width: 600px;
            margin: 2rem auto;
            padding: 1rem 1.5rem;
        }

        h2 {
            text-align: center;
            font-weight: 700;
            color: #34495e;
            margin-bottom: 2rem;
            letter-spacing: 0.05em;
        }

        form {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07);
        }

        label {
            display: block;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 0.6rem;
            margin-top: 1.4rem;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 0.65rem 0.8rem;
            font-size: 1rem;
            border: 1.6px solid #bdc3c7;
            border-radius: 8px;
            font-family: inherit;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: #2980b9;
            box-shadow: 0 0 8px rgba(41, 128, 185, 0.4);
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
            font-size: 0.95rem;
        }

        input[type="checkbox"] {
            width: auto;
            margin-right: 0.7rem;
            vertical-align: middle;
            cursor: pointer;
        }

        label input[type="checkbox"] {
            display: inline-block;
            margin-top: 0;
            margin-bottom: 0;
            vertical-align: middle;
        }

        button {
            margin-top: 2.5rem;
            width: 100%;
            background-color: #2980b9;
            color: #fff;
            font-weight: 700;
            border: none;
            padding: 0.85rem;
            font-size: 1.15rem;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 16px rgba(41, 128, 185, 0.35);
            user-select: none;
        }

        button:hover,
        button:focus {
            background-color: #1c5980;
            outline: none;
            box-shadow: 0 7px 20px rgba(28, 89, 128, 0.7);
        }

        @media (max-width: 600px) {
            body {
                margin: 1rem;
                padding: 0 1rem;
            }

            form {
                padding: 1.5rem 1.8rem;
            }
        }
    </style>
</head>

<body>

    <h2>Edit Car #<?= $car_id ?></h2>
    <form method="POST">
        <label>Make: <input type="text" name="make" value="<?= h($car['make']) ?>" required></label>
        <label>Model: <input type="text" name="model" value="<?= h($car['model']) ?>" required></label>
        <label>Variant: <input type="text" name="variant" value="<?= h($car['variant']) ?>"></label>
        <label>Year: <input type="number" name="year" min="1900" max="2100" value="<?= h($car['year']) ?>" required></label>
        <label>Month Registered: <input type="number" name="month_registered" min="1" max="12" value="<?= h($car['month_registered']) ?>" required></label>
        <label>Engine Capacity: <input type="number" step="0.1" name="engine_capacity" value="<?= h($car['engine_capacity']) ?>" required></label>
        <label>Horsepower: <input type="number" name="horsepower" value="<?= h($car['horsepower']) ?>" required></label>
        <label>Fuel Type: <input type="text" name="fuel_type" value="<?= h($car['fuel_type']) ?>" required></label>
        <label>Transmission: <input type="text" name="transmission" value="<?= h($car['transmission']) ?>" required></label>
        <label>Mileage (km): <input type="number" name="mileage_km" value="<?= h($car['mileage_km']) ?>" required></label>
        <label>Base Price (€): <input type="number" step="0.01" name="base_price" value="<?= h($car['base_price']) ?>" required></label>
        <label>Customs Fee (€): <input type="number" step="0.01" name="customs_fee" value="<?= h($car['customs_fee']) ?>" required></label>
        <label>Registration Fee (€): <input type="number" step="0.01" name="registration_fee" value="<?= h($car['registration_fee']) ?>" required></label>
        <label>Delivery Fee (€): <input type="number" step="0.01" name="delivery_fee" value="<?= h($car['delivery_fee']) ?>" required></label>
        <label>Service Fee (€): <input type="number" step="0.01" name="service_fee" value="<?= h($car['service_fee']) ?>" required></label>
        <label>Fuel Bonus: <input type="checkbox" name="fuel_bonus" <?= $car['fuel_bonus'] ? 'checked' : '' ?>></label>
        <label>Warranty Included: <input type="checkbox" name="warranty_included" <?= $car['warranty_included'] ? 'checked' : '' ?>></label>
        <label>Location: <input type="text" name="location" value="<?= h($car['location']) ?>" required></label>
        <label>Monthly Financing (€): <input type="number" step="0.01" name="monthly_financing" value="<?= h($car['monthly_financing']) ?>" required></label>
        <label>Description:<br><textarea name="description" rows="3"><?= h($car['description']) ?></textarea></label>
        <button type="submit">Update Car</button>
    </form>

</body>

</html>