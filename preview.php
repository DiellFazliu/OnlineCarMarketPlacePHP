<?php
require 'db.php';

$carId = $_GET['car_id'] ?? 1;

$sql = "SELECT *, CONCAT(make, ' ', model, ' ', variant) AS title FROM cars WHERE car_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$carId]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

$imageStmt = $db->prepare("SELECT image_url FROM CarImages WHERE car_id = ? ORDER BY is_main DESC, image_id ASC");
$imageStmt->execute([$carId]);
$images = $imageStmt->fetchAll(PDO::FETCH_COLUMN);

if (!$car) {
    echo json_encode(['error' => 'Makina nuk u gjet.']);
    exit;
}

$car['images'] = $images;
$car['tagline'] = $car['variant'] ?? '';
$car['power'] = $car['horsepower'] ?? '';
$car['engine'] = $car['engine_capacity'] ?? '';
$car['fuel'] = $car['fuel_type'] ?? '';
$car['mileage'] = $car['mileage_km'] ?? '';
$car['monthly'] = $car['monthly_financing'] ?? '';
$car['price'] = $car['base_price'] ?? '';
$car['total_price'] = number_format(
    ($car['base_price'] + $car['customs_fee'] + $car['registration_fee'] + $car['delivery_fee'] + $car['service_fee']),
    2
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($car['title']) ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="preview.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div id="Banner"></div>
    <script>
        fetch('banner.html')
            .then(res => res.text())
            .then(data => document.getElementById('Banner').innerHTML = data);
        document.addEventListener('DOMContentLoaded', () => {
            const script = document.createElement('script');
            script.src = 'banner.js';
            document.body.appendChild(script);
        });
    </script>

    <p id="titulli"><?= htmlspecialchars($car['title']) ?></p>
    <div class="logos">
        <div>
            <img class="logot" src="car-logos/engine.png" />
            <p><?= htmlspecialchars($car['engine']) ?></p>
        </div>
        <div>
            <img class="logot" src="car-logos/transmission.png" />
            <p><?= htmlspecialchars($car['transmission']) ?></p>
        </div>
        <div>
            <img class="logot" src="car-logos/fuel.png" />
            <p><?= htmlspecialchars($car['fuel']) ?></p>
        </div>
        <div>
            <img class="logot" src="car-logos/road.png" />
            <p><?= htmlspecialchars($car['mileage']) ?> km</p>
        </div>
        <div>
            <img class="logot" src="car-logos/calendar.png" />
            <p><?= htmlspecialchars($car['year']) ?></p>
        </div>
    </div>

    <div class="container">
        <div class="left-content">
            <div class="left-content-up">
                <div class="slideshow">
                    <?php foreach ($images as $index => $img): ?>
                        <img src="<?= htmlspecialchars($img) ?>"
                            class="<?= $index === 0 ? 'active' : '' ?>"
                            alt="Slide <?= $index + 1 ?>"
                            data-index="<?= $index ?>"
                            onclick="openSlideshow(<?= $carId ?>, <?= $index ?>)">
                    <?php endforeach; ?>
                </div>
                <div class="controls">
                    <button id="prev">Previous</button>
                    <span class="counter" id="counter">1 / <?= count($images) ?></span>
                    <button id="next">Next</button>
                </div>
                <script>
                    const slides = document.querySelectorAll('.slideshow img');
                    const counter = document.getElementById('counter');
                    const prevButton = document.getElementById('prev');
                    const nextButton = document.getElementById('next');
                    let currentIndex = 0;

                    function updateSlide(index) {
                        slides.forEach((slide, i) => slide.classList.toggle('active', i === index));
                        counter.textContent = `${index + 1} / ${slides.length}`;
                    }

                    prevButton.addEventListener('click', () => {
                        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                        updateSlide(currentIndex);
                    });

                    nextButton.addEventListener('click', () => {
                        currentIndex = (currentIndex + 1) % slides.length;
                        updateSlide(currentIndex);
                    });

                    function openSlideshow(carId, startIndex) {
                        window.location.href = `slideshow.php?car_id=${carId}&slide=${startIndex + 1}`;
                    }
                </script>
            </div>

            <div class="left-content-down">
                <div class="right">
                    <ul>
                        <li><strong>Motor:</strong> <?= htmlspecialchars($car['engine']) ?></li>
                        <li><strong>Fuqia:</strong> <?= htmlspecialchars($car['power']) ?></li>
                        <li><strong>Transmisioni:</strong> <?= htmlspecialchars($car['transmission']) ?></li>
                        <li><strong>Karburanti:</strong> <?= htmlspecialchars($car['fuel']) ?></li>
                        <li><strong>Viti:</strong> <?= htmlspecialchars($car['year']) ?></li>
                        <li><strong>Kilometrazhi:</strong> <?= htmlspecialchars($car['mileage']) ?> km</li>
                    </ul>
                </div>
            </div>

            <div class="guarantee-section">
                <div class="guarantee-item">
                    <img src="car-logos/shield.png" alt="Icon" />
                    <h3>Kthim të parave</h3>
                    <p>Nëse nuk ju pëlqen vetura, kthejeni brenda 14 ditëve.</p>
                </div>
                <div class="guarantee-item">
                    <img src="car-logos/shield.png" alt="Icon" />
                    <h3>Blerje e sigurt</h3>
                    <p>Ne garantojmë gjendjen teknike të çdo veture.</p>
                </div>
                <div class="guarantee-item">
                    <img src="car-logos/shield.png" alt="Icon" />
                    <h3>6 muaj garancion</h3>
                    <p>Ofrojmë çdo veturë me garancion.</p>
                    <a href="#">Më shumë rreth garancive &rarr;</a>
                </div>
            </div>
        </div>

        <div class="right-content">
            <div class="right-content-up">
                <p><b><?= htmlspecialchars($car['title']) ?>: <?= htmlspecialchars($car['tagline']) ?></b><br /><br />
                    <?= nl2br(htmlspecialchars($car['description'])) ?>
                </p>
            </div>

            <div class="pricing-container">
                <div class="pricing-header">
                    <h2>Çmimi pa doganë</h2>
                    <div class="price"><?= htmlspecialchars($car['price']) ?> €</div>
                    <button class="btn" onclick="redirect()">Blej</button>
                    <div class="financing">Financim <?= htmlspecialchars($car['monthly']) ?> €/muaj</div>
                </div>
                <div class="services">
                    <h3>Totali i shërbimeve</h3>
                    <div class="service-item"><span>CarAudit™</span><span>67 €</span></div>
                    <div class="service-item"><span>Pika e dorëzimit <?= htmlspecialchars($car['location']) ?></span><span>757 €</span></div>
                    <div class="service-item"><span>Regjistrimi i veturës <span class="info">(i)</span></span><span>185 €</span></div>
                    <div class="service-item"><span>10 litra karburant falas</span><span class="free">Falas</span></div>
                    <div class="service-item"><span>Dogana <span class="info">(i)</span></span><span><?= htmlspecialchars($car['customs_fee']) ?> €</span></div>
                    <div class="service-item"><span>Garancion</span><span class="free">Falas</span></div>
                    <div class="total"><span>Totali për pagesë</span><span><?= htmlspecialchars($car['total_price']) ?> €</span></div>
                </div>
            </div>
        </div>
    </div>

    <div id="Footer"></div>
    <script>
        fetch('footer.html')
            .then(res => res.text())
            .then(data => document.getElementById('Footer').innerHTML = data);

        function redirect() {
            fetch('check_login.php')
                .then(res => res.json())
                .then(data => {
                    if (data.logged_in) {
                        window.location.href = "payment.php?car_id=<?= $carId ?>";
                    } else {
                        alert("Ju lutem kyçuni në llogarinë tuaj për të vazhduar me blerjen.");
                        window.location.href = "login.php";
                    }
                });
        }
    </script>
</body>

</html>