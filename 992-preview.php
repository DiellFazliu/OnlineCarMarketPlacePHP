<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Preview</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f9;
        }

        /* Header */
        header {
            background-color: #333;
            color: white;
            padding: 15px 20px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header h1 {
            font-size: 24px;
            font-weight: bold;
        }

        /* Title */
        #titulli {
            font-size: 2.5rem;
            text-align: center;
            margin: 60px 100px 10px;
            color: #000;
        }

        /* Logos Section */
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

        /* Main Content */
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
            /* Barazon lartësinë e të gjithë div-ëve */
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            margin-top: -50px;
            max-width: 1200px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .guarantee-item {
            text-align: center;
            flex: 1;
            padding: 10px;
            margin: 0 10px;
            border-right: 1px solid #ccc;
            /* Vijë ndarëse në të djathtë */
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Përmbajtja qendrore vertikalisht */
        }

        .guarantee-item:last-child {
            border-right: none;
            /* Hiq vijën ndarëse për div-in e fundit */
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

        /* Footer */
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
            .logos{
                display: none;
            }


        }
    </style>
</head>

<body>
    <div id="Banner"></div>
    <script>
        fetch('banner.html')
          .then(response => response.text())
          .then(data => {
            document.getElementById('Banner').innerHTML = data;
          });
      </script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          const script = document.createElement('script');
          script.src = 'banner.js';
          document.body.appendChild(script);
        });
      </script>

    <p id="titulli">Audi A3 Cabriolet</p>
    <div class="logos">
        <div>
            <img class="logot" src="car-logos/engine.png">
            <p>2.0 Diesel(180Ps)</p>
        </div>
        <div>
            <img class="logot" src="car-logos/transmission.png">
            <p>Automatic</p>
        </div>
        <div>
            <img class="logot" src="car-logos/fuel.png">
            <p>Diesel</p>
        </div>
        <div>
            <img class="logot" src="car-logos/road.png">
            <p>100000km</p>
        </div>
        <div>
            <img class="logot" src="car-logos/calendar.png">
            <p>08/2021</p>
        </div>
    </div>

    <div class="container">
        <div class="left-content">
            <div class="left-content-up">
                <div class="slideshow">
                    <img src="Audi/A3/kabriolet/a.jfif" alt="Slide 1" class="active">
                    <img src="Audi/A3/kabriolet/a1.jfif" alt="Slide 2">
                    <img src="Audi/A3/kabriolet/a2.jfif" alt="Slide 3">
                    <img src="Audi/A3/kabriolet/a3.jfif" alt="Slide 4">
                </div>
<<<<<<< HEAD
=======
                
                <script>
                    function openSlide(slideNumber) {
                        const baseUrl = "992-slideshow.html";
                        const fullUrl = `${baseUrl}?slide=${slideNumber}`;
                        window.location.href = fullUrl;
                    }
                </script>
>>>>>>> e48b517e355337484a8114ef3315773123dc7f69

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
                        <li><strong>Motor:</strong> <span>6.6L V12</span></li>
                        <li><strong>Fuqia:</strong> <span>420 kW</span></li>
                        <li><strong>Transmisioni:</strong> <span>Automatik</span></li>
                        <li><strong>Karburanti:</strong> <span>Benzinë</span></li>
                        <li><strong>Viti:</strong> <span>2021</span></li>
                        <li><strong>Kilometrazhi:</strong> <span>30,000 km</span></li>
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
                    <a href="#">Më shumë rreth garancive &rarr;</a>
                </div>
            </div>
        </div>
        <div class="right-content">
            <div class="right-content-up">
                <p><b>Audi A3 Cabriolet: Eleganca dhe Performanca në Qiell të Hapur</b><br><br>

                    Audi A3 Cabriolet është një nga makinat më tërheqëse dhe elegante të klasës kompakte luksoze, e
                    krijuar
                    për të ofruar një eksperiencë të paharrueshme drejtimi nën qiell të hapur. Ky model kombinon
                    mjeshtërisht
                    dizajnin modern, teknologjinë më të fundit dhe performancën e fuqishme për të kënaqur si drejtuesin
                    ashtu
                    edhe pasagjerët.

                    <br><b>Dizajni</b><br>
                    Audi A3 Cabriolet ka një pamje dinamike dhe sportive, me linja të pastra dhe proporcione perfekte.
                    Kabina e saj e hapur shton ndjesinë e luksit, ndërsa tavanin e butë me palosje automatike mund ta
                    hapni
                    ose mbyllni brenda vetëm 18 sekondave, edhe kur makina është në lëvizje deri në 50 km/h.

                    <br><b>Performanca</b><br>
                    Nën kapak, Audi A3 Cabriolet vjen me një gamë motorësh të fuqishëm dhe efikas, duke përfshirë
                    opsione
                    benzine dhe nafte.
                </p>
            </div>
            <div class="pricing-container">
                <div class="pricing-header">
                    <h2>Çmimi pa doganë</h2>
                    <div class="price">390 423 €</div>
                    <button class="btn" onclick="redirect()">Blej</button>

<script>
  function redirect() {
    window.location.href = "payment.html";
  }
</script>
                    <div class="financing">Financim 8 321 €/muaj</div>
                </div>
                <script>
                    document.getElementById('payment').addEventListener('click', function() {
                      window.location.href = 'payment.html';
                    });
                  </script>

                <div class="services">
                    <h3>Totali i shërbimeve</h3>
                    <div class="service-item">
                        <span>CarAudit™</span>
                        <span>67 €</span>
                    </div>
                    <div class="service-item">
                        <span>Pika e dorëzimit Prishtina, Kosovo</span>
                        <span>757 €</span>
                    </div>
                    <div class="service-item">
                        <span>Regjistrimi i veturës <span class="info">(i)</span></span>
                        <span>185 €</span>
                    </div>
                    <div class="service-item">
                        <span>10 litra karburant falas</span>
                        <span class="free">Falas</span>
                    </div>
                    <div class="service-item">
                        <span>Dogana <span class="info">(i)</span></span>
                        <span>40 118 €</span>
                    </div>
                    <div class="service-item">
                        <span>Garancion</span>
                        <span class="free">Falas</span>
                    </div>

                    <div class="total">
                        <span>Totali për pagesë</span>
                        <span>509 196 €</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="Footer"></div>
    <script>
        fetch('footer.html')
          .then(response => response.text())
          .then(data => {
            document.getElementById('Footer').innerHTML = data;
          });
      </script>
</body>

</html>