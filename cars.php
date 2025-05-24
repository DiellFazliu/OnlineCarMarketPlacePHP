<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cars.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div id="Banner"></div>
    <script>
        fetch('banner.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('Banner').innerHTML = data;
            });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const script = document.createElement('script');
            script.src = 'banner.js';
            document.body.appendChild(script);
        });
    </script>
    <button class="filter-btn">Show Filters</button>
    <div id="container-custom">
        <div class="filters-custom" style="flex: 1 1 35%;">
            <button class="close-btn-test" style="width: 30px; height: 40px;border-radius: 10px;">&times;</button>
            <div class="still">
                <h3>Filter Options</h3>
                <div class="horizontale-custom">
                    <div>
                        <button class="btnMenu-custom" id="brandButton-custom">Brand
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#9660;</button>
                        <ul style="list-style: none; padding: 0; margin: 0; display: none; max-height: 100px; overflow-y: scroll; border: 1px solid #ddd;"
                            class="Menu-custom" id="brandMenu-custom">
                            <li><a href="#" data-brand="Mercedes">Mercedes Benz</a></li>
                            <li><a href="#" data-brand="Audi">Audi</a></li>
                            <li><a href="#" data-brand="BMW">BMW</a></li>
                            <li><a href="#" data-brand="Porsche">Porsche</a></li>
                            <li><a href="#" data-brand="Rolls Royce">Rolls Royce</a></li>
                        </ul>
                    </div>
                    <div>
                        <button class="btnMenu-custom"
                            id="modelButton-custom">Model&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#9660;</button>
                        <ul style="list-style: none; padding: 0; margin: 0; display: none; max-height: 150px; overflow-y: scroll; border: 1px solid #ddd;"
                            class="Menu-custom" id="modelMenu-custom">
                        </ul>
                    </div>
                </div>
                <input id="extrapart-custom" class="extra-part-custom" type="submit" value="23049 total results"
                    style="height: 32px; width: 170px; border:#8de020">

                <script>
                    $(document).ready(function() {
                        let selectedBrand = "";
                        let selectedModel = "";

                        $(".filter-btn").click(function() {
                            $(".filters-custom").toggleClass("active");
                        });

                        $(".close-btn-test").click(function() {
                            $(".filters-custom").removeClass("active");
                        });

                        const models = {
                            Mercedes: ["C Class", "E Class", "S Class", "G Class"],
                            Audi: ["A3", "A6", "A7", "A8"],
                            BMW: ["Series 3", "Series 4", "Series 7", "Series 8"],
                            Porsche: ["Taycan", "991", "992"],
                            "Rolls Royce": ["Phantom", "Dawn", "Wraith", "Ghost"]
                        };

                        const combinations = {
                            "mercedes": "Mercedes.php",
                            "mercedes-c-class": "mercedesC.php",
                            "mercedes-e-class": "mercedesE.php",
                            "mercedes-s-class": "mercedesS.php",
                            "mercedes-g-class": "mercedesG.php",
                            "bmw": "BMW.php",
                            "bmw-series-3": "bmwm3.php",
                            "bmw-series-4": "bmwm4.php",
                            "bmw-series-7": "bmw7.php",
                            "bmw-series-8": "bmw8.php",
                            "audi": "Audi.php",
                            "audi-a3": "audia3.php",
                            "audi-a6": "audia6.php",
                            "audi-a7": "audia7.php",
                            "audi-a8": "audia8.php",
                            "porsche": "Porsche.php",
                            "porsche-911": "porsche911.php",
                            "porsche-taycan": "porschetaycan.php",
                            "rollsroyce": "RollsRoyce.php",
                            "rollsroyce-dawn": "rollsroycedawn.php",
                            "rollsroyce-ghost": "rollsroyceghost.php",
                            "rollsroyce-phantom": "rollsroycephantom.php",
                            "rollsroyce-wraith": "rollsroycewraith.php"
                        };

                        $("#brandMenu-custom a").click(function(e) {
                            e.preventDefault();
                            selectedBrand = $(this).data("brand");
                            $("#brandButton-custom").text(selectedBrand);
                            $("#brandMenu-custom").slideUp(500);

                            const modelList = models[selectedBrand] || [];
                            const modelItems = modelList.map(model => `<li><a href="#">${model}</a></li>`).join("");
                            $("#modelMenu-custom").html(modelItems);
                            $("#modelButton-custom").text("Model");

                            $("#extrapart-custom").val("Search " + selectedBrand);
                        });

                        $("#modelMenu-custom").on("click", "a", function(e) {
                            e.preventDefault();
                            selectedModel = $(this).text();
                            $("#modelButton-custom").text(selectedModel);
                            $("#modelMenu-custom").slideUp(500);


                            $("#extrapart-custom").val("Search " + selectedBrand + " " + selectedModel);
                        });


                        $("#extrapart-custom").click(function() {
                            if (selectedBrand) {

                                let key = selectedBrand.toLowerCase().replace(/\s+/g, '-');


                                if (selectedModel) {
                                    key += '-' + selectedModel.toLowerCase().replace(/\s+/g, '-');
                                }


                                if (combinations[key]) {
                                    window.location.href = combinations[key];
                                } else {
                                    alert("No page found for this combination. Please select a valid brand and model.");
                                }
                            } else {
                                alert("Please select a brand.");
                            }
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
                    <a href="#">Më shumë rreth garancive &rarr;</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="listings-custom" id="listings" style="flex: 1 1 60%;">
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                fetch('getCars.php')
                    .then(response => response.json())
                    .then(cars => {
                        const listings = document.getElementById('listings');
                        if (!Array.isArray(cars)) {
                            listings.innerHTML = "<p>Error loading cars.</p>";
                            return;
                        }

                        listings.innerHTML = cars.map(car => `
                <a href="preview.php?car_id=${car.car_id}" class="card-link">
                    <div class="card-custom">
                        <img src="${car.main_image || 'login.png'}" alt="${car.make} ${car.model}">
                        <div class="details-custom">
                            <h4>${car.make} ${car.model} ${car.variant || ''}</h4>
                            <p>${car.mileage_km.toLocaleString()} km | ${car.month_registered.toString().padStart(2, '0')}/${car.year} | ${car.horsepower} hp | ${car.transmission} | ${car.fuel_type}</p>
                            <div class="tags-custom">
                                ${car.fuel_bonus ? '<span>Fuel Bonus</span>' : ''}
                                ${car.warranty_included ? '<span>Warranty Included</span>' : ''}
                                <span>+ more</span>
                            </div>
                            <p class="location-custom">${car.location} | Transport: ${(Number(car.delivery_fee) || 0).toFixed(0)}€</p>
                            <p class="monthly-payment-custom">Monthly payment: ${(Number(car.monthly_financing)).toFixed(0)}€</p>
                            <p class="price-custom">${(parseFloat(car.base_price) + parseFloat(car.customs_fee) + parseFloat(car.registration_fee) + parseFloat(car.service_fee) + parseFloat(car.delivery_fee)).toLocaleString()}€</p>
                        </div>
                    </div>
                </a>
            `).join('');
                    })
                    .catch(err => {
                        console.error(err);
                        document.getElementById('listings').innerHTML = "<p>Failed to load listings.</p>";
                    });
            });
        </script>
    </div>
    </div>

</body>

</html>