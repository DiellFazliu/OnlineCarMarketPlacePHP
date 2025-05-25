<?php
header('Content-Type: text/html; charset=utf-8');
include 'db.php';

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['car_id']) || !is_numeric($_POST['car_id'])) {
        $error = "Car ID is required and must be a number.";
    } elseif (!isset($_FILES['image_file']) || $_FILES['image_file']['error'] !== UPLOAD_ERR_OK) {
        $error = "Image file is required.";
    } else {
        $car_id = intval($_POST['car_id']);
        $is_main = isset($_POST['is_main']) ? true : false;

        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $tmpName = $_FILES['image_file']['tmp_name'];
        $originalName = basename($_FILES['image_file']['name']);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($ext, $allowed)) {
            $error = "Invalid image type. Allowed: jpg, jpeg, png, gif.";
        } else {
            $newName = uniqid('carimg_') . '.' . $ext;
            $dest = $uploadDir . $newName;

            if (move_uploaded_file($tmpName, $dest)) {
                $image_url = 'uploads/' . $newName;

                if ($is_main) {
                    $db->prepare("UPDATE CarImages SET is_main = FALSE WHERE car_id = ?")->execute([$car_id]);
                }

                $stmt = $db->prepare("INSERT INTO CarImages (car_id, image_url, is_main) VALUES (?, ?, ?)");
                $stmt->execute([$car_id, $image_url, $is_main ? 'TRUE' : 'FALSE']);

                echo "<script>window.opener.location.reload(); window.close();</script>";
                exit;
            } else {
                $error = "Failed to move uploaded file.";
            }
        }
    }
}

$cars = $db->query("SELECT car_id, make, model FROM Cars ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Add New Car Image</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            margin: 3rem auto;
            max-width: 480px;
            color: #2c3e50;
            padding: 0 1rem;
        }

        h2 {
            font-weight: 700;
            color: #34495e;
            text-align: center;
            margin-bottom: 2rem;
            letter-spacing: 0.05em;
        }

        form {
            background: #ffffff;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            margin-top: 1.3rem;
            color: #34495e;
        }

        select,
        input[type="file"] {
            width: 100%;
            padding: 0.65rem 0.75rem;
            font-size: 1rem;
            border: 1.8px solid #bdc3c7;
            border-radius: 6px;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
            box-sizing: border-box;
            font-family: inherit;
            cursor: pointer;
        }

        select:focus,
        input[type="file"]:focus {
            border-color: #2980b9;
            box-shadow: 0 0 5px rgba(41, 128, 185, 0.4);
            outline: none;
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
            margin-top: 2rem;
            width: 100%;
            background-color: #2980b9;
            color: #fff;
            font-weight: 700;
            border: none;
            padding: 0.85rem;
            font-size: 1.15rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 12px rgba(41, 128, 185, 0.3);
            user-select: none;
        }

        button:hover,
        button:focus {
            background-color: #1c5980;
            outline: none;
            box-shadow: 0 6px 16px rgba(28, 89, 128, 0.6);
        }

        p[style*="color:red"] {
            background: #ffe6e6;
            color: #b71c1c;
            border: 1px solid #b71c1c;
            padding: 0.7rem 1rem;
            border-radius: 8px;
            max-width: 100%;
            margin: 1rem auto 0 auto;
            font-weight: 600;
            text-align: center;
        }

        @media (max-width: 480px) {
            body {
                margin: 1.5rem auto;
                padding: 0 0.5rem;
            }

            form {
                padding: 1.5rem 1.8rem;
            }
        }
    </style>
</head>

<body>

    <h2>Add New Car Image</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?= h($error) ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Car:
            <select name="car_id" required>
                <option value="">Select Car</option>
                <?php foreach ($cars as $car): ?>
                    <option value="<?= $car['car_id'] ?>"><?= h($car['make'] . ' ' . $car['model']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Image file: <input type="file" name="image_file" accept="image/*" required></label>

        <label><input type="checkbox" name="is_main"> Set as Main Image</label>

        <button type="submit">Upload Image</button>
    </form>

</body>

</html>