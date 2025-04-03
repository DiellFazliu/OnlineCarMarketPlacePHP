$(document).ready(function () {
    const cars = [
        { id: 1, brand: "Mercedes", model: "E Class", price: "$69,900", image: "Mercedes-Benz/E-class/normal/e7.jfif" },
        { id: 2, brand: "Audi", model: "A3 Cabriolet", price: "$37,000", image: "Audi/A3/kabriolet/a1.jfif" },
        { id: 3, brand: "Mercedes", model: "S Class", price: "$130,000", image: "Mercedes-Benz/S-class/normal/s.jfif" },
        { id: 4, brand: "Mercedes", model: "C Class", price: "$37,200", image: "Mercedes-Benz/C-class/coupe/c2.jfif" },
        { id: 5, brand: "Audi", model: "S8", price: "$65,000", image: "Audi/A8/s8/a1.jfif" },
        { id: 6, brand: "Audi", model: "A6", price: "$41,500", image: "Audi/A6/normal/a.jfif" }
    ];

    const carsContainer = $("#cars-container");
    cars.forEach(car => {
        const carCard = `
            <div class="car-card">
                <img src="${car.image}" alt="${car.brand} ${car.model}" style="width: 100%; height: auto; border-radius: 5px;">
                <h3>${car.brand} ${car.model}</h3>
                <p>Price: ${car.price}</p>
                <button class="favorite-btn" data-id="${car.id}" style="background: #8de020; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">Favorite</button>
            </div>
        `;
        carsContainer.append(carCard);
    });

    $(".favorite-btn").click(function () {
        const carId = $(this).data("id");
        let favorites = JSON.parse(localStorage.getItem("favorites")) || [];

        if (!favorites.includes(carId)) {
            favorites.push(carId);
            localStorage.setItem("favorites", JSON.stringify(favorites));

            $(this).text("Added")
                .prop("disabled", true)
                .css("background-color", "#ccc");
        }
    });

    function renderFavorites() {
        const favorites = JSON.parse(localStorage.getItem("favorites")) || [];
        const favoritesContainer = $("#favorites-container");
        favoritesContainer.empty();

        if (favorites.length === 0) {
            favoritesContainer.html("<p>No cars in your favorites.</p>");
        } else {
            favorites.forEach(carId => {
                const car = cars.find(c => c.id === carId);
                if (car) {
                    const carCard = `
                        <div class="car-card">
                            <img src="${car.image}" alt="${car.brand} ${car.model}" style="width: 100%; height: auto; border-radius: 5px;">
                            <h3>${car.brand} ${car.model}</h3>
                            <p>Price: ${car.price}</p>
                            <button class="remove-from-favorites-btn" data-id="${car.id}" style="background: red; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">Remove</button>
                        </div>
                    `;
                    favoritesContainer.append(carCard);
                }
            });
        }
    }

    $(".trigger-favorites").click(function (e) {
        e.preventDefault();
        renderFavorites();
        $("#favorites-modal").show();
        $("#overlay").show();
    });

    $("#close-favorites, #overlay").click(function () {
        $("#favorites-modal").hide();
        $("#overlay").hide();
    });

    $("#favorites-container").on("click", ".remove-from-favorites-btn", function () {
        const carId = $(this).data("id");
        let favorites = JSON.parse(localStorage.getItem("favorites")) || [];
        favorites = favorites.filter(id => id !== carId);
        localStorage.setItem("favorites", JSON.stringify(favorites));

        $(".favorite-btn[data-id='" + carId + "']").text("Favorite").prop("disabled", false).css("background-color", "#8de020");

        renderFavorites();
    });
});
