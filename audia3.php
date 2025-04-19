<?php
define('SITE_NAME', 'Car Marketplace');
define('DEFAULT_CURRENCY', '€');
define('TRANSPORT_FEE', 757);
define('DEFAULT_RESULTS_COUNT', 23049);

define('EMAIL_PATTERN', '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/');
define('PHONE_PATTERN', '/^\+?\d{10,15}$/');
define('PRICE_PATTERN', '/^\d+(\.\d{1,2})?$/');

$pageTitle = "Car Listings";
$totalResults = DEFAULT_RESULTS_COUNT;


class Car
{
    protected $id;
    protected $brand;
    protected $model;
    protected $price;
    protected $year;
    protected $mileage;
    protected $power;
    protected $fuelType;
    protected $image;
    protected $features = [];

    public function __construct($id, $brand, $model, $price, $year, $mileage, $power, $fuelType, $image, $features = [])
    {
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->price = $price;
        $this->year = $year;
        $this->mileage = $mileage;
        $this->power = $power;
        $this->fuelType = $fuelType;
        $this->image = $image;
        $this->features = $features;
    }


    public function getId()
    {
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
    public function getYear()
    {
        return $this->year;
    }
    public function getMileage()
    {
        return $this->mileage;
    }
    public function getPower()
    {
        return $this->power;
    }
    public function getFuelType()
    {
        return $this->fuelType;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function getFeatures()
    {
        return $this->features;
    }


    public function setPrice($price)
    {
        if (preg_match(PRICE_PATTERN, $price)) {
            $this->price = $price;
            return true;
        }
        return false;
    }


    public function displayInfo()
    {
        return "{$this->mileage} km | {$this->year} | {$this->power} hp | {$this->fuelType}";
    }

    public function calculateMonthlyPayment($months = 60, $interest = 0.05)
    {
        $monthlyRate = $interest / 12;
        $payment = ($this->price * $monthlyRate) / (1 - pow(1 + $monthlyRate, -$months));
        return round($payment, 2);
    }
}

class ElectricCar extends Car
{
    private $batteryCapacity;
    private $range;

    public function __construct($id, $brand, $model, $price, $year, $mileage, $power, $image, $features, $batteryCapacity, $range)
    {
        parent::__construct($id, $brand, $model, $price, $year, $mileage, $power, 'Electric', $image, $features);
        $this->batteryCapacity = $batteryCapacity;
        $this->range = $range;
    }

    public function getBatteryCapacity()
    {
        return $this->batteryCapacity;
    }
    public function getRange()
    {
        return $this->range;
    }
}


$models = [
    'Mercedes' => ["C Class", "E Class", "S Class", "G Class"],
    'Audi' => ["A3", "A6", "A7", "A8"],
    'BMW' => ["Series 3", "Series 4", "Series 7", "Series 8"],
    'Porsche' => ["Taycan", "991", "992"],
    'Rolls Royce' => ["Phantom", "Dawn", "Wraith", "Ghost"]
];

$combinations = [
    "mercedes" => "Mercedes.php",
    "mercedes-c-class" => "mercedesC.php",
    "mercedes-e-class" => "mercedesE.php",
    "mercedes-s-class" => "mercedesS.php",
    "mercedes-g-class" => "mercedesG.php",
    "bmw" => "BMW.php",
    "bmw-series-3" => "bmwm3.php",
    "bmw-series-4" => "bmwm4.php",
    "bmw-series-7" => "bmw7.php",
    "bmw-series-8" => "bmw8.php",
    "audi" => "Audi.php",
    "audi-a3" => "audia3.php",
    "audi-a6" => "audia6.php",
    "audi-a7" => "audia7.php",
    "audi-a8" => "audia8.php",
    "porsche" => "Porsche.php",
    "porsche-911" => "porsche911.php",
    "porsche-taycan" => "porschetaycan.php",
    "rollsroyce" => "RollsRoyce.php",
    "rollsroyce-dawn" => "rollsroycedawn.php",
    "rollsroyce-ghost" => "rollsroyceghost.php",
    "rollsroyce-phantom" => "rollsroycephantom.php",
    "rollsroyce-wraith" => "rollsroycewraith.php"
];


$cars = [
    new Car(
        1,
        'Audi',
        'A3',
        35835,
        '03/2024',
        0,
        320,
        'Petrol',
        'Audi/A3/normal/a.jfif',
        ['Ulese sportive', 'Auto parking', 'Quattro']
    ),
    new Car(
        2,
        'Audi',
        'A3 Coupe',
        25750,
        '03/2019',
        123500,
        200,
        'Diesel',
        'Audi/A3/kabriolet/a.jfif',
        ['Ulese me nxemje', 'Funksion masazhi ne ulese', 'Timonin me nxemje']
    )
];


usort($cars, function ($a, $b) {
    return $a->getPrice() <=> $b->getPrice();
});


session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['email']) && !preg_match(EMAIL_PATTERN, $_POST['email'])) {
        $emailError = "Invalid email format";
    }


    if (isset($_POST['filter'])) {
        $selectedBrand = $_POST['brand'] ?? '';
        $selectedModel = $_POST['model'] ?? '';

        if ($selectedBrand) {
            $totalResults = count(array_filter($cars, function ($car) use ($selectedBrand, $selectedModel) {
                $brandMatch = $car->getBrand() === $selectedBrand;
                $modelMatch = !$selectedModel || stripos($car->getModel(), $selectedModel) !== false;
                return $brandMatch && $modelMatch;
            }));
        }
    }
}


function displayFeatures($features, $maxVisible = 3)
{
    $visible = array_slice($features, 0, $maxVisible);
    $hiddenCount = count($features) - $maxVisible;

    $html = '';
    foreach ($visible as $feature) {
        $html .= "<span>$feature</span>";
    }

    if ($hiddenCount > 0) {
        $html .= "<span>+$hiddenCount more</span>";
    }

    return $html;
}

function formatPrice($price)
{
    return number_format($price, 2, '.', ',') . DEFAULT_CURRENCY;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="menubar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>
<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
        font-family: Arial, Helvetica, sans-serif;
        color: #333;
    }

    header {
        position: sticky;
        top: 0;
        background-color: #333;
        color: white;
        padding: 10px 0;
        text-align: center;
        z-index: 1000;
    }

    #container-custom {
        display: flex;
        justify-content: space-between;
        margin: 20px auto;
        max-width: 1200px;
        margin-top: 100px;
    }

    .filters-custom {
        width: 30%;
        min-width: 250px;
        background-color: white;
        margin-left: 10px;
        border-radius: 10px;
        padding: 10px;
        position: fixed;
        top: 90px;
        left: 0;
        max-height: fit-content;
        z-index: 1000;
        overflow-y: auto;
        height: 100vh;
        display: flex;
        flex-direction: column;
        padding: 10px;
        margin-top: 10px;
    }

    .listings-custom {
        margin-left: 35%;
        width: 65%;
        min-width: 500px;
    }

    .filters-custom h3 {
        color: #28a745;
        margin-bottom: 15px;
    }

    .filters-custom button {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .Menu-custom {
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }

    .Menu-custom::-webkit-scrollbar {
        width: 6px;
    }

    .Menu-custom::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .Menu-custom::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .Menu-custom::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .btnMenu-custom {
        width: 100%;
        padding: 7px;
        font-size: 13px;
        font-weight: bold;
        background-color: rgba(255, 255, 255, 0.9);
        color: #2c2b2b;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .btnMenu-custom:hover {
        background-color: rgba(141, 224, 32, 0.6);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        color: white;
    }

    .Menu-custom {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
    }

    .Menu-custom li {
        margin: 5px 0;
    }

    .Menu-custom li a {
        text-decoration: none;
        color: black;
        font-size: 14px;
    }

    .Menu-custom li a:hover {
        text-decoration: underline;
    }

    .extra-part-custom {
        width: 100px;
        border: 1px solid #aaa5a5;
        height: 30%;
        padding: 6px;
        background-color: rgba(141, 224, 32, 0.6);
        border-radius: 10px;
    }

    .guarantee-section {
        display: block;
        margin-top: 5px;
        width: 95%;
        background-color: white;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .guarantee-item {
        text-align: center;
        margin: 5px 0;
        padding: 5px;
        border-bottom: 1px solid #ccc;
        display: block;
    }

    .guarantee-item:last-child {
        border-bottom: none;
    }

    .guarantee-item img {
        width: 30px;
        height: 30px;
    }

    .guarantee-item h3 {
        font-size: 0.9rem;
        margin: 5px 0;
        color: #333;
    }

    .guarantee-item p {
        font-size: 0.5rem;
        color: #555;
    }

    .guarantee-item a {
        display: block;
        margin-top: 5px;
        font-size: 0.5rem;
        color: #007b55;
        text-decoration: none;
        font-weight: bold;
    }

    .guarantee-item a:hover {
        text-decoration: underline;
    }

    footer {
        margin-top: 20px;
        background-color: #333;
        color: white;
        text-align: center;
    }

    .card-custom {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        display: flex;
        padding: 20px;
        gap: 20px;
    }

    .card-custom img {
        width: 200px;
        height: auto;
        border-radius: 8px;
    }

    .card-custom .details-custom {
        flex-grow: 1;
    }

    .card-custom .details-custom h4 {
        color: #28a745;
        margin-bottom: 10px;
    }

    .card-custom .details-custom .tags-custom {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .card-custom .details-custom .tags-custom span {
        background-color: #eaf7e9;
        color: #28a745;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.9rem;
    }

    .card-custom .details-custom .price-custom {
        margin-top: 15px;
        font-size: 1.2rem;
        font-weight: bold;
        color: #28a745;
    }

    .card-custom .details-custom .location-custom,
    .card-custom .details-custom .monthly-payment-custom {
        font-size: 0.9rem;
        color: #555;
    }

    .card-custom .btn-save-custom {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 4px;
        display: inline-block;
        margin-top: 15px;
    }

    .card-custom .btn-save-custom:hover {
        background-color: #218838;
    }

    .filter-btn {
        background-color: white;
        color: #28a745;
        border: none;
        border-radius: 10px;
        text-align: center;
        margin-top: 80px;
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-left: auto;
        margin-right: auto;
        width: fit-content;
        margin-bottom: -60px;

    }

    .close-btn-test {
        background-color: white;
        color: black;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 20px;
        right: 20px;
        cursor: pointer;
        font-size: 18px;
        font-weight: bold;

    }

    .close-btn-test:hover {
        background-color: grey;
    }

    .card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    #brandMenu-custom,
    #modelMenu-custom {
        list-style: none;
    }


    @media (min-width: 1025px) {
        .filter-btn {
            display: none;
        }

        .close-btn-test {
            display: none;
        }
    }

    @media (max-width: 1024px) {
        .filter-btn {
            display: block;
        }

        .close-btn-test {
            display: block;
        }

        .guarantee-section {
            position: relative;
            margin-top: 20px;
            margin-right: 0;
        }

        .filters-custom {
            position: absolute;
            width: 100%;
            background-color: rgba(141, 224, 32, 0.8);
            color: white;
            display: none;
            padding: 15px;
            height: fit-content;
        }

        .filters-custom.active {
            display: block;
        }

        .filters-custom button {
            width: 100%;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
            font-size: 14px;
        }

        .listings-custom {
            margin-left: 0;
            width: 100%;
        }

        .extra-part-custom {
            width: 100%;
        }

        .guarantee-section {
            position: static;
        }

        .guarantee-section {
            position: relative;
            margin-top: 20px;
            margin-right: 0;
        }

    }



    @media (max-width: 768px) {
        .filters-custom {
            width: 100%;
            position: relative;
            top: 0;
            left: 0;
        }

        .listings-custom {
            margin-left: 0;
            width: 100%;
        }

        .card-custom {
            display: block;
            text-align: center;
        }

        .card-custom img {
            margin: 0 auto;
            width: 100%;
            height: auto;
        }

        .card-custom .details-custom {
            text-align: left;
            margin-top: 10px;
        }
    }

    @media (max-width: 480px) {
        .filters-custom {
            width: 110%;
            padding: 15px;
            top: 0;
        }

        .listings-custom {
            margin-left: 0;
            width: 100%;
            height: auto;
        }

        .extra-part-custom {
            width: 100%;
        }
    }
</style>

<body>
    <div id="Banner"></div>
    <script>
        fetch('banner.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('Banner').innerHTML = data;
            });
    </script>

    <button class="filter-btn">Show Filters</button>
    <div id="container-custom">
        <div class="filters-custom" style="flex: 1 1 35%;">
            <button class="close-btn-test">&times;</button>
            <div class="still">
                <h3>Filter Options</h3>
                <form method="POST">
                    <div class="horizontale-custom">
                        <div>
                            <button type="button" class="btnMenu-custom" id="brandButton-custom">Brand &#9660;</button>
                            <ul class="Menu-custom" id="brandMenu-custom" style="display: none;">
                                <?php foreach ($models as $brand => $modelList): ?>
                                    <li><a href="#" data-brand="<?= htmlspecialchars($brand) ?>"><?= htmlspecialchars($brand) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <input type="hidden" name="brand" id="selectedBrand" value="">
                        </div>
                        <div>
                            <button type="button" class="btnMenu-custom" id="modelButton-custom">Model &#9660;</button>
                            <ul class="Menu-custom" id="modelMenu-custom" style="display: none;"></ul>
                            <input type="hidden" name="model" id="selectedModel" value="">
                        </div>
                    </div>
                    <input type="submit" name="filter" id="extrapart-custom" class="extra-part-custom"
                        value="<?= $totalResults ?> total results">
                </form>

                <script>
                    const models = <?= json_encode($models) ?>;
                    const combinations = <?= json_encode($combinations) ?>;

                    $(document).ready(function() {
                        let selectedBrand = "";
                        let selectedModel = "";

                        $(".filter-btn").click(function() {
                            $(".filters-custom").toggleClass("active");
                        });

                        $(".close-btn-test").click(function() {
                            $(".filters-custom").removeClass("active");
                        });

                        $("#brandMenu-custom a").click(function(e) {
                            e.preventDefault();
                            selectedBrand = $(this).data("brand");
                            $("#brandButton-custom").text(selectedBrand);
                            $("#selectedBrand").val(selectedBrand);
                            $("#brandMenu-custom").slideUp(500);

                            const modelList = models[selectedBrand] || [];
                            const modelItems = modelList.map(model => `<li><a href="#" data-model="${model}">${model}</a></li>`).join("");
                            $("#modelMenu-custom").html(modelItems);
                            $("#modelButton-custom").text("Model");
                        });
                        

                        $("#modelMenu-custom").on("click", "a", function(e) {
                            e.preventDefault();
                            selectedModel = $(this).data("model");
                            $("#modelButton-custom").text(selectedModel);
                            $("#selectedModel").val(selectedModel);
                            $("#modelMenu-custom").slideUp(500);
                        });

                        $(".btnMenu-custom").click(function() {
                            const menuId = $(this).attr("id").replace("Button-custom", "Menu-custom");
                            $(".Menu-custom").not(`#${menuId}`).slideUp(500);
                            $(`#${menuId}`).stop(true, true).slideToggle(500);
                        });
                    });
                </script>
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

        <div class="listings-custom" style="flex: 1 1 60%;">
            <?php foreach ($cars as $car): ?>
                <a href="<?= strtolower($car->getBrand()) . '-' . strtolower(str_replace(' ', '-', $car->getModel())) ?>-preview.php" class="card-link">
                    <div class="card-custom">
                        <img src="<?= htmlspecialchars($car->getImage()) ?>" alt="<?= htmlspecialchars($car->getBrand() . ' ' . $car->getModel()) ?>">
                        <div class="details-custom">
                            <h4><?= htmlspecialchars($car->getBrand() . ' ' . $car->getModel()) ?></h4>
                            <p><?= htmlspecialchars($car->displayInfo()) ?></p>
                            <div class="tags-custom">
                                <?= displayFeatures($car->getFeatures()) ?>
                            </div>
                            <p class="location-custom">Germany: transport: <?= TRANSPORT_FEE ?><?= DEFAULT_CURRENCY ?></p>
                            <p class="monthly-payment-custom">Monthly payment: <?= $car->calculateMonthlyPayment() ?><?= DEFAULT_CURRENCY ?></p>
                            <p class="price-custom"><?= formatPrice($car->getPrice()) ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>


</body>

</html>