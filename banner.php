<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = $isLoggedIn && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="project.css">
    <link rel="stylesheet" href="smalldevice.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>AUTOSPHERE</title>
    <style>
        #menu-icon {
            display: none;
        }

        @media (max-width: 768px) {
            #menu-icon {
                display: block;
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1001;
                cursor: pointer;
            }

            .navbar ul {
                flex-direction: column;
                align-items: center;
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
                <li><a href="project.php"><img src="logo.png" class="logo"></a></li>
                <li class="name">AUTOSPHERE</li>
                <li><a href="project.php" class="line">Home</a></li>
                <li><a href="cars.php" class="line">Our Cars</a></li>
                <li><a href="about-us.php" class="line">About Us</a></li>
                <li><a href="howitworks.php" class="line">How it works</a></li>
                <li><a href="reviews.php" class="line">Reviews</a></li>
                <?php if ($isAdmin): ?>
                    <li><a href="admin-panel.php" class="line">Admin Panel</a></li>
                <?php endif; ?>
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
                                        <a>Don't have an account?</a> <a href="register.php" class="sign" style="color: #8de020;text-decoration: none; font-weight: 500;"> <br> Sign up</a>
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
                <li class="name">AUTOSPHERE</li>
                <li><a href="project.php" class="line">Home</a></li>
                <li><a href="cars.php" class="line">Our Cars</a></li>
                <li><a href="about-us.php" class="line">About Us</a></li>
                <li><a href="howitworks.php" class="line">How it works</a></li>
                <li><a href="reviews.php" class="line">Reviews</a></li>
                <?php if ($isAdmin): ?>
                    <li class="dropdown">
                        <a href="#" class="dropbtn">Admin <i class="fa fa-caret-down"></i></a>
                        <ul class="dropdown-content">
                            <li><a href="admin-panel.php" class="line">Admin Panel</a></li>
                            <li><a href="admin_cars.php" class="line">Edit Cars</a></li>
                            <li><a href="admin_image.php" class="line">Edit Images</a></li>
                            <li><a target="_blank" href="shiko_blerjet.php" class="line">Shiko Blerjet</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

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
                                        <a>Don't have an account?</a> <a href="register.php" class="sign" style="color: #8de020;text-decoration: none; font-weight: 500;"> <br> Sign up</a>
                                    <?php endif; ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </div>

    <script>
        document.getElementById('menu-icon').addEventListener('click', function() {
            const overlay = document.getElementById('overlay1');
            if (overlay.style.display === 'block') {
                overlay.style.display = 'none';
            } else {
                overlay.style.display = 'block';
            }
        });
    </script>
</body>

</html>