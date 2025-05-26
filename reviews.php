<?php
session_start();
require 'db.php';

define("SITE_TITLE", "Car Reviews");
$userIP = $_SERVER['REMOTE_ADDR'];

function sanitizeString($input) {
    return preg_replace("/[^a-zA-Z0-9\s]/", "", trim($input));
}

$loggedIn = isset($_SESSION['user_id']);
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
    Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'Guest') ?>! | Your IP: <?= htmlspecialchars($userIP) ?><br>
    <?php
    try {
        $stmt = $db->query("SELECT AVG(rating) AS avg_rating FROM Reviews");
        $avg = $stmt->fetchColumn();
        echo "Average rating from DB: " . number_format($avg, 1) . "/5";
    } catch (PDOException $e) {
        echo "Average rating unavailable";
    }
    ?>
</p>

<section id="reviews-section">
    <h2 class="section-title"><?= SITE_TITLE ?></h2>

    <div id="average-rating" class="rating-box">
        <h3>Average Rating: <span id="average-stars">4.3</span> ⭐️</h3>
        <p>(Based on <span id="total-reviews">10</span> reviews)</p>
    </div>

    <div id="reviews-list" class="reviews-container">
        <?php
        try {
            $stmt = $db->query("SELECT r.content, r.rating, r.created_at, u.username 
                                FROM Reviews r 
                                LEFT JOIN Users u ON r.user_id = u.user_id 
                                ORDER BY r.created_at DESC");
            $fetchedReviews = $stmt->fetchAll();

            foreach ($fetchedReviews as $rev) {
                $name = htmlspecialchars($rev['username'] ?? 'Anonymous');
                $rating = intval($rev['rating']);
                $comment = htmlspecialchars($rev['content']);
                $date = date("F j, Y", strtotime($rev['created_at']));

                echo "<div class='review-item'>";
                echo "<p><strong>Name:</strong> $name</p>";
                echo "<p><strong>Rating:</strong> " . str_repeat("⭐️", $rating) . " ($rating/5)</p>";
                echo "<p><strong>Comment:</strong> \"$comment\"</p>";
                echo "<p class='review-date'>Published on: $date</p>";
                echo "</div>";
            }
        } catch (PDOException $e) {
            echo "<p>Error loading reviews: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>

    <?php if ($loggedIn): ?>
    <h3 class="form-title">Write a Review</h3>
    <form id="review-form" class="review-form" method="POST" action="">
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
    <?php else: ?>
        <p style="color: red; padding: 10px;">You must be logged in to submit a review.</p>
    <?php endif; ?>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $loggedIn) {
        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['user'];
        $rating = intval($_POST['review-rating']);
        $text = sanitizeString($_POST['review-text']);

        try {
            $stmt = $db->prepare("INSERT INTO Reviews (user_id, content, rating) VALUES (:user_id, :content, :rating)");
            $stmt->execute([
                'user_id' => $user_id,
                'content' => $text,
                'rating' => $rating
            ]);

            echo "<div class='review-item' style='background:#e8f5e9; padding:10px; margin-top:20px;'>";
            echo "<p><strong>New Review Submitted:</strong></p>";
            echo "<p><strong>Name:</strong> " . htmlspecialchars($username) . "</p>";
            echo "<p><strong>Rating:</strong> " . str_repeat("⭐️", $rating) . " ($rating/5)</p>";
            echo "<p><strong>Comment:</strong> \"" . htmlspecialchars($text) . "\"</p>";
            echo "</div>";
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error submitting review: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
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
