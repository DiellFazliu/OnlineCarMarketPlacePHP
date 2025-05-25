<?php
header('Content-Type: text/html; charset=utf-8');
include 'db.php';

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("INSERT INTO Cars (make, model, variant, year, month_registered, engine_capacity, horsepower, fuel_type, transmission, mileage_km, base_price, customs_fee, registration_fee, delivery_fee, service_fee, fuel_bonus, warranty_included, location, monthly_financing, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
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
        $_POST['description']
    ]);
    echo "<script>window.opener.location.reload(); window.close();</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Add New Car</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f7f9fc;
            margin: 2rem;
            color: #333;
        }

        h2 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: #222;
        }

        form {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            max-width: 480px;
            margin: auto;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.4rem;
            margin-top: 1rem;
            color: #444;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 0.45rem 0.6rem;
            font-size: 1rem;
            border: 1.5px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            border-color: #007BFF;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 70px;
        }

        input[type="checkbox"] {
            width: auto;
            margin-right: 0.5rem;
            vertical-align: middle;
        }

        label input[type="checkbox"] {
            display: inline-block;
            margin-top: 0;
            margin-bottom: 0;
            vertical-align: middle;
        }

        button {
            margin-top: 1.5rem;
            background-color: #007BFF;
            color: white;
            font-weight: 600;
            border: none;
            padding: 0.65rem 1.5rem;
            font-size: 1.1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        button:hover {
            background-color: #0056b3;
        }

        p[style*="color:red"] {
            background: #ffdddd;
            color: #a33;
            border: 1px solid #a33;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            max-width: 480px;
            margin: 1rem auto 0 auto;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <h2>Add New Car</h2>
    <form method="POST">
        <label>Make: <input type="text" name="make" required></label>
        <label>Model: <input type="text" name="model" required></label>
        <label>Variant: <input type="text" name="variant"></label>
        <label>Year: <input type="number" name="year" min="1900" max="2100" required></label>
        <label>Month Registered: <input type="number" name="month_registered" min="1" max="12" required></label>
        <label>Engine Capacity: <input type="number" step="0.1" name="engine_capacity" required></label>
        <label>Horsepower: <input type="number" name="horsepower" required></label>
        <label>Fuel Type: <input type="text" name="fuel_type" required></label>
        <label>Transmission: <input type="text" name="transmission" required></label>
        <label>Mileage (km): <input type="number" name="mileage_km" required></label>
        <label>Base Price (€): <input type="number" step="0.01" name="base_price" required></label>
        <label>Customs Fee (€): <input type="number" step="0.01" name="customs_fee" required></label>
        <label>Registration Fee (€): <input type="number" step="0.01" name="registration_fee" required></label>
        <label>Delivery Fee (€): <input type="number" step="0.01" name="delivery_fee" required></label>
        <label>Service Fee (€): <input type="number" step="0.01" name="service_fee" required></label>
        <label>Fuel Bonus: <input type="checkbox" name="fuel_bonus"></label>
        <label>Warranty Included: <input type="checkbox" name="warranty_included"></label>
        <label>Location: <input type="text" name="location" required></label>
        <label>Monthly Financing (€): <input type="number" step="0.01" name="monthly_financing" required></label>
        <label>Description:<br><textarea name="description" rows="3"></textarea></label>
        <button type="submit">Add Car</button>
    </form>

</body>

</html>