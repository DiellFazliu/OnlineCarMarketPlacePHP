<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="smalldevice.css">
    <link rel="stylesheet" href="project.css">
    <title>Si Funksionon AUTOSPHERE</title>
    <style>
        
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            color: #824343;
            line-height: 1.6;
            background-color: #8de020;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        h1, h2, h3 {
            margin: 0 0 15px;
        }
        #hero {
    background-color: #3e3f4ae0;
    color: rgb(241, 244, 237); 
    text-align: center;
    padding: 100px 20px;
    
}
        
        .hero {
            background: url('makina foto 4/images.jpg') no-repeat center center/cover;
            color: rgb(141, 224, 32);
            text-align: center;
            padding: 100px 20px;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            
        }

        .hero .btn-primary {
            background: rgb(141, 224, 32);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 1rem;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .hero .btn-primary:hover {
            background: #8de020;
        }
        #car-tips{
background-image: url(howitworksphoto.webp);
background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
        }
       
        .how-it-works {
            background:#8de020;
            padding: 50px 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .steps {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            flex-wrap: wrap;
        }

        .step {
            flex: 1;
            min-width: 250px;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .same:hover{
            transform: translate(-5px);
        }
        .same1:hover{
            transform: translate(-5px);
        }

        .step:hover {
            transform: translateY(-5px);
        }

        .icon-wrapper {
            background: rgb(141, 224, 32);
            width: 70px;
            height: 70px;
            margin: 0 auto 15px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-wrapper img {
            width: 100%; 
    height: 100%; 
    border-radius: 50%; 
    object-fit: cover; 
    display: block; 
}
@media (max-width: 480px) {
  #Banner{
    display: none;
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
    <header id="hero" class="hero">
        <div class="container">
            <h1>Makina e Ëndrrave, e Sigurt dhe e Lehtë për Ty</h1>
            <p>Zgjidh nga mijëra makina të kontrolluara me kujdes, të dorëzuara te dera jote.</p>
            <a href="#how-it-works" class="btn-primary">Mëso Më Shumë</a>
        </div>
    </header>


    <section id="how-it-works" class="how-it-works">
        <div class="container">
            <h2 style="color: white;">Si Funksionon AUTOSPHERE?</h2>
            <p class="intro" style="color: white;">Procesi ynë është i thjeshtë dhe i sigurt, në çdo hap të rrugës.</p>
            
            <div class="steps">
                <div class="step" data-step="1">
                    <div class="icon-wrapper">
                        <img src="makina foto.jpg" alt="Zgjidh makinën" width = "150" height = "150">
                    </div>
                    <h3>Zgjidh makinën</h3>
                    <p>Shfleto dhe zgjidh makinën që përputhet me dëshirat dhe nevojat tuaja.</p>
                </div>
                <div class="step" data-step="2">
                    <div class="icon-wrapper">
                        <img src="makina foto 2.jpg" alt="Kontroll teknik">
                    </div>
                    <h3>Kontroll i detajuar</h3>
                    <p>Ne bëjmë një kontroll teknik të detajuar për siguri dhe cilësi.</p>
                </div>
                <div class="step" data-step="3">
                    <div class="icon-wrapper">
                        <img src="Makina foto 3.jpg" alt="Dorëzim në derë">
                    </div>
                    <h3>Dorëzim i shpejtë</h3>
                    <p>Dorëzojmë makinën tënde, direkt në shtëpinë tënde.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="car-security" style="background: white; padding: 60px 20px;">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 40px; font-size: 2.8rem; color: #222; font-weight: 600;">Siguria dhe Garancitë</h2>
    
            <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: space-between;text-align: center;">
                
                <div class="same" style="flex: 1; min-width: 280px; background: white;border: solid 2px rgb(141, 224, 32); border-radius: 15px; padding: 30px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <h3 style="color: #34495e; font-size: 1.8rem; margin-bottom: 20px;">Blerja e Sigurt</h3>
                    <ul style="list-style: disc; margin-left: 20px; color: #555; font-size: 1rem;">
                        <li>Kontroll teknik i plotë për çdo makinë përpara shitjes.</li>
                        <li>Transparentësi e plotë për historikun dhe kilometrazhin.</li>
                        <li>Marrëveshje të sigurta me dokumentacion të rregullt.</li>
                        <li>Politika e kthimit brenda 7 ditësh në rast të ndonjë defekti të pazbuluar.</li>
                        <li>Pagese e sigurt përmes platformave të besuara.</li>
                    </ul>
                </div>
    
                
                <div class="same" style="flex: 1; min-width: 280px; background: white;border: solid 2px rgb(141, 224, 32); border-radius: 15px; padding: 30px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <h3 style="color: #34495e; font-size: 1.8rem; margin-bottom: 20px;">Garancioni i Sigurt deri në 3 Vjet</h3>
                    <ul style="list-style: disc; margin-left: 20px; color: #555; font-size: 1rem;">
                        <li>Garancioni për motorin dhe transmetimin.</li>
                        <li>Mbështetje për riparime të papritura gjatë periudhës së garancisë.</li>
                        <li>Mundësi për zgjatje të garancisë pas 3 vitesh.</li>
                        <li>Garancioni për pjesët e reja të zëvendësuara.</li>
                        <li>Asistencë rrugore falas gjatë periudhës së garancisë.</li>
                    </ul>
                </div>
    
                
                <div class="same" style="flex: 1; min-width: 280px; background: white;border: solid 2px rgb(141, 224, 32);; border-radius: 15px; padding: 30px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <h3 style="color: #34495e; font-size: 1.8rem; margin-bottom: 20px;">Garantimi i Gjendjeve Teknike</h3>
                    <ul style="list-style: disc; margin-left: 20px; color: #555; font-size: 1rem;">
                        <li>Çdo makinë i nënshtrohet inspektimit teknik prej ekspertëve.</li>
                        <li>Certifikatë që vërteton gjendjen mekanike dhe elektrike.</li>
                        <li>Raport i detajuar për gjendjen e frenave, gomave dhe pezullimit.</li>
                        <li>Testim i avancuar për motorin dhe ndotjen e ajrit.</li>
                        <li>Shërbime të personalizuara për nevojat e klientëve.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <section id="car-tips" style="padding: 60px 20px;">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 40px; font-size: 2.8rem; color: white; font-weight: 600;">Informacione të Rëndësishme për Makina</h2>
    
            <div style="display: flex; flex-wrap: wrap; gap: 50px; justify-content: space-between;text-align: center;">
                
                <div class="same1" style="flex: 1; min-width: 280px; background: white; border-radius: 15px; padding: 30px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <h3 style="color: #34495e; font-size: 1.8rem; margin-bottom: 20px;">Si të Zgjidhni Makinën e Duhur</h3>
                    <ul style="list-style: disc; margin-left: 20px; color: #555; font-size: 1rem;">
                        <li>Konsideroni buxhetin tuaj për blerje dhe mirëmbajtje.</li>
                        <li>Zgjidhni një makinë me konsum të ulët karburanti.</li>
                        <li>Kontrolloni historikun e shërbimit dhe kilometrazhin.</li>
                        <li>Merrni në konsideratë madhësinë dhe kapacitetin.</li>
                        <li>Sigurohuni që makina është e përshtatshme për terrenin ku do të përdoret.</li>
                    </ul>
                </div>
    
               
                <div class="same1" style="flex: 1; min-width: 280px; background: white; border-radius: 15px; padding: 30px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <h3 style="color: #34495e; font-size: 1.8rem; margin-bottom: 20px;">Këshilla për Mirëmbajtjen e Makinës</h3>
                    <ul style="list-style: disc; margin-left: 20px; color: #555; font-size: 1rem;">
                        <li>Ndërroni vajin dhe filtrat rregullisht.</li>
                        <li>Kontrolloni presionin e gomave çdo muaj.</li>
                        <li>Sigurohuni që frena dhe bateritë janë në gjendje optimale.</li>
                        <li>Lani dhe dylloni makinën për ta mbrojtur nga korrozioni.</li>
                        <li>Merrni një inspektim të plotë të makinës çdo vit.</li>
                    </ul>
                </div>
    
                
                <div class="same1" style="flex: 1; min-width: 280px; background: white; border-radius: 15px; padding: 30px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <h3 style="color: #34495e; font-size: 1.8rem; margin-bottom: 20px;">Si të Kurseni Karburant</h3>
                    <ul style="list-style: disc; margin-left: 20px; color: #555; font-size: 1rem;">
                        <li>Shmangni nxitjen dhe frenimin e papritur.</li>
                        <li>Mbani shpejtësinë konstante gjatë udhëtimit.</li>
                        <li>Fikni motorin, kur makina është në pritje për më shumë se 30 sekonda.</li>
                        <li>Mbani filtrat e ajrit të pastër dhe të azhurnuar.</li>
                        <li>Planifikoni rrugën për të shmangur trafikun dhe ndalesat e panevojshme.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <script>
       
        document.addEventListener('DOMContentLoaded', () => {
            const steps = document.querySelectorAll('.step');

            steps.forEach(step => {
                step.addEventListener('click', () => {
                    const stepNumber = step.getAttribute('data-step');
                    alert(`Ju klikoni hapin ${stepNumber}.`);
                });
            });

            const backToTop = document.getElementById('back-to-top');
            backToTop.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            const navLinks = document.querySelectorAll('.header nav ul li a');
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', () => {
                    link.style.color = "rgb(151, 247, 27)";
                });
                link.addEventListener('mouseleave', () => {
                    link.style.color = "white";
                });
            });
        });
    </script>
</head>
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