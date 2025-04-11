<!DOCTYPE html>

<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" , initial-scale="1.0">
    <link rel="stylesheet" href="project.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<style>
    body{
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    font-family: Arial, Helvetica, sans-serif;
    color: #333;
}


    #section-1{
    background-color:white;
    color: black;
    text-align: center;
    height: 50px;   
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.navbar {
    width: 100%;
    height: 45px;
    background-color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 30px; 
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    z-index: 1000;
}

.navbar ul {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    align-items: center;
}

.navbar li {
    position: relative;
    margin: 0 15px;
}

.navbar a {
    color: #333;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: color 0.3s ease-in-out;
}
.line{
    margin: 10px;
}

.navbar a:hover {
    color: #1F2B59;
}
.navbar .line::after {
    content: '';
    position: absolute;
    bottom: -5px; 
    left: 0;
    width: 0;
    height: 2px; 
    background-color: #1F2B59;
    transition: width 0.3s ease-in-out;
}

.navbar a:hover::after {
    width: 100%;
}

.logo {
    height: 60px; 
    transition: transform 0.3s ease-in-out;
}

.logo:hover {
    transform: scale(1.1); 
}
.name {
    font-family: 'Orbitron', sans-serif;
    font-size: 20px;
    font-weight: 700;
    letter-spacing: 2px;
    color: rgb(141, 224, 32);
}

.navbar .dropdown .dropbtn {
    font-size: 14px; 
    font-weight: 500;
    color: #333; 
    padding: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: color 0.3s ease-in-out;
}

.navbar .dropdown .dropbtn:hover {
    color: #1F2B59; 
}


.navbar .dropdown-content {
    display: none;
    position: absolute;
    top: 100%; 
    right: 0; 
    background-color: white;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    min-width: 200px;
    border-radius: 8px;
    z-index: 10;
    opacity: 0; 
    transform: translateY(-10px); 
    transition: all 0.3s ease-in-out;
}

.navbar .dropdown:hover .dropdown-content {
    display: block;
    opacity: 1;
    transform: translateY(0); 
}


.navbar .dropdown-content a {
    display: block;
    padding: 12px 16px;
    color: #333;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: background-color 0.3s, color 0.3s;
}

.navbar .dropdown-content a:hover {
    color: #1F2B59;
    border-radius: 8px;
}
input[type="submit"]:hover, input[type="reset"]:hover {
    background-color: #b3d4fc;
  }
#button {
    margin-top: 20px;
    width: 90%;
    background: rgb(141, 224, 32);
    background: linear-gradient(90deg, rgba(141, 224, 32, 1) 0%, rgba(170, 230, 0, 1) 38%, rgba(190, 240, 0, 1) 100%);
    color: #ffffff;
    padding: 10px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
    border-radius: 8px;
    border: white;
}
.sign-up {
    margin-top: 20px;
    text-align: center;
}
.favorite{
    padding-left: 300px;
}
.login-icon{
    height: 30px;
}
i{
    margin: 12px;
}
.navbar .dropdown-content .login-text a{
    text-align: left;
    padding-left: 10px;
}
.sign:hover{
    transform: scale(1.1); 
}
#button:hover {
    transform: scale(1.05); 
}
.login-text:hover{
    transform: scale(1.1);
}
.favorite{
    font-size: 24px;
    transition: all 0.3s ease;
}
#icon-regular{
    display: inline-block;
}
#icon-solid{
    display: none;
}
.favorite:hover #icon-regular{
    display: none;
}
.favorite:hover #icon-solid{
    display: inline-block;
}
#favorites-modal {
    max-height: 80vh;
    overflow-y: auto;
}
.favorite-btn:hover {
    transform: scale(1.1);
}
.extra-part:hover {
    transform: scale(1.1); 
}
    </style>

<body>
    <div id="section-1">
        <nav class="navbar">
            <ul>
                <li><a href="project.html"><img src="logo.png" class="logo"></a></li>
                <li class="name">AUTOSPHERE</li>
                <li><a href="project.html" class="line">Home</a></li>
                <li><a href="/cars.html" class="line">Our Cars</a></li>
                <li><a href="about-us.html" class="line">About Us</a></li>
                <li><a href="/howitworks.html" class="line">How it works</a></li>
                <li><a href="/reviews.html" class="line">Reviews</a></li>
                <li><a href="#" class="favorite trigger-favorites"><i class="fa-regular fa-heart" id="icon-regular"></i>
                        <i class="fa-solid fa-heart" id="icon-solid"></i></a></li>

                <li class="dropdown">
                    <div>
                        <a href="#" class="dropbtn"><i class="fa-regular fa-user"></i>Login</a>
                        <ul class="dropdown-content">
                            <li class="login-text trigger-favorites"><a href="#"><i class="fa-regular fa-heart"></i>Favorite cars</a></li>
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
        </nav>
    </div>
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
    <script src="banner.js"></script>
</body>
</html>