<?php
$name = "Car Reviewer";
$rating = 5;
define("SITE_TITLE", "Car Reviews");

$userIP = $_SERVER['REMOTE_ADDR'];

$numericArray = [5, 3, 1, 4, 2];
$assocArray = ["Elira" => 4, "Arben" => 5];
$multiArray = [
    ["name" => "Arben", "rating" => 5],
    ["name" => "Elira", "rating" => 4],
];

sort($numericArray);
arsort($assocArray);

$comment = "Great car!";
$commentLength = strlen($comment);

function averageRating($array) {
    $sum = 0;
    foreach ($array as $entry) {
        $sum += $entry['rating'];
    }
    return $sum / count($array);
}

class Review {
    private $name;
    private $rating;
    private $comment;

    public function __construct($name, $rating, $comment) {
        $this->name = $name;
        $this->rating = $rating;
        $this->comment = $comment;
    }

    public function getName() {
        return $this->name;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getComment() {
        return $this->comment;
    }

    public function __destruct() {}
}

class VerifiedReview extends Review {
    public function isVerified() {
        return true;
    }
}

function isValidEmail($email) {
    return preg_match("/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/", $email);
}

function isValidDate($date) {
    return preg_match("/^\d{4}-\d{2}-\d{2}$/", $date);
}

function isNumericValue($val) {
    return preg_match("/^\d+$/", $val);
}

function sanitizeString($input) {
    return preg_replace("/[^a-zA-Z0-9\s]/", "", $input);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= SITE_TITLE ?></title>
    <link rel="stylesheet" href="reviews.css">
    <script src="favorite1.js" defer></script>
    <script src="modal.js" defer></script>
</head>
<body>
<div class="menu-container">
    <button class="menu-button" onclick="toggleMenu()">☰ Menu</button>
    <div class="menu-content" id="menuContent">
        <a href="#">Home</a>
        <a href="#">Reviews</a>
        <a href="#">Contact</a>
    </div>
</div>

<div class="favorites-modal" id="favoritesModal">
    <div class="modal-content">
        <span class="close-button" onclick="closeFavoritesModal()">&times;</span>
        <h2>My Favorite Cars</h2>
        <ul id="favoritesList"></ul>
    </div>
</div>

<div id="banner">
    <?php include 'banner.php'; ?>
</div>

<p style="padding: 10px; background-color: #f4f4f4;">
    Welcome, <?= $name ?>! | Your IP: <?= $userIP ?><br>
    Average rating from PHP: <?= number_format(averageRating($multiArray), 1) ?>/5
</p>

<section id="reviews-section">
    <h2 class="section-title"><?= SITE_TITLE ?></h2>

    <div id="average-rating" class="rating-box">
        <h3>Average Rating: <span id="average-stars">4.3</span> ⭐️</h3>
        <p>(Based on <span id="total-reviews">10</span> reviews)</p>
    </div>

    <div id="reviews-list" class="reviews-container">
        <?php
        $reviews = [
            new VerifiedReview("Arben D.", 5, "The car was in perfect condition, I highly recommend!"),
            new VerifiedReview("Elira K.", 4, "Service was good, but the car had minor issues.")
        ];
        foreach ($reviews as $rev) {
            echo "<div class='review-item'>";
            echo "<p><strong>Name:</strong> " . $rev->getName() . "</p>";
            echo "<p><strong>Rating:</strong> " . str_repeat("⭐️", $rev->getRating()) . " ({$rev->getRating()}/5)</p>";
            echo "<p><strong>Comment:</strong> \"" . $rev->getComment() . "\"</p>";
            echo "<p class='review-date'>Published on: " . date("F j, Y") . "</p>";
            echo "</div>";
        }
        ?>
    </div>

    <h3 class="form-title">Write a Review</h3>
    <form id="review-form" class="review-form" method="POST" action="">
        <label for="review-name">Your Name:</label>
        <input type="text" name="review-name" id="review-name" required>

        <label for="review-rating">Rating (1-5):</label>
        <select name="review-rating" id="review-rating" required>
            <option value="5">5 - Excellent</option>
            <option value="4">4 - Very Good</option>
            <option value="3">3 - Good</option>
            <option value="2">2 - Poor</option>
            <option value="1">1 - Very Poor</option>
        </select>

        <label for="review-text">Your Comment:</label>
        <textarea name="review-text" id="review-text" required></textarea>

        <button type="submit" class="submit-btn">Submit Review</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = sanitizeString($_POST['review-name']);
        $rating = intval($_POST['review-rating']);
        $text = sanitizeString($_POST['review-text']);

        echo "<div class='review-item' style='background:#e8f5e9; padding:10px; margin-top:20px;'>";
        echo "<p><strong>New Review Submitted:</strong></p>";
        echo "<p><strong>Name:</strong> $username</p>";
        echo "<p><strong>Rating:</strong> " . str_repeat("⭐️", $rating) . " ($rating/5)</p>";
        echo "<p><strong>Comment:</strong> \"$text\"</p>";
        echo "</div>";
    }
    ?>
</section>

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
