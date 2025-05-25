<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="smalldevice.css">
    <link rel="stylesheet" href="project.css">
    <title>Payments</title>
    <style>
        #payments {
            font-family: 'Arial', sans-serif;
            background-image: url(bmw-3-0-csl-mi-05.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .payment-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .payment-title {
            text-align: center;
            font-size: 2.4rem;
            color: #333;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .payment-form .form-group {
            margin-bottom: 20px;
        }

        .payment-form label {
            font-size: 1rem;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        .payment-form input {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            border: 1px solid #298a27;
            border-radius: 5px;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .payment-form input:focus {
            border-color: #34495e;
            box-shadow: 0 0 6px rgba(52, 73, 94, 0.4);
        }

        .payment-button {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #ffffff;
            background: rgb(141, 224, 32);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .payment-button:hover {
            background: rgb(151, 247, 27);
        }

        @media (max-width: 480px) {
            .payment-container {
                padding: 20px 15px;
                margin: 0 10px;
            }

            .payment-title {
                font-size: 1.6rem;
            }
        }
    </style>
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

    <section id="payments" style="padding: 80px 20px; border-top: 4px solid #34495e;">
        <div class="payment-container" style="background-color: rgba(255, 255, 255, 0.5);backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(10px);box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);">
            <h2 class="payment-title">Mënyra e Pagesës <img src="visa&mastercard.png" style="max-width: 150px;padding-left: 30px;"></h2>
            <form id="payment-form" class="payment-form">
                <div class="form-group">
                    <label for="card-number">Numri i Kartës së Kreditit:</label>
                    <input type="text" id="card-number" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" required style="background-color: rgba(255, 255, 255, 0.5);">
                </div>
                <div class="form-group">
                    <label for="expiry-date">Data e Skadimit (MM/YY):</label>
                    <input type="text" id="expiry-date" placeholder="MM/YY" maxlength="5" required style="background-color: rgba(255, 255, 255, 0.5);">
                </div>
                <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" placeholder="123" maxlength="4" required style="background-color: rgba(255, 255, 255, 0.5);">
                </div>
                <div class="form-group">
                    <label for="cardholder-name">Emri i Mbajtësit të Kartës:</label>
                    <input type="text" id="cardholder-name" placeholder="Emri dhe Mbiemri" required style="background-color: rgba(255, 255, 255, 0.5);">
                </div>
                <button type="submit" class="payment-button">Paguaj Tani</button>
            </form>
            <button type="button" onclick="window.history.back();" style="margin-top: 15px;margin-left:235px ; background: #ccc; color: #333; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Kthehu Mbrapa</button>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const paymentForm = document.getElementById('payment-form');
            const cardInput = document.getElementById('card-number');
            const cvvInput = document.getElementById('cvv');

            cardInput.addEventListener('paste', e => e.preventDefault());
            cvvInput.addEventListener('paste', e => e.preventDefault());

            cardInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '').substring(0, 16);
                let formatted = value.replace(/(.{4})/g, '$1 ').trim();
                e.target.value = formatted;
            });

            const closeFav = document.getElementById('close-favorites');
            if (closeFav) {
                closeFav.addEventListener('click', () => {
                    document.getElementById('favorites-modal').style.display = 'none';
                    document.getElementById('overlay').style.display = 'none';
                });
            }

            paymentForm.addEventListener('submit', (e) => {
                e.preventDefault();

                const cardNumber = cardInput.value.trim();
                const expiryDate = document.getElementById('expiry-date').value.trim();
                const cvv = cvvInput.value.trim();
                const cardholderName = document.getElementById('cardholder-name').value.trim();

                const cardNumberRegex = /^\d{4} \d{4} \d{4} \d{4}$/;
                const expiryDateRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
                const cvvRegex = /^\d{3,4}$/;

                if (!cardNumberRegex.test(cardNumber)) {
                    alert("Ju lutem vendosni një numër të vlefshëm karte (format: 1234 5678 9012 3456).");
                    return;
                }

                if (!expiryDateRegex.test(expiryDate)) {
                    alert("Ju lutem vendosni një datë të vlefshme të skadimit (format: MM/YY).");
                    return;
                }

                if (!cvvRegex.test(cvv)) {
                    alert("Ju lutem vendosni një CVV të vlefshëm (3 ose 4 shifra).");
                    return;
                }

                if (cardholderName.length < 3) {
                    alert("Ju lutem vendosni një emër të vlefshëm të mbajtësit të kartës.");
                    return;
                }

                const carId = document.getElementById('car-id').value;

                fetch('purchase_car.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            car_id: carId
                        })
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.querySelector('.payment-container').innerHTML = `
        <h2 style="text-align:center; color: #2ecc71;">✅ Pagesa u krye me sukses!</h2>
        <p style="text-align:center;">${data}</p>
        <div style="text-align:center; margin-top: 30px;">
            <button onclick="window.location.href='cars.php'" style="padding: 10px 20px; background-color: #8de020; border: none; color: white; border-radius: 5px; cursor: pointer;">Shfleto Makinat e Tjera</button>
        </div>
    `;
                    })
                    .catch(error => {
                        alert("Ndodhi një gabim gjatë përpunimit të pagesës: " + error);
                    });

            });
        });
    </script>
    <input type="hidden" name="car_id" id="car-id" value="<?php echo isset($_GET['car_id']) ? htmlspecialchars($_GET['car_id']) : ''; ?>">

</body>

</html>