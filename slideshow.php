<?php
require 'db.php';

$carId = $_GET['car_id'] ?? 1;
$startSlide = (int) ($_GET['slide'] ?? 1);

$imageStmt = $pdo->prepare("SELECT image_url FROM CarImages WHERE car_id = ? ORDER BY is_main DESC, image_id ASC");
$imageStmt->execute([$carId]);
$images = $imageStmt->fetchAll(PDO::FETCH_COLUMN);

if (!$images) {
    echo "Nuk u gjetën imazhe për këtë makinë.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Slideshow</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="slideshow.css" />
</head>
<body>
    <div class="slideshow-container">
        <button class="close-btn" onclick="goBack()">×</button>
        <?php foreach ($images as $index => $img): ?>
            <img src="<?= htmlspecialchars($img) ?>" class="img <?= ($index + 1) === $startSlide ? 'active' : '' ?>" alt="Slide <?= $index + 1 ?>">
        <?php endforeach; ?>

        <div class="controls">
            <button id="prev" aria-label="Previous slide">&#10094;</button>
            <button id="next" aria-label="Next slide">&#10095;</button>
        </div>

        <div class="counter" id="counter"><?= $startSlide ?> / <?= count($images) ?></div>
    </div>

<script>
    let currentSlide = <?= $startSlide - 1 ?>;
    const slides = document.querySelectorAll('.img');
    const counter = document.getElementById('counter');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');

    function showSlide(index) {
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;
        slides.forEach((slide, i) => slide.classList.toggle('active', i === index));
        currentSlide = index;
        counter.textContent = `${index + 1} / ${slides.length}`;
    }

    prevBtn.addEventListener('click', () => {
        showSlide(currentSlide - 1);
    });

    nextBtn.addEventListener('click', () => {
        showSlide(currentSlide + 1);
    });

    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>