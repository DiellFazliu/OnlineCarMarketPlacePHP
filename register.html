<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoSphere| Register Form</title>
    <link rel="stylesheet" href="all.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .input-error {
            border: 1px solid red;
        }

        .active {
            opacity: 0.7;
        }
    </style>
</head>

<body>
    <div class="logo-wrapper">
        <a href="project.html"><img src="logo.png" class="logo"></a>
        <div class="name">AUTOSPHERE</div>
    </div>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form onsubmit="validate(event)">
        <h3 class="register-title" style="text-align: center;">Sign Up</h3>
        <div class="sing-up-subtitle">Just some details to get you in.!</div>

        <label for="username"></label>
        <input type="text" placeholder="Username" id="username">
        <div id="usernameError" class="error-message">Username must contain a dot.</div>

        <label for="email"></label>
        <input type="email" placeholder="Email" id="email">
        <div id="emailError" class="error-message">Invalid email format.</div>

        <label for="password"></label>
        <input type="password" placeholder="Password" id="password">
        <div id="passwordError" class="error-message">Password must be between 8-16 characters long.</div>

        <label for="confirmPassword"></label>
        <input type="password" placeholder="Confirm Password" id="confirmPassword">
        <div id="confirmPasswordError" class="error-message">Passwords do not match.</div>

        <button id="button" type="submit">Sign Up</button>

        <div class="or">
            <span>Or</span>
        </div>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i></div>
            <div class="fb"><i class="fab fa-facebook"></i></div>
            <div class="gh"><i class="fab fa-github"></i></div>
        </div>
    
        </div>
        <div class="sign-up">
            Already Registered <a href="/login.html"> <br> Login</a>
        </div>
    </form>
    <div class="text-section">
        <h1>Welcome to our Page!</h1>
        <p>Sign up through a platform to enjoy all our services</p>
        <div class="register-icons">
            <img class="icons" src="apple.png" />
            <img class="icons" src="android.png" />
            <img class="icons" src="google.png" />
        </div>
    </div>

    <div id="platform-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h3 style="text-align: center;">Login to Platform</h3>
            <label for="platform-username">Username</label>
            <input type="text" id="platform-username" placeholder="Username">
            <div id="platform-username-error" class="error-message">Username must contain a dot.</div>
            <label for="platform-password">Password</label>
            <input type="password" id="platform-password" placeholder="Password">
            <div id="platform-password-error" class="error-message">Password must be between 8-16 characters long.</div>
            <input id="modal-signup-button" type="submit" value="Sign Up">
        </div>
    </div>

    <script>
        const modal = document.getElementById("platform-modal");
        const closeModal = document.querySelector(".close-modal");

        document.querySelectorAll(".register-icons img, .social div").forEach(icon => {
            icon.addEventListener("click", event => {
                modal.style.display = "block"; 
                document.body.classList.add("modal-active");

                const modalTitle = modal.querySelector("h3");
                const clickedIcon = event.target;

                if (clickedIcon.classList.contains("fa-google")) {
                    modalTitle.textContent = "Login with Google";
                } else if (clickedIcon.classList.contains("fa-facebook")) {
                    modalTitle.textContent = "Login with Facebook";
                } else if (clickedIcon.classList.contains("fa-github")) {
                    modalTitle.textContent = "Login with GitHub";
                } else {
                    modalTitle.textContent = "Sign Up through Platform";
                }
            });
        });


        closeModal.addEventListener("click", () => {
            modal.style.display = "none";
            document.body.classList.remove("modal-active");
        });

        window.addEventListener("click", event => {
            if (event.target === modal) {
                modal.style.display = "none";
                document.body.classList.remove("modal-active");
            }
        });


        document.querySelectorAll(".register-icons img, .social div").forEach(icon => {
            icon.addEventListener("click", () => {
                document.querySelectorAll(".register-icons img, .social div").forEach(i => i.classList.remove("active"));
                icon.classList.add("active");
            });
        });


        function validate(event) {
            event.preventDefault(); 

      
            var username = document.getElementById("username").value.trim();
            var email = document.getElementById("email").value.trim();
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;

            resetErrors();

            var invalid = false;

            if (username.length === 0) {
                showError("username", "Username cannot be empty.");
                invalid = true;
            } else if (username.indexOf(".") === -1) {
                showError("username", "Username must contain a dot.");
                invalid = true;
            }

            if (email.length === 0) {
                showError("email", "Email cannot be empty.");
                invalid = true;
            } else if (!email.includes("@") || email.split("@")[1].split(".").length <= 1) {
                showError("email", "Email format is incorrect.");
                invalid = true;
            }

            if (password.length < 8) {
                showError("password", "Password must be at least 8 characters long.");
                invalid = true;
            } else if (password.length > 16) {
                showError("password", "Password must be less than 16 characters long.");
                invalid = true;
            }

            if (password !== confirmPassword) {
                showError("confirmPassword", "Passwords do not match.");
                invalid = true;
            }

            if (invalid) {
                return false;
            } else {
                window.location.href = "project.html";
            }
        }

        function showError(inputId, errorMessage) {
            const inputElement = document.getElementById(inputId);
            const errorElement = document.getElementById(inputId + "Error");

            inputElement.classList.add("input-error");
            errorElement.textContent = errorMessage;
            errorElement.style.display = "block";
        }

        function resetErrors() {
            const inputs = document.querySelectorAll("input");
            inputs.forEach(input => {
                input.classList.remove("input-error");
                const errorElement = document.getElementById(input.id + "Error");
                if (errorElement) {
                    errorElement.style.display = "none";
                }
            });
        }


document.getElementById("modal-signup-button").addEventListener("click", event => {
    event.preventDefault(); 


    const modalUsername = document.getElementById("platform-username").value.trim();
    const modalPassword = document.getElementById("platform-password").value;

    resetModalErrors();

    let modalInvalid = false;

    if (modalUsername.length === 0) {
        showModalError("platform-username", "Username cannot be empty.");
        modalInvalid = true;
    } else if (modalUsername.indexOf(".") === -1) {
        showModalError("platform-username", "Username must contain a dot.");
        modalInvalid = true;
    }

    if (modalPassword.length < 8) {
        showModalError("platform-password", "Password must be at least 8 characters long.");
        modalInvalid = true;
    } else if (modalPassword.length > 16) {
        showModalError("platform-password", "Password must be less than 16 characters long.");
        modalInvalid = true;
    }


    if (!modalInvalid) {
        window.location.href = "project.html"; 
        modal.style.display = "none"; 
        document.body.classList.remove("modal-active");
    }
});


        function showModalError(inputId, errorMessage) {
            const inputElement = document.getElementById(inputId);
            const errorElement = document.getElementById(inputId + "-error");

            inputElement.classList.add("input-error");
            errorElement.textContent = errorMessage;
            errorElement.style.display = "block";
        }

        function resetModalErrors() {
            const modalInputs = document.querySelectorAll(".modal-content input");
            modalInputs.forEach(input => {
                input.classList.remove("input-error");
                const errorElement = document.getElementById(input.id + "-error");
                if (errorElement) {
                    errorElement.style.display = "none";
                }
            });
        }
    </script>
</body>

</html>
