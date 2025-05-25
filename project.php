<?php
session_start();
require_once 'db.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = $isLoggedIn && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

function getDealsOfWeek($db) {
    $deals = [];
    $query = "SELECT c.*, ci.image_url FROM cars c 
              LEFT JOIN carimages ci ON c.car_id = ci.car_id AND ci.is_main = true
              WHERE c.is_deal_of_week = true";
    $result = $db->query($query);
    
    if ($result) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $deals[] = $row;
        }
    }
    return $deals;
}

function getAllCars($db) {
    $cars = [];
    $query = "SELECT c.*, ci.image_url FROM cars c 
              LEFT JOIN carimages ci ON c.car_id = ci.car_id AND ci.is_main = true";
    $result = $db->query($query);
    
    if ($result) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $cars[] = $row;
        }
    }
    return $cars;
}

if ($isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $carId = $_POST['car_id'];
        
        if ($_POST['action'] === 'add_deal') {
            $discount = $_POST['discount'];
            $stmt = $db->prepare("UPDATE cars SET is_deal_of_week = true, discount = ? WHERE car_id = ?");
            $stmt->execute([$discount, $carId]);
        } elseif ($_POST['action'] === 'remove_deal') {
            $stmt = $db->prepare("UPDATE cars SET is_deal_of_week = false, discount = 0 WHERE car_id = ?");
            $stmt->execute([$carId]);
        }
        
        header("Location: project.php");
        exit();
    }
}

if ($isLoggedIn && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['favorite_action'])) {
        $carId = $_POST['car_id'];
        $userId = $_SESSION['user_id'];
        
        if ($_POST['favorite_action'] === 'add') {
            $checkStmt = $db->prepare("SELECT * FROM favorite_cars WHERE user_id = ? AND car_id = ?");
            $checkStmt->execute([$userId, $carId]);
            
            if ($checkStmt->rowCount() == 0) {
                $insertStmt = $db->prepare("INSERT INTO favorite_cars (user_id, car_id) VALUES (?, ?)");
                $insertStmt->execute([$userId, $carId]);
            }
        } elseif ($_POST['favorite_action'] === 'remove') {
            $deleteStmt = $db->prepare("DELETE FROM favorite_cars WHERE user_id = ? AND car_id = ?");
            $deleteStmt->execute([$userId, $carId]);
        }
        
        if (isset($_POST['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit();
        }
    }
}

$userFavorites = [];
if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT car_id FROM favorite_cars WHERE user_id = ?");
    $stmt->execute([$userId]);
    $userFavorites = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}

$car_deals = getDealsOfWeek($db);
$all_cars = $isAdmin ? getAllCars($db) : [];

function getUserFavoritesWithDetails($db, $userId) {
    $favorites = [];
    $query = "SELECT c.*, ci.image_url 
              FROM favorite_cars fc
              JOIN cars c ON fc.car_id = c.car_id
              LEFT JOIN carimages ci ON c.car_id = ci.car_id AND ci.is_main = true
              WHERE fc.user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$userId]);
    
    if ($stmt) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $favorites[] = $row;
        }
    }
    return $favorites;
}

$userFavorites = [];
$userFavoriteDetails = [];
if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT car_id FROM favorite_cars WHERE user_id = ?");
    $stmt->execute([$userId]);
    $userFavorites = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    $userFavoriteDetails = getUserFavoritesWithDetails($db, $userId);
}
?>

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
        .admin-controls {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .deal-form {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }
        .deal-form select, .deal-form input {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .original-price {
            text-decoration: line-through;
            color: #777;
        }
        .discounted-price {
            color: red;
            font-weight: bold;
        }
        .discount-badge {
            color: red;
            font-size: 0.9em;
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

    class Car
    {
        private $id;
        private $brand;
        private $model;
        private $price;
        private $image;
        private $discount;

        public function __construct($id, $brand, $model, $price, $image, $discount = 0)
        {
            $this->id = $id;
            $this->brand = $brand;
            $this->model = $model;
            $this->price = $price;
            $this->image = $image;
            $this->discount = $discount;
        }

        public function getId() {
            return $this->id;
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

        public function getDiscount()
        {
            return $this->discount;
        }

        public function getDiscountedPrice()
        {
            return $this->price * (1 - $this->discount / 100);
        }

        public function getFormattedPrice()
        {
            return '$' . number_format($this->price, 2);
        }

        public function getFormattedDiscountedPrice()
        {
            return '$' . number_format($this->getDiscountedPrice(), 2);
        }
    }

    $car_objects = [];
    foreach ($car_deals as $deal) {
        $car_objects[] = new Car(
            $deal['car_id'],
            $deal['make'],
            $deal['model'],
            $deal['base_price'],
            $deal['image_url'],
            $deal['discount']
        );
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
                            <?php if ($isLoggedIn): ?>
                                <input id="button" type="submit" value="Logout" onclick="window.location.href='logout.php';">
                            <?php else: ?>
                                <input id="button" type="submit" value="Login" onclick="window.location.href='login.php';">
                            <?php endif; ?>
                            <li>
                                <div class="sign-up">
                                    <?php if (!$isLoggedIn): ?>
                                        <a>Don't have an account?</a> <a href="register.php" class="sign" style="color: <?php echo PRIMARY_COLOR; ?>;text-decoration: none; font-weight: 500;"> <br> Sign up</a>
                                    <?php endif; ?>
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
                        <?php if ($isLoggedIn): ?>
                            <a href="#" class="dropbtn"><i class="fa-regular fa-user"></i><?php echo htmlspecialchars($_SESSION['user']); ?></a>
                        <?php else: ?>
                            <a href="#" class="dropbtn"><i class="fa-regular fa-user"></i>Login</a>
                        <?php endif; ?>
                        <ul class="dropdown-content">
                            <li class="login-text trigger-favorites"><a href="#"><i class="fa-regular fa-heart"></i>Favorite cars</a></li>
                            <?php if ($isLoggedIn): ?>
                                <input id="button" type="submit" value="Logout" onclick="window.location.href='logout.php';">
                            <?php else: ?>
                                <input id="button" type="submit" value="Login" onclick="window.location.href='login.php';">
                            <?php endif; ?>
                            <li>
                                <div class="sign-up">
                                    <?php if (!$isLoggedIn): ?>
                                        <a>Don't have an account?</a> <a href="register.php" class="sign" style="color: <?php echo PRIMARY_COLOR; ?>;text-decoration: none; font-weight: 500;"> <br> Sign up</a>
                                    <?php endif; ?>
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
        
        <?php if ($isAdmin): ?>
        <div class="admin-controls">
            <h4>Admin Controls</h4>
            <form method="post" class="deal-form">
                <input type="hidden" name="action" value="add_deal">
                <select name="car_id" required style="flex-grow: 1;">
                    <option value="">Select Car</option>
                    <?php foreach ($all_cars as $car): ?>
                        <?php if (!$car['is_deal_of_week']): ?>
                            <option value="<?php echo $car['car_id']; ?>">
                                <?php echo $car['make'] . ' ' . $car['model'] . ' ($' . number_format($car['base_price'], 2) . ')'; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="discount" min="1" max="50" placeholder="Discount %" required style="width: 100px;">
                <button type="submit" style="background: <?php echo PRIMARY_COLOR; ?>; color: white; border: none; padding: 8px 15px; border-radius: 3px; cursor: pointer;">Add to Deals</button>
            </form>
        </div>
        <?php endif; ?>
        
        <div id="cars-container" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
            <?php foreach ($car_objects as $car): ?>
                <?php
                    $previewPage = strtolower(str_replace(' ', '-', $car->getBrand() . '-' . $car->getModel())) . '-preview.php';
                    $isFavorite = $isLoggedIn && in_array($car->getId(), $userFavorites);
                ?>
                <div class="car-card" style="width: 300px; border: 1px solid #ddd; border-radius: 5px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <a href="<?php echo $previewPage; ?>">
                        <img src="<?php echo $car->getImage(); ?>" alt="<?php echo $car->getBrand() . ' ' . $car->getModel(); ?>" style="width: 100%; height: 200px; object-fit: cover;">
                    </a>

                    <div style="padding: 15px;">
                        <h4 style="margin: 0 0 10px 0; font-size: 1.2rem;"><?php echo $car->getBrand() . ' ' . $car->getModel(); ?></h4>
                        <?php if ($car->getDiscount() > 0): ?>
                            <p style="margin: 5px 0; color: #555;">
                                <span class="original-price"><?php echo $car->getFormattedPrice(); ?></span>
                                <span class="discounted-price"> <?php echo $car->getFormattedDiscountedPrice(); ?></span>
                                <span class="discount-badge"> (<?php echo $car->getDiscount(); ?>% off)</span>
                            </p>
                        <?php else: ?>
                            <p style="margin: 5px 0; color: #555;">Price: <?php echo $car->getFormattedPrice(); ?></p>
                        <?php endif; ?>
                        
                        <?php if ($isLoggedIn): ?>
                            <button class="add-to-favorites" 
                                    data-id="<?php echo $car->getId(); ?>" 
                                    data-brand="<?php echo $car->getBrand(); ?>" 
                                    data-model="<?php echo $car->getModel(); ?>" 
                                    data-price="<?php echo $car->getPrice(); ?>" 
                                    data-image="<?php echo $car->getImage(); ?>"
                                    <?php echo $isFavorite ? 'style="display:none;"' : ''; ?>>
                                <i class="fa-regular fa-heart"></i> Add to Favorites
                            </button>
                            <button class="remove-favorite" 
                                    data-id="<?php echo $car->getId(); ?>"
                                    <?php echo !$isFavorite ? 'style="display:none;"' : ''; ?>>
                                <i class="fa-solid fa-heart" style="color: red;"></i> Remove Favorite
                            </button>
                        <?php else: ?>
                            <button onclick="window.location.href='login.php';" style="background: <?php echo PRIMARY_COLOR; ?>; color: white; border: none; padding: 8px 15px; border-radius: 3px; cursor: pointer; margin-top: 10px; width: 100%;">
                                <i class="fa-regular fa-heart"></i> Login to Favorite
                            </button>
                        <?php endif; ?>
                        
                        <?php if ($isAdmin): ?>
                            <form method="post" style="margin-top: 10px;">
                                <input type="hidden" name="action" value="remove_deal">
                                <input type="hidden" name="car_id" value="<?php echo $car->getId(); ?>">
                                <button type="submit" style="background: #ff4444; color: white; border: none; padding: 8px 15px; border-radius: 3px; cursor: pointer; width: 100%;">
                                    <i class="fa-solid fa-tag"></i> Remove from Deals
                                </button>
                            </form>
                        <?php endif; ?>
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
        <?php include('footer.html'); ?>
    </div>

    <script>

const favoritesModal = document.getElementById("favorites-modal");
const overlayEl = document.getElementById("overlay");
const closeFavorites = document.getElementById("close-favorites");
const favoritesContainer = document.getElementById("favorites-container");
const triggerFavorites = document.querySelectorAll(".trigger-favorites");

function fetchAndDisplayFavorites() {
    <?php if ($isLoggedIn): ?>
        fetch('get_favorites.php')
            .then(response => response.json())
            .then(favorites => {
                if (favorites.length > 0) {
                    favoritesContainer.innerHTML = favorites.map(car => `
                        <div class="favorite-car" style="width: 200px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                            <img src="${car.image_url}" alt="${car.make} ${car.model}" style="width: 100%; height: 120px; object-fit: cover;">
                            <h4>${car.make} ${car.model}</h4>
                            <p>Price: $${car.base_price.toLocaleString()}</p>
                            <button class="remove-favorite" data-id="${car.car_id}" style="background: #ff4444; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; width: 100%;">
                                <i class="fa-solid fa-heart"></i> Remove
                            </button>
                        </div>
                    `).join("");
                    
                    document.querySelectorAll(".remove-favorite").forEach(button => {
                        button.addEventListener("click", function() {
                            const carId = this.dataset.id;
                            removeFavorite(carId);
                        });
                    });
                } else {
                    favoritesContainer.innerHTML = "<p>No favorite cars yet.</p>";
                }
            })
            .catch(error => {
                console.error('Error fetching favorites:', error);
                favoritesContainer.innerHTML = "<p>Error loading favorites. Please try again.</p>";
            });
    <?php else: ?>
        favoritesContainer.innerHTML = "<p>Please login to view your favorites.</p>";
    <?php endif; ?>
}

function removeFavorite(carId) {
    <?php if ($isLoggedIn): ?>
        fetch(window.location.href, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `favorite_action=remove&car_id=${carId}&ajax=true`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchAndDisplayFavorites();
                document.querySelector(`.add-to-favorites[data-id="${carId}"]`).style.display = 'block';
                document.querySelector(`.remove-favorite[data-id="${carId}"]`).style.display = 'none';
            }
        });
    <?php else: ?>
        alert("Please login to manage favorites.");
    <?php endif; ?>
}

triggerFavorites.forEach(trigger => {
    trigger.addEventListener("click", function(e) {
        e.preventDefault();
        favoritesModal.style.display = "block";
        overlayEl.style.display = "block";
        fetchAndDisplayFavorites();
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
        const carId = this.dataset.id;
        
        <?php if ($isLoggedIn): ?>
            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `favorite_action=add&car_id=${carId}&ajax=true`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.style.display = 'none';
                    document.querySelector(`.remove-favorite[data-id="${carId}"]`).style.display = 'block';
                    if (favoritesModal.style.display === "block") {
                        fetchAndDisplayFavorites();
                    }
                }
            });
        <?php else: ?>
            window.location.href = 'login.php';
        <?php endif; ?>
    });
});

document.querySelectorAll(".remove-favorite").forEach(button => {
    button.addEventListener("click", function() {
        const carId = this.dataset.id;
        removeFavorite(carId);
        this.style.display = 'none';
        document.querySelector(`.add-to-favorites[data-id="${carId}"]`).style.display = 'block';
    });
});
    </script>
</body>
</html>