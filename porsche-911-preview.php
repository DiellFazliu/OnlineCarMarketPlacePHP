<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            color: #333;
            background-color: #f4f4f9;
        }

        #titulli {
            font-size: 2.5rem;
            text-align: center;
            margin: 30px 100px 10px;
            color: #000;
        }

        .logos {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            margin: 5px 45px;
            max-width: 100%;
        }

        .logos div {
            text-align: center;
            display: flex;
            margin: 10px;
            justify-content: center;
        }

        .logos div p {
            text-align: center;
        }

        .logot {
            height: 30px;
            width: 30px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .left-content {
            flex: 1 1 60%;
        }

        .left-content-up {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        .slideshow img {
            width: 100%;
            display: none;
            border-radius: 10px;
        }

        .slideshow img.active {
            display: block;
        }

        .slideshow img:hover {
            transform: scale(1.1);
            transition: transform 0.3s ease-in-out;
        }

        .left-content-up img {
            width: 100%;
            border-radius: 10px;
        }

        .slideshow {
            position: relative;
            max-width: 100%;
            margin: 20px auto;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .slideshow img {
            width: 100%;
            display: none;
        }

        .slideshow img.active {
            display: block;
        }

        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .controls button {
            padding: 5px 10px;
            font-size: 16px;
            border: none;
            background-color: #333;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .controls button:hover {
            background-color: #555;
        }

        .counter {
            font-size: 16px;
        }

        .left-content-down ul {
            list-style-type: none;
            padding: 0;
            margin-top: 15px;
        }

        .left-content-down ul li {
            margin: 10px 0;
            font-weight: bold;
        }

        .right-content {
            flex: 1 1 35%;

        }

        .right-content-up {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .right-content b {
            color: #8dde20;
        }

        .left-content-down .right {
            flex: 1 1 35%;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .left-content-down .right ul {
            list-style: none;
            line-height: 1.8;
        }

        .left-content-down .right ul li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .left-content-down {
            margin-top: 20px;
            margin-bottom: 0px;
        }

        .pricing-container {
            width: 100%;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .pricing-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .pricing-header h2 {
            font-size: 1.5rem;
            color: #333;
        }

        .pricing-header .price {
            font-size: 2rem;
            font-weight: bold;
            color: #8dde20;
            margin: 10px 0;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #8dde20;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .btn:hover {
            background-color: #119c3d;
        }

        .financing {
            text-align: center;
            font-size: 0.9rem;
            color: #8dde20;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .financing:hover {
            text-decoration: underline;
        }

        .services {
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .services h3 {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .services .service-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 5px 0;
            font-size: 0.9rem;
        }

        .services .service-item .info {
            color: #666;
        }

        .total {
            border-top: 2px solid #8dde20;
            margin-top: 10px;
            padding-top: 10px;
            font-size: 1.1rem;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
        }

        .free {
            color: green;
            font-weight: bold;
        }

        .guarantee-section {
            display: flex;
            justify-content: space-around;
            align-items: stretch;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            margin-top: 20px;
            max-width: 1200px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .guarantee-item {
            text-align: center;
            flex: 1;
            padding: 10px;
            margin: 0 10px;
            border-right: 1px solid #ccc;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .guarantee-item:last-child {
            border-right: none;
        }


        .guarantee-item img {
            width: 40px;
            height: 40px;
        }

        .guarantee-item h3 {
            font-size: 1.2rem;
            margin: 10px 0;
            color: #333;
        }

        .guarantee-item p {
            font-size: 0.9rem;
            color: #555;
        }

        .guarantee-item a {
            display: block;
            margin-top: 10px;
            font-size: 0.9rem;
            color: #007b55;
            text-decoration: none;
            font-weight: bold;
        }

        .guarantee-item a:hover {
            text-decoration: underline;
        }

        #previousPage {
            padding: 10px 20px;
            background-color: #f4f4f9;
            color: green;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: 20px;
            margin-top: 60px;
            margin-bottom: -100px;
        }

        #previousPage:hover {
            color: #8dde20;
        }

        footer {
            background-color: #8dde20;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            #titulli {
                text-align: center;
                font-size: 2.0rem;
            }


        }

        @media (max-width: 480px) {
            .container {
                flex-direction: column;
            }

            #titulli {
                text-align: center;
                font-size: 1.3rem;
                color: solid black;
            }

            .logos {
                display: none;
            }


        }
    </style>
</head>

<body>
    <div id="header" style="position: absolute; top: auto; left: auto;width: 100%; padding: 10px 0;"></div>
    <script>
        fetch('banner.html')
            .then(response => {
                if (!response.ok) throw new Error("Failed to fetch banner.html");
                return response.text();
            })
            .then(data => {
                document.getElementById('header').innerHTML = data;
            })
            .catch(error => console.error(error));
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const script = document.createElement('script');
            script.src = 'banner.js';
            document.body.appendChild(script);
        });
    </script>
    <div>
        <button id="previousPage">Previous Page</button>
    </div>
    <script>
        document.getElementById('previousPage').addEventListener('click', function() {
            window.history.back();
        });
    </script>
    <?php
    include 'previewOOP.php';
    $porsche991 = new car("Porsche", "911 991 Turbo", 2020, "3.8L V6", 540, "Automatik", "Benzinë", 15500, "12/2020", 120000);
    $porsche991->setImages([
        "Porsche/911/991/p.jpg",
        "Porsche/911/991/p2.jpg",
        "Porsche/911/991/p3.jpg",
        "Porsche/911/991/p4.jpg",
        "Porsche/911/991/p5.jpg",
        "Porsche/911/991/p6.jpg",
        "Porsche/911/991/p7.jpg",
        "Porsche/911/991/p8.jpg",
        "Porsche/911/991/p9.jpg",
        "Porsche/911/991/p10.jpg",
        "Porsche/911/991/p11.jpg",
        "Porsche/911/991/p12.jpg",
        "Porsche/911/991/p13.jpg"
    ]);

    $services = [
        new Service("CarAudit™", 67),
        new Service("Pika e dorëzimit Prishtina, Kosovo", 1000),
        new Service("Regjistrimi i veturës", 185, false, true),
        new Service("10 litra karburant falas", 0, true),
        new Service("Dogana", 36518, false, true),
        new Service("Garancion", 0, true)
    ];

    $totalPrice = $porsche991->getBasePrice();
    foreach ($services as $service) {
        $totalPrice += $service->getPrice();
    }
    ?>

    <p id="titulli"><?php echo $porsche991->getTitle(); ?></p>
    <div class="logos">
        <div>
            <img class="logot" src="car-logos/engine.png">
            <p><?php echo $porsche991->getEngineInfo(); ?></p>
        </div>
        <div>
            <img class="logot" src="car-logos/transmission.png">
            <p><?php echo $porsche991->getTransmission(); ?></p>
        </div>
        <div>
            <img class="logot" src="car-logos/fuel.png">
            <p><?php echo $porsche991->getFuelType(); ?></p>
        </div>
        <div>
            <img class="logot" src="car-logos/road.png">
            <p><?php echo $porsche991->getMileage(); ?>km</p>
        </div>
        <div>
            <img class="logot" src="car-logos/calendar.png">
            <p><?php echo $porsche991->getProductionDate(); ?></p>
        </div>
    </div>

    <div class="container">
        <div class="left-content">
            <div class="left-content-up">
                <div class="slideshow">
                    <?php foreach ($porsche991->getImages() as $index => $image) : ?>
                        <img src="<?php echo $image; ?>" alt="Slide <?php echo $index + 1; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>">
                    <?php endforeach; ?>
                </div>

                <script>
                    function openSlide(slideNumber) {
                        const baseUrl = "911-slideshow.php";
                        const fullUrl = `${baseUrl}?slide=${slideNumber}`;
                        window.location.href = fullUrl;
                    }
                </script>

                <div class="controls">
                    <button id="prev">Previous</button>
                    <span class="counter" id="counter">1 / 4</span>
                    <button id="next">Next</button>
                </div>

                <script>
                    const slides = document.querySelectorAll('.slideshow img');
                    const counter = document.getElementById('counter');
                    const prevButton = document.getElementById('prev');
                    const nextButton = document.getElementById('next');

                    let currentIndex = 0;

                    function updateSlide(index) {
                        slides.forEach((slide, i) => {
                            slide.classList.toggle('active', i === index);
                        });
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
                </script>
            </div>
            <div class="left-content-down">
                <div class="right">
                    <ul>
                        <?php foreach ($porsche991->getFeatures() as $feature => $value) : ?>
                            <li><strong><?php echo $feature; ?>:</strong> <span><?php echo $value; ?><span></libxml_clear_errors>
                                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="guarantee-section">
                <div class="guarantee-item">
                    <img src="car-logos/shield.png" alt="Icon">
                    <h3>Kthim të parave</h3>
                    <p>Nëse nuk ju pëlqen vetura, kthejeni brenda 14 ditëve.</p>
                </div>
                <div class="guarantee-item">
                    <img src="car-logos/shield.png" alt="Icon">
                    <h3>Blerje e sigurt</h3>
                    <p>Ne garantojmë gjendjen teknike të çdo veture.</p>
                </div>
                <div class="guarantee-item">
                    <img src="car-logos/shield.png" alt="Icon">
                    <h3>6 muaj garancion</h3>
                    <p>Ofrojmë çdo veturë me garancion.</p>
                    <a href="howitworks.php">Më shumë rreth garancive &rarr;</a>
                </div>
            </div>
        </div>
        <div class="right-content">
            <div class="right-content-up">
                <p><b>Porsche 911 991 Turbo 2020</b> është një coupe sportiv që ofron një performancë të jashtëzakonshme dhe një dizajn të klasit të parë. Ja një përshkrim i shkurtër:

                    <br><br><b>Performanca:</b><br>
                    Motori: 3.8L Twin-turbocharged 6-cylindërsh me 540 hp dhe 710 Nm moment rrotullimi.
                    Transmetimi: Automatik 7-shpejtësi PDK, me mundësi për all-wheel drive (AWD).
                    Shpejtësia: Arrin 0-100 km/h në 3.0 sekonda.
                    <br><br><b>Dizajni:</b><br>
                    Pamja e jashtme: Linja të mprehta dhe aerodinamike, grilë frontale të gjerë dhe drita LED për një pamje agresive dhe moderne.
                    Pamja e brendshme: Kabinë premium me materiale të cilësisë së lartë, sedilje sportivë dhe ekran interaktiv për komandat dhe infotainment.
                    <br><br><b>Karakteristikat:</b><br>
                    Teknologji: Apple CarPlay, Android Auto, dhe mundësi për sistemin audio Burmester për cilësi të jashtëzakonshme tingulli.
                    Siguria: Porsche Stability Management, Porsche Active Suspension Management dhe sisteme asistence për një përvojë të sigurt dhe të fuqishme drejtimi.
                </p>
            </div>
            <div class="pricing-container">
                <div class="pricing-header">
                    <h2>Çmimi pa doganë</h2>
                    <div class="price">120 000€</div>
                    <button class="btn" onclick="redirect()">Blej</button>

                    <script>
                        function redirect() {
                            window.location.href = "payment.php";
                        }
                    </script>
                    <div class="financing"><?php echo $porsche991->formatPrice(1800); ?>/muaj</div>
                </div>

                <div class="services">
                    <h3>Totali i shërbimeve</h3>
                    <?php foreach ($services as $service) : ?>
                        <div class="service-item">
                            <span><?php echo $service->getName(); ?>
                                <?php if ($service->hasInfo()): ?>
                                    <span class="info">(i)</span>';
                                <?php endif; ?>
                            </span>
                            <span><?php echo $service->isFree() ? 'Falas' : $porsche991->formatPrice($service->getPrice()); ?></span>
                        </div>
                    <?php endforeach; ?>
                    <div class="total">
                        <span>Totali i shërbimeve</span>
                        <span><?php echo $porsche991->formatPrice($totalPrice); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2025 Autosphere. Të gjitha të drejtat e rezervuara.
    </footer>
</body>

</html>