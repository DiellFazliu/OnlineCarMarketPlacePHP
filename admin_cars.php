<?php
header('Content-Type: text/html; charset=utf-8');
include 'db.php';
include 'banner.php';

function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete_car') {
  $car_id = intval($_POST['car_id']);
  $stmt = $db->prepare("DELETE FROM Cars WHERE car_id = ?");
  $stmt->execute([$car_id]);
  header("Location: admin_cars.php");
  exit;
}

$stmt = $db->query("
    SELECT Cars.*, CarImages.image_url AS main_image
    FROM Cars
    LEFT JOIN CarImages ON Cars.car_id = CarImages.car_id AND CarImages.is_main = TRUE
    ORDER BY Cars.created_at DESC
");
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Admin Panel - Manage Cars</title>
  <link rel="stylesheet" href="admin_styles.css?v=2" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
    function openPopup(url, title, w, h) {
      const left = (screen.width / 2) - (w / 2);
      const top = (screen.height / 2) - (h / 2);
      window.open(url, title, `width=${w},height=${h},top=${top},left=${left},resizable=no,scrollbars=yes`);
    }

    function goBack() {
      window.history.back();
    }
  </script>
</head>

<body>

  <button onclick="goBack()">Back</button>
  <h1>Admin Panel - Cars</h1>
  <button onclick="openPopup('add_car.php', 'Add Car', 600, 700)" style="margin-left: 10px;" class="btn btn-add" >Add New Car</button>
  <a href="admin_images.php">Go to Manage Images →</a>

  <h2>Existing Cars</h2>
  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Main Image</th>
          <th>Make</th>
          <th>Model</th>
          <th>Variant</th>
          <th>Year</th>
          <th>Mileage (km)</th>
          <th>Price (€)</th>
          <th>Fuel Bonus</th>
          <th>Warranty</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cars as $car): ?>
          <tr>
            <td>
              <?= $car['main_image'] ? "<img src='" . h($car['main_image']) . "' alt='Main Image' />" : "No Image" ?>
            </td>
            <td><?= h($car['make']) ?></td>
            <td><?= h($car['model']) ?></td>
            <td><?= h($car['variant']) ?></td>
            <td><?= h($car['year']) ?></td>
            <td><?= number_format($car['mileage_km']) ?></td>
            <td><?= number_format($car['base_price'] + $car['customs_fee'] + $car['registration_fee'] + $car['delivery_fee'] + $car['service_fee'], 2) ?></td>
            <td><?= $car['fuel_bonus'] ? 'Yes' : 'No' ?></td>
            <td><?= $car['warranty_included'] ? 'Yes' : 'No' ?></td>
            <td>
              <form method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure to delete this car?');">
                <input type="hidden" name="action" value="delete_car" />
                <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>" />
                <button onclick="openPopup('edit_car.php?car_id=<?= $car['car_id'] ?>', 'Edit Car', 600, 700)" class="btn btn-edit">Edit Car</button>
                <button type="submit" class="btn btn-delete">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</body>

</html>