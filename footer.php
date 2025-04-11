<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<style>
 
.footer {
    background-color: #555;
    color: white;
    padding: 40px 20px;
    text-align: center;
    font-size: 14px;
    font-family: Arial, Helvetica, sans-serif;
}

.footer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
}

.footer-section {
    flex: 1;
    min-width: 250px;
    margin: 10px 0;
}

.footer-section h2 {
    color: #8de020;
    font-size: 18px;
    margin-bottom: 10px;
}

.footer-section h2 span {
    color: #fff;
}

.footer-section p {
    line-height: 1.6;
    margin: 0 0 10px;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin: 10px 0;
}

.footer-section ul li a {
    text-decoration: none;
    color: #8de020;
    transition: color 0.3s ease;
}

.footer-section ul li a:hover {
    color: #fff;
}

.footer-section .socials a {
    color: white;
    margin: 0 10px;
    font-size: 16px;
    transition: color 0.3s ease;
}

.footer-section .socials a:hover {
    color: #8de020;
}

.footer-bottom {
    margin-top: 20px;
    border-top: 1px solid #8de020;
    padding-top: 10px;
    font-size: 12px;
}
    </style>
<footer class="footer">
    <div class="footer-container">
        <div class="footer-section about">
            <h2>About <span>Autosphere</span></h2>
            <p>
                Autosphere is your one-stop platform for exploring the best cars from renowned brands. 
                Discover your dream car today!
            </p>
        </div>
        <div class="footer-section links">
            <h2>Quick Links</h2>
            <ul>
                <li><a href="/project.html">Home</a></li>
                <li><a href="/cars.html">Our Cars</a></li>
                <li><a href="/about-us.html">About Us</a></li>
                <li><a href="/howitworks.html">How It Works</a></li>
                <li><a href="/reviews.html">Reviews</a></li>
            </ul>
        </div>
        <div class="footer-section contact">
            <h2>Contact Us</h2>
            <p><i class="fas fa-envelope"></i> support@autosphere.com</p>
            <p><i class="fas fa-phone"></i> +383 45 290 001</p>
            <div class="socials">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; 2025 Autosphere | All Rights Reserved
    </div>
</footer>

</body>

</html>