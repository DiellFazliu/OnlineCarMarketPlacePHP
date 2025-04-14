<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="project.css">
    <link rel="stylesheet" href="smalldevice.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>AUTOSPHERE</title>
    <style>
        #favorites-container {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <?php
    define('SITE_NAME', 'AUTOSPHERE');
    define('PRIMARY_COLOR', '#8de020');

    $current_page = basename($_SERVER['PHP_SELF']);
    $brands = ['Mercedes', 'Audi', 'BMW', 'Porsche', 'RollsRoyce'];
    $models = [
        'Mercedes' => ['C Class', 'E Class', 'S Class', 'G Class'],
        'Audi' => ['A3', 'A6', 'A7', 'A8'],
        'BMW' => ['Series 3', 'Series 4', 'Series 7', 'Series 8'],
        'Porsche' => ['911', 'Taycan'],
        'RollsRoyce' => ['Dawn', 'Ghost', 'Phantom', 'Wraith']
    ];

    $car_deals = [
        [
            'brand' => 'Mercedes',
            'model' => 'E Class',
            'price' => 65000,
            'year' => 2022,
            'image' => 'Mercedes-Benz/E-class/normal/e1.jfif',
            'discount' => 10
        ],
        [
            'brand' => 'BMW',
            'model' => 'Series 7',
            'price' => 72000,
            'year' => 2023,
            'image' => 'BMW/M7/2024/b.jpg',
            'discount' => 8
        ],
        [
            'brand' => 'Audi',
            'model' => 'A6',
            'price' => 58000,
            'year' => 2021,
            'image' => 'Audi/A6/normal/a2.jfif',
            'discount' => 12
        ],
        [
            'brand' => 'Porsche',
            'model' => '911',
            'price' => 115000,
            'year' => 2023,
            'image' => 'Porsche/911/991/p.jpg',
            'discount' => 5
        ],
        [
            'brand' => 'Mercedes',
            'model' => 'C Class',
            'price' => 35000,
            'year' => 2019,
            'image' => 'Mercedes-Benz/C-class/coupe/c2.jfif',
            'discount' => 5
        ],
        [
            'brand' => 'BMW',
            'model' => 'M3',
            'price' => 75000,
            'year' => 2023,
            'image' => 'BMW/M3/m3/b2.jpg',
            'discount' => 5
        ],
        [
            'brand' => 'Audi',
            'model' => 'RS7',
            'price' => 65000,
            'year' => 2020,
            'image' => 'Audi/A7/rs7/a9.jfif',
            'discount' => 5
        ],
        [
            'brand' => 'Rolls Royce',
            'model' => 'Phantom',
            'price' => 295000,
            'year' => 2021,
            'image' => 'Rolls Royce/phantom/r.jpg',
            'discount' => 5
        ]
    ];

    function isValidEmail($email)
    {
        return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email);
    }

    function isValidDate($date)
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $date);
    }

    function isValidNumber($number)
    {
        return preg_match('/^\d+$/', $number);
    }

    class Car
    {
        private $brand;
        private $model;
        private $price;
        private $image;

        public function __construct($brand, $model, $price, $image)
        {
            $this->brand = $brand;
            $this->model = $model;
            $this->price = $price;
            $this->image = $image;
        }

        public function getBrand()
        {
            return $this->brand;
        }

        public function getModel()
        {
            return $this->model;
        }

        public function getPrice()
        {
            return $this->price;
        }

        public function getImage()
        {
            return $this->image;
        }

        public function setPrice($newPrice)
        {
            if ($newPrice > 0) {
                $this->price = $newPrice;
                return true;
            }
            return false;
        }

        public function getFormattedPrice()
        {
            return '$' . number_format($this->price, 2);
        }
    }


    $car_objects = [];
    foreach ($car_deals as $deal) {
        $car_objects[] = new Car($deal['brand'], $deal['model'], $deal['price'], $deal['image']);
    }


    usort($car_objects, function ($a, $b) {
        return $a->getPrice() <=> $b->getPrice();
    });
    ?>

    <div id="menu-icon">
        <i class="fa-solid fa-bars" style="color: <?php echo PRIMARY_COLOR; ?>;"></i>
    </div>
    <div id="overlay1">
        <div id="menu">
            <ul style="text-align: center;">
                <li><a href="project.php"><img src="logo.png" class="logo"></a></li>
                <li class="name"><?php echo SITE_NAME; ?></li>
                <li><a href="project.php" class="line">Home</a></li>
                <li><a href="cars.php" class="line">Our Cars</a></li>
                <li><a href="about-us.php" class="line">About Us</a></li>
                <li><a href="howitworks.php" class="line">How it works</a></li>
                <li><a href="reviews.php" class="line">Reviews</a></li>
                <li class="dropdown">
                    <div>
                        <ul>
                            <li class="login-text trigger-favorites"><a href="#"><i class="fa-regular fa-heart"></i>Favorite cars</a></li>
                            <input id="button" type="submit" value="Login" onclick="window.location.href='login.php';">
                            <li>
                                <div class="sign-up">
                                    <a>Don't have an account?</a> <a href="register.php" class="sign" style="color: <?php echo PRIMARY_COLOR; ?>;text-decoration: none; font-weight: 500;"> <br> Sign up</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div id="section-1">
        <nav class="navbar">
            <ul>
                <li><a href="project.php"><img src="logo.png" class="logo"></a></li>
                <li class="name"><?php echo SITE_NAME; ?></li>
                <li><a href="project.php" class="line <?php echo ($current_page == 'project.php') ? 'active' : ''; ?>">Home</a></li>
                <li><a href="cars.php" class="line <?php echo ($current_page == 'cars.php') ? 'active' : ''; ?>">Our Cars</a></li>
                <li><a href="about-us.php" class="line <?php echo ($current_page == 'about-us.php') ? 'active' : ''; ?>">About Us</a></li>
                <li><a href="howitworks.php" class="line <?php echo ($current_page == 'howitworks.php') ? 'active' : ''; ?>">How it works</a></li>
                <li><a href="reviews.php" class="line <?php echo ($current_page == 'reviews.php') ? 'active' : ''; ?>">Reviews</a></li>
                <li><a href="#" class="favorite trigger-favorites"><i class="fa-regular fa-heart" id="icon-regular"></i>
                        <i class="fa-solid fa-heart" id="icon-solid"></i></a></li>

                <li class="dropdown">
                    <div>
                        <a href="#" class="dropbtn"><i class="fa-regular fa-user"></i>Login</a>
                        <ul class="dropdown-content">
                            <li class="login-text trigger-favorites"><a href="#"><i class="fa-regular fa-heart"></i>Favorite cars</a></li>
                            <input id="button" type="submit" value="Login" onclick="window.location.href='login.php';">
                            <li>
                                <div class="sign-up">
                                    <a>Don't have an account?</a> <a href="register.php" class="sign" style="color: <?php echo PRIMARY_COLOR; ?>;text-decoration: none; font-weight: 500;"> <br> Sign up</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </div>

    <div id="section-2">
        <div id="sllogani">
            <p id="slg0">Drive Your Dream</p>
            <p id="slg">Only a Click Away!</p>
        </div>
        <div id="section-3">
            <div class="right">
                <div class="horizontale">
                    <div>
                        <button class="btnMenu" id="brandButton">Brand &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#9660;</button>
                        <ul style="list-style: none; padding: 0; margin: 0; display: none; max-height: 100px; overflow-y: scroll; border: 1px solid #ddd;" class="Menu" id="brandMenu">
                            <?php foreach ($brands as $brand): ?>
                                <li><a href="#" data-brand="<?php echo $brand; ?>"><?php echo $brand; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div>
                        <button class="btnMenu" id="modelButton">Model&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#9660;</button>
                        <ul style="list-style: none; padding: 0; margin: 0; display: none; max-height: 150px; overflow-y: scroll; border: 1px solid #ddd;" class="Menu" id="modelMenu">
                        </ul>
                    </div>
                </div>
                <input id="extrapart" class="extra-part" type="submit" value="Search" style="height: 32px; width: 170px; border:rgba(141,224,32,1); background: <?php echo PRIMARY_COLOR; ?>;color:white">
            </div>
        </div>
    </div>

    <div id="favorites-modal" style="display: none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, -20%); width: 80%; background: white; border: 1px solid #ddd; padding: 20px; border-radius: 5px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); z-index: 1000;">
        <h2>Favorites</h2>
        <div id="favorites-container" style="display: flex; flex-wrap: wrap; gap: 20px;">
        </div>
        <button id="close-favorites" style="background: <?php echo PRIMARY_COLOR; ?>; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-top: 20px;">Close</button>
    </div>
    <div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

    <div id="available-cars" style="padding: 20px; margin-top: 20px; background: white;">
    <h3 style="text-align: center; font-size: 2.8rem">Deals of the Week</h3>
    <div id="cars-container" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
        <?php foreach ($car_objects as $car): ?>
            <?php
                $previewPage = strtolower(str_replace(' ', '-', $car->getBrand() . '-' . $car->getModel())) . '-preview.php';
            ?>
            <div class="car-card" style="width: 300px; border: 1px solid #ddd; border-radius: 5px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <a href="<?php echo $previewPage; ?>">
                    <img src="<?php echo $car->getImage(); ?>" alt="<?php echo $car->getBrand() . ' ' . $car->getModel(); ?>" style="width: 100%; height: 200px; object-fit: cover;">
                </a>

                <div style="padding: 15px;">
                    <h4 style="margin: 0 0 10px 0; font-size: 1.2rem;"><?php echo $car->getBrand() . ' ' . $car->getModel(); ?></h4>
                    <p style="margin: 5px 0; color: #555;">Price: <?php echo $car->getFormattedPrice(); ?></p>
                    <button class="add-to-favorites" data-brand="<?php echo $car->getBrand(); ?>" data-model="<?php echo $car->getModel(); ?>" data-price="<?php echo $car->getPrice(); ?>" data-image="<?php echo $car->getImage(); ?>" style="background: <?php echo PRIMARY_COLOR; ?>; color: white; border: none; padding: 8px 15px; border-radius: 3px; cursor: pointer; margin-top: 10px;">Add to Favorites</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


    <section id="car-security" style="background-image: url(bmwm4.jpg);position: relative;background-size: cover;background-position: center ; padding: 30px 20px;">
        <div class="container">
            <h3 style="text-align: center;padding-top: 0; margin-bottom: 40px; font-size: 2.8rem; color: white; font-weight: 600;">Your next car waits to Us</h3>
            <h3 style="text-align: center;padding-top: 0; margin-bottom: 40px; font-size: 2.8rem;margin-top: 480px; color: white; font-weight: 600;">We Deliver Your Car, Directly to Your Home</h3>
        </div>
    </section>
    <div id="white" style="height: 8px;background: white;"></div>

    <div id="white" style="height: 8px;background: white;"></div>

    <div id="Footer">
        <?php include('footer.php'); ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menuIcon = document.getElementById("menu-icon");
            const menu = document.getElementById("menu");
            const overlay = document.getElementById("overlay1");

            function toggleMenu() {
                menu.classList.toggle("active");
                overlay.classList.toggle("active");
            }

            menuIcon.addEventListener("click", toggleMenu);
            overlay.addEventListener("click", toggleMenu);

            const models = <?php echo json_encode($models); ?>;

            let selectedBrand = "";
            let selectedModel = "";

            const combinations = {
                "mercedes": "Mercedes.php",
                "mercedes-c-class": "mercedesC.php",
                "mercedes-e-class": "mercedesE.php",
                "mercedes-s-class": "mercedesS.php",
                "mercedes-g-class": "mercedesG.php",
                "bmw": "BMW.php",
                "bmw-series-3": "bmwm3.php",
                "bmw-series-4": "bmwm4.php",
                "bmw-series-7": "bmw7.php",
                "bmw-series-8": "bmw8.php",
                "audi": "Audi.php",
                "audi-a3": "audia3.php",
                "audi-a6": "audia3.php",
                "audi-a7": "audi7.php",
                "audi-a8": "audi8.php",
                "porsche": "Porsche.php",
                "porsche-911": "porsche911.php",
                "porsche-taycan": "porschetaycan.php",
                "rollsroyce": "RollsRoyce.php",
                "rollsroyce-dawn": "rollsroycedawn.php",
                "rollsroyce-ghost": "rollsroyceghost.php",
                "rollsroyce-phantom": "rollsroycephantom.php",
                "rollsroyce-wraith": "rollsroycewraith.php",
            };

            document.querySelectorAll("#brandMenu a").forEach(item => {
                item.addEventListener("click", function(e) {
                    e.preventDefault();
                    selectedBrand = this.dataset.brand;
                    document.getElementById("brandButton").textContent = selectedBrand;

                    const modelList = models[selectedBrand] || [];
                    const modelMenu = document.getElementById("modelMenu");
                    modelMenu.innerHTML = modelList.map(model => `<li><a href="#" data-model="${model}">${model}</a></li>`).join("");
                    document.getElementById("modelButton").textContent = "Model";
                    modelMenu.style.display = "none";
                });
            });

            document.getElementById("modelMenu").addEventListener("click", function(e) {
                if (e.target.tagName === "A") {
                    e.preventDefault();
                    selectedModel = e.target.dataset.model;
                    document.getElementById("modelButton").textContent = selectedModel;
                }
            });

            document.getElementById("extrapart").addEventListener("click", function() {
                let key = "";

                if (selectedBrand) {
                    key = selectedBrand.toLowerCase().replace(/\s+/g, '-');
                    if (selectedModel) {
                        key += '-' + selectedModel.toLowerCase().replace(/\s+/g, '-');
                    }
                }

                if (!selectedBrand && !selectedModel) {
                    window.location.href = "cars.php";
                } else if (combinations[key]) {
                    window.location.href = combinations[key];
                } else {
                    alert("No page found for this combination. Please select valid options.");
                }
            });

            document.querySelectorAll(".btnMenu").forEach(button => {
                button.addEventListener("click", function() {
                    const menuId = this.id.replace("Button", "Menu");
                    const menu = document.getElementById(menuId);
                    const isVisible = menu.style.display === "block";
                    document.querySelectorAll(".Menu").forEach(menu => (menu.style.display = "none"));
                    menu.style.display = isVisible ? "none" : "block";
                });
            });

            const favoritesModal = document.getElementById("favorites-modal");
            const overlayEl = document.getElementById("overlay");
            const closeFavorites = document.getElementById("close-favorites");
            const favoritesContainer = document.getElementById("favorites-container");
            const triggerFavorites = document.querySelectorAll(".trigger-favorites");

            let favorites = JSON.parse(localStorage.getItem("favorites")) || [];

            function updateFavoritesDisplay() {
                favoritesContainer.innerHTML = favorites.length > 0 ?
                    favorites.map(car => `
            <div class="favorite-car" style="width: 200px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                <img src="${car.image}" alt="${car.brand} ${car.model}" style="width: 100%; height: 120px; object-fit: cover;">
                <h4>${car.brand} ${car.model}</h4>
                <p>Price: $${car.price.toLocaleString()}</p>
                <button class="remove-favorite" data-brand="${car.brand}" data-model="${car.model}" style="background: #ff4444; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Remove</button>
            </div>
        `).join("") :
                    "<p>No favorite cars yet.</p>";

                document.querySelectorAll(".remove-favorite").forEach(button => {
                    button.addEventListener("click", function() {
                        const brand = this.dataset.brand;
                        const model = this.dataset.model;
                        favorites = favorites.filter(car => !(car.brand === brand && car.model === model));
                        localStorage.setItem("favorites", JSON.stringify(favorites));
                        updateFavoritesDisplay();
                    });
                });
            }
            triggerFavorites.forEach(trigger => {
                trigger.addEventListener("click", function(e) {
                    e.preventDefault();
                    favoritesModal.style.display = "block";
                    overlayEl.style.display = "block";
                    updateFavoritesDisplay();
                });
            });

            closeFavorites.addEventListener("click", function() {
                favoritesModal.style.display = "none";
                overlayEl.style.display = "none";
            });

            overlayEl.addEventListener("click", function() {
                favoritesModal.style.display = "none";
                this.style.display = "none";
            });

            document.querySelectorAll(".add-to-favorites").forEach(button => {
                button.addEventListener("click", function() {
                    const brand = this.dataset.brand;
                    const model = this.dataset.model;
                    const price = parseFloat(this.dataset.price);
                    const image = this.dataset.image;

                    const exists = favorites.some(car => car.brand === brand && car.model === model);

                    if (!exists) {
                        favorites.push({
                            brand,
                            model,
                            price,
                            image
                        });
                        localStorage.setItem("favorites", JSON.stringify(favorites));
                        alert(`${brand} ${model} added to favorites!`);
                    } else {
                        alert(`${brand} ${model} is already in your favorites!`);
                    }
                });
            });
        });
    </script>
</body>

</html>