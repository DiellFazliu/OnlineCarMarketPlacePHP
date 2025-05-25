<?php
header('Content-Type: text/html; charset=utf-8');
include 'db.php';

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete_image') {
    $image_id = intval($_POST['image_id']);
    $stmt = $db->prepare("DELETE FROM CarImages WHERE image_id = ?");
    $stmt->execute([$image_id]);
    header("Location: admin_images.php");
    exit;
}

$images = $db->query("SELECT * FROM CarImages ORDER BY image_id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Panel - Manage Car Images</title>
    <link rel="stylesheet" href="admin_styles.css" />
    <script>
        function openPopup(url, title, w, h) {
            const left = (screen.width/2) - (w/2);
            const top = (screen.height/2) - (h/2);
            window.open(url, title, `width=${w},height=${h},top=${top},left=${left},resizable=no,scrollbars=yes`);
        }

        function goBack() {
            window.history.back();
        }
    </script>
</head>
<body>

<button onclick="goBack()">Back</button>
<h1>Admin Panel - Car Images</h1>
<button onclick="openPopup('add_image.php', 'Add Image', 600, 400)">Add New Car Image</button>
<a href="admin_cars.php">← Back to Manage Cars</a>

<h2>Existing Car Images</h2>
<table>
<thead>
    <tr>
        <th>Image ID</th>
        <th>Car ID</th>
        <th>Image</th>
        <th>Main Image</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($images as $img): ?>
    <tr>
        <td><?= $img['image_id'] ?></td>
        <td><?= $img['car_id'] ?></td>
        <td><img src="<?= h($img['image_url']) ?>" alt="Car Image" style="max-width: 100px;" /></td>
        <td><?= $img['is_main'] ? 'Yes' : 'No' ?></td>
        <td>
            <form method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure to delete this image?');">
                <input type="hidden" name="action" value="delete_image" />
                <input type="hidden" name="image_id" value="<?= $img['image_id'] ?>" />
                <button onclick="openPopup('edit_image.php?image_id=<?= $img['image_id'] ?>', 'Edit Image', 600, 400)">Edit Image</button>
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
</table>

</body>
</html>