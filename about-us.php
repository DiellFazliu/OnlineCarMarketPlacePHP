<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="smalldevice.css">
    <link rel="stylesheet" href="project.css">
    <title>About Us</title>
    <link rel="stylesheet" href="about-us.css">
</head>
<body>
    
<div id="menu-icon">
    <i class="fa-solid fa-bars" style="color: #8de020;"></i>
</div>
<div id="overlay1">
    <div id="menu">
            <ul style="text-align: center;">
                <li><a href="project.html"><img src="logo.png" class="logo"></a></li>
                <li class="name">AUTOSPHERE</li>
                <li><a href="project.html" class="line">Home</a></li>
                <li><a href="/cars.html" class="line">Our Cars</a></li>
                <li><a href="/about-us.html" class="line">About Us</a></li>
                <li><a href="/howitworks.html" class="line">How it works</a></li>
                <li><a href="/reviews.html" class="line">Reviews</a></li>
                <li class="dropdown">
                    <div>
                            <li class="login-text trigger-favorites"><a href="#"><i
                                        class="fa-regular fa-heart"></i>Favorite cars</a></li>
                            <input id="button" type="submit" value="Login" onclick="window.location.href='login.html';">
                            <li>
                                <div class="sign-up">
                                    <a>Don't have an account?</a> <a href="register.html" class="sign" style="color: rgb(141, 224, 32);text-decoration: none;
                            font-weight: 500;"> <br> Sign up</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const menuIcon = document.getElementById("menu-icon");
    const menu = document.getElementById("menu");
    const overlay = document.getElementById("overlay1");

    function toggleMenu() {
        menu.classList.toggle("active");
        overlay.classList.toggle("active");
    }

    menuIcon.addEventListener("click", toggleMenu);
    overlay.addEventListener("click", toggleMenu);
});
</script>
<div id="favorites-modal"
style="display: none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, -20%); width: 80%; background: white; border: 1px solid #ddd; padding: 20px; border-radius: 5px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); z-index: 1000;">
<h2>Favorites</h2>
<div id="favorites-container" style="display: flex; flex-wrap: wrap; gap: 20px;">
</div>
<button id="close-favorites"
    style="background: #8de020; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-top: 20px;">Close</button>
</div>
<div id="overlay"
style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;">
</div>
<script src="favorite1.js"></script>
</div>
    <div id="Banner">
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
      </div>
    <main>
        <div class="bg-foto">
            <img src="newlogo.webp" alt="Grande Logo" class="logo1">
        </div>

        <div class="text-line">
            <h1 class="title">About Us</h1>
            <hr class="divider">
        </div>

        <div class="about-sections">
            <div class="about-item">
                <div class="about-img" style="background-image: url('images/history.jpg');"></div>
                <div class="about-text">
                    <h2>Our History</h2>
                    <p>
                        Since 2000, Autosphere has been dedicated to transforming the car-buying experience. 
                        Founded by Filan Fisteku, our mission was clear: to redefine customer-centric service 
                        in the automotive industry.
                        <br><br>
                        Starting small, we quickly gained recognition for our curated selection of quality pre-owned vehicles. 
                        Today, Autosphere stands as a trusted name, built on integrity and personalized service.
                    </p>
                </div>
            </div>

            <div class="about-item reverse">
                <div class="about-text">
                    <h2>Our Mission</h2>
                    <p>
                        At Autosphere, our mission is to redefine the car-buying experience through transparency, 
                        quality, and exceptional service. We prioritize trust and integrity, offering a diverse 
                        selection of reliable pre-owned vehicles.
                        <br><br>
                        Your trust drives our commitment to innovation, building lasting relationships, and exceeding expectations.
                    </p>
                </div>
                <div class="about-img" style="background-image: url('images/mission.jpg');"></div>
            </div>
        </div>
    </main>
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
