<?php
header('Content-Type: text/html; charset=utf-8');
include 'db.php';

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

$image_id = intval($_GET['image_id'] ?? 0);
if ($image_id <= 0) {
    exit('Invalid image ID.');
}

$stmt = $db->prepare("SELECT * FROM CarImages WHERE image_id = ?");
$stmt->execute([$image_id]);
$image = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$image) {
    exit('Image not found.');
}

$cars = $db->query("SELECT car_id, make, model FROM Cars ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_image_url = $image['image_url'];

    if (!empty($_FILES['image_file']['name'])) {
        $upload_dir = 'uploads/';
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($_FILES['image_file']['type'], $allowed_types)) {
            exit('Only JPG, PNG, GIF files allowed.');
        }

        $filename = uniqid() . '_' . basename($_FILES['image_file']['name']);
        $target_path = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_path)) {
            $new_image_url = $target_path;

            if (file_exists($image['image_url']) && strpos($image['image_url'], $upload_dir) === 0) {
                unlink($image['image_url']);
            }
        } else {
            exit('Error uploading file.');
        }
    }

    if (isset($_POST['is_main'])) {
        $db->prepare("UPDATE CarImages SET is_main = FALSE WHERE car_id = ?")->execute([$_POST['car_id']]);
        $is_main = true;
    } else {
        $is_main = false;
    }

    $stmt = $db->prepare("UPDATE CarImages SET car_id = ?, image_url = ?, is_main = ? WHERE image_id = ?");
    $stmt->execute([
        $_POST['car_id'],
        $new_image_url,
        $is_main,
        $image_id
    ]);

    echo "<script>window.opener.location.reload(); window.close();</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Edit Image #<?= $image_id ?></title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f9fbfc;
            color: #2c3e50;
            max-width: 480px;
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
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        label {
            display: block;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 0.5rem;
            margin-top: 1.4rem;
        }

        select,
        input[type="file"] {
            width: 100%;
            padding: 0.6rem 0.8rem;
            font-size: 1rem;
            border: 1.7px solid #bdc3c7;
            border-radius: 8px;
            font-family: inherit;
            cursor: pointer;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
        }

        select:focus,
        input[type="file"]:focus {
            border-color: #2980b9;
            box-shadow: 0 0 6px rgba(41, 128, 185, 0.4);
            outline: none;
        }

        input[type="checkbox"] {
            width: auto;
            margin-left: 0.25rem;
            cursor: pointer;
            vertical-align: middle;
        }

        label[for="is_main"],
        label:has(input[type="checkbox"]) {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-weight: 600;
            color: #34495e;
        }

        img {
            display: block;
            max-width: 100%;
            max-height: 200px;
            border-radius: 10px;
            border: 1.5px solid #ddd;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.06);
            margin-top: 0.3rem;
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

        @media (max-width: 480px) {
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

    <h2>Edit Image #<?= $image_id ?></h2>

    <form method="POST" enctype="multipart/form-data">
        <label>
            Car:
            <select name="car_id" required>
                <?php foreach ($cars as $car): ?>
                    <option value="<?= $car['car_id'] ?>" <?= $car['car_id'] == $image['car_id'] ? 'selected' : '' ?>>
                        <?= h($car['make'] . ' ' . $car['model']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            Current Image:<br>
            <img src="<?= h($image['image_url']) ?>" alt="Current Image" style="max-width: 100%; max-height: 200px;">
        </label>

        <label>
            Upload New Image (optional):
            <input type="file" name="image_file" accept="image/*">
        </label>

        <label>
            Set as Main Image:
            <input type="checkbox" name="is_main" <?= $image['is_main'] ? 'checked' : '' ?>>
        </label>

        <button type="submit">Update Image</button>
    </form>

</body>

</html>