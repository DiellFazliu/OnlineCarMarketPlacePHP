<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Slideshow</title>
    <style>
        /* Stilet ekzistuese */
        body {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            justify-content: center;
            align-items: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .slideshow-container {
            position: relative;
            max-width: 80%;
            max-height: 80vh;
            margin: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .img {
            display: none;
            width: 100%;
            height: auto;
            max-height: 80vh;
            border-radius: 30px;
            object-fit: cover;
        }

        .img.active {
            display: block;
        }

        .controls {
            margin-top: 20px;
        }

        .btn {
            background-color: #444;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #888;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            font-size: 18px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .close-btn:hover {
            background-color: darkred;
        }

        .counter {
            margin-top: 10px;
            font-size: 18px;
        }

        @media (max-width: 768px) {
            .img {
                max-height: 60vh;
            }

            .btn {
                font-size: 14px;
                padding: 8px 16px;
            }

            .close-btn {
                font-size: 16px;
                padding: 5px 8px;
            }
        }

        @media (max-width: 480px) {
            .img {
                max-height: 50vh;
            }

            .btn {
                font-size: 12px;
                padding: 6px 12px;
            }

            .close-btn {
                font-size: 14px;
                padding: 4px 6px;
            }
        }
    </style>
</head>

<body>
    <div class="slideshow-container">
        <button class="close-btn" onclick="goBack()">X</button>
        <img class="img active" src="../Audi/A6/rs6/a.jfif" alt="Slide 1">
        <img class="img" src="../Audi/A6/rs6/a1.jfif" alt="Slide 2">
        <img class="img" src="../Audi/A6/rs6/a2.jfif" alt="Slide 3">
        <img class="img" src="../Audi/A6/rs6/a3.jfif" alt="Slide 4">
        <img class="img" src="../Audi/A6/rs6/a4.jfif" alt="Slide 5">
        <img class="img" src="../Audi/A6/rs6/a5.jfif" alt="Slide 6">
        <img class="img" src="../Audi/A6/rs6/a6.jfif" alt="Slide 7">
        <img class="img" src="../Audi/A6/rs6/a7.jfif" alt="Slide 8">
        <img class="img" src="../Audi/A6/rs6/a8.jfif" alt="Slide 9">
        <img class="img" src="../Audi/A6/rs6/a9.jfif" alt="Slide 10">
        <img class="img" src="../Audi/A6/rs6/a10.jfif" alt="Slide 11">
        <img class="img" src="../Audi/A6/rs6/a11.jfif" alt="Slide 12">
        <img class="img" src="../Audi/A6/rs6/a12.jfif" alt="Slide 13">
        <img class="img" src="../Audi/A6/rs6/a13.jfif" alt="Slide 14">
        <img class="img" src="../Audi/A6/rs6/a14.jfif" alt="Slide 15">

        <div class="counter" id="counter">1 / 7</div>

        <div class="controls">
            <button class="btn" onclick="prevSlide()">Previous</button>
            <button class="btn" onclick="nextSlide()">Next</button>
        </div>
    </div>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.img');
        const counter = document.getElementById('counter');

        // Funksioni për të shfaqur një slajd të caktuar dhe për të ndryshuar URL-n
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });

            // Përditëso URL-n me parametrin e ri të slide-it
            const newUrl = `${window.location.pathname}?slide=${index + 1}`;
            history.replaceState(null, '', newUrl);

            // Përditëso numëruesin
            counter.textContent = `${index + 1} / ${slides.length}`;
        }

        // Funksioni për të kaluar te slajdi i radhës
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        // Funksioni për të kaluar te slajdi i mëparshëm
        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        // Funksioni për t'u kthyer mbrapa
        function goBack() {
            alert('Going back to the previous page!');
            window.history.back();
        }

        // Merr parametrin "slide" nga URL-ja dhe shfaq slajdin e duhur
        const urlParams = new URLSearchParams(window.location.search);
        const slideNumber = parseInt(urlParams.get('slide'), 10);

        if (slideNumber && slideNumber > 0 && slideNumber <= slides.length) {
            currentSlide = slideNumber - 1; // Përshtat për indeksin zero-bazë
        }

        // Shfaq slajdin fillestar
        showSlide(currentSlide);
    </script>
</body>

</html>
