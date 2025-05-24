<?php
session_start();
require_once 'db.php'; // Use the central DB connection

$config = include 'config.php';

define("MIN_PASSWORD_LENGTH", $config['security']['min_password_length']);
define("MAX_PASSWORD_LENGTH", $config['security']['max_password_length']);

$username_pattern = '/^[a-zA-Z0-9]+$/';
$email_pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
$password_pattern = '/^[a-zA-Z0-9!@#$%^&*()_+]{'.MIN_PASSWORD_LENGTH.','.MAX_PASSWORD_LENGTH.'}$/';

class UserRegistration {
    private $username;
    private $email;
    private $password;
    private $confirmPassword;
    private $db;

    public function __construct($db, $username, $email, $password, $confirmPassword) {
        $this->db = $db;
        $this->username = trim($username);
        $this->email = trim($email);
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }

    public function validateInput() {
        global $username_pattern, $email_pattern, $password_pattern;

        $errors = [];

        if (empty($this->username)) {
            $errors['username'] = "Username cannot be empty";
        } elseif (!preg_match($username_pattern, $this->username)) {
            $errors['username'] = "Username can only contain letters and numbers";
        } elseif (strlen($this->username) < 3) {
            $errors['username'] = "Username must be at least 3 characters";
        }

        if (empty($this->email)) {
            $errors['email'] = "Email cannot be empty";
        } elseif (!preg_match($email_pattern, $this->email)) {
            $errors['email'] = "Invalid email format";
        }

        if (empty($this->password)) {
            $errors['password'] = "Password cannot be empty";
        } elseif (!preg_match($password_pattern, $this->password)) {
            $errors['password'] = "Password must be ".MIN_PASSWORD_LENGTH."-".MAX_PASSWORD_LENGTH." characters long";
        }

        if (empty($this->confirmPassword)) {
            $errors['confirmPassword'] = "Please confirm your password";
        } elseif ($this->password !== $this->confirmPassword) {
            $errors['confirmPassword'] = "Passwords do not match";
        }

        return $errors;
    }

    public function register() {
        $errors = [];
        
        $stmt = $this->db->prepare("SELECT username FROM Users WHERE username = :username");
        $stmt->execute([':username' => $this->username]);
        if ($stmt->fetch()) {
            $errors['username'] = "Username already exists";
        }

        $stmt = $this->db->prepare("SELECT email FROM Users WHERE email = :email");
        $stmt->execute([':email' => $this->email]);
        if ($stmt->fetch()) {
            $errors['email'] = "Email already registered";
        }

        if (!empty($errors)) {
            return $errors;
        }

        $rememberToken = bin2hex(random_bytes(32));
        $tokenExpires = date('Y-m-d H:i:s', time() + (30 * 24 * 60 * 60)); // 30 days
        
        $stmt = $this->db->prepare("
            INSERT INTO Users 
            (username, email, password_hash, role, remember_token, token_expires, created_at) 
            VALUES 
            (:username, :email, :password, :role, :remember_token, :token_expires, NOW())
        ");
        
        $result = $stmt->execute([
            ':username' => $this->username,
            ':email' => $this->email,
            ':password' => password_hash($this->password, PASSWORD_DEFAULT),
            ':role' => 'user',
            ':remember_token' => $rememberToken,
            ':token_expires' => $tokenExpires
        ]);

        return $result ? true : ['database' => "Registration failed. Please try again."];
    }
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    $registration = new UserRegistration($db, $username, $email, $password, $confirmPassword);
    $errors = $registration->validateInput();

    if (empty($errors)) {
        $result = $registration->register();
        
        if ($result === true) {
            $_SESSION['user'] = $username;
            $_SESSION['role'] = 'user';
            header('Location: project.php');
            exit();
        } else {
            $errors = array_merge($errors, $result);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoSphere | Register Form</title>
    <link rel="stylesheet" href="all.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@100..900&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Noto Sans', sans-serif;
            background-image: url('bmw-3-0-csl-mi-05.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .input-error {
            border: 1px solid red;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            gap: 10px;
            padding: 10px 20px;
            z-index: 1000;
        }

        .name {
            font-family: 'Orbitron', sans-serif;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 2px;
            color: rgb(255, 255, 255);
        }

        form {
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            width: 400px;
            padding: 40px;
            border-radius: 10px;
            border: none;
            margin: auto;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .social {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social div {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.27);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #eaf0fb;
            cursor: pointer;
        }

        .social div:hover {
            background-color: rgba(255, 255, 255, 0.47);
        }

        @media (max-width: 480px) {
            body {
                flex-direction: column;
                justify-content: center;
                align-items: center;
                overflow: auto;
                padding: 0 20px;
            }

            form {
                width: 100%;
                max-width: 350px;
                height: auto;
                margin: 20px 0;
                padding: 30px 20px;
            }

            .logo-wrapper {
                padding: 10px 0;
                padding-left: 45px;
            }

            .logo {
                width: 150px;
                transform: translateX(-15px);
            }

            .social {
                margin-top: 20px;
                display: flex;
                justify-content: center;
                gap: 15px;
            }

            .social div {
                height: 40px;
                width: 40px;
                border-radius: 50%;
                background-color: rgba(255, 255, 255, 0.27);
                display: flex;
                align-items: center;
                justify-content: center;
                color: #eaf0fb;
                cursor: pointer;
            }

            .social div:hover {
                background-color: rgba(255, 255, 255, 0.47);
            }

            .name {
                display: none;
            }

            .text-section {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="logo-wrapper">
        <a href="project.php"><img src="logo1.png" class="logo" style="padding-top: 4px;"></a>
        <div class="name" style="color: white; font-weight: bold; font-size: 24px;">AUTOSPHERE</div>
    </div>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <form method="POST">
        <h3 class="register-title" style="text-align: center;text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);">Sign Up</h3>
        <div class="sing-up-subtitle" style="text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);">Just some details to get you in!</div>

        <input type="text" placeholder="Username" id="username" name="username"
            value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
            class="<?php echo isset($errors['username']) ? 'input-error' : ''; ?>">
        <?php if (isset($errors['username'])): ?>
            <div class="error-message"><?php echo $errors['username']; ?></div>
        <?php endif; ?>

        <input type="email" placeholder="Email" id="email" name="email"
            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
            class="<?php echo isset($errors['email']) ? 'input-error' : ''; ?>">
        <?php if (isset($errors['email'])): ?>
            <div class="error-message"><?php echo $errors['email']; ?></div>
        <?php endif; ?>

        <input type="password" placeholder="Password" id="password" name="password"
            class="<?php echo isset($errors['password']) ? 'input-error' : ''; ?>">
        <?php if (isset($errors['password'])): ?>
            <div class="error-message"><?php echo $errors['password']; ?></div>
        <?php endif; ?>

        <input type="password" placeholder="Confirm Password" id="confirmPassword" name="confirmPassword"
            class="<?php echo isset($errors['confirmPassword']) ? 'input-error' : ''; ?>">
        <?php if (isset($errors['confirmPassword'])): ?>
            <div class="error-message"><?php echo $errors['confirmPassword']; ?></div>
        <?php endif; ?>

        <button id="button" type="submit">Sign Up</button>

        <div>
            <span class="or">Or</span>
        </div>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i></div>
            <div class="fb"><i class="fab fa-facebook"></i></div>
            <div class="gh"><i class="fab fa-github"></i></div>
        </div>
        <div class="sign-up" style="text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);">
            Alreadr Registered? <br />
            <a href="login.php">Login</a>
        </div>

    </form>

    <div class="text-section" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
        <h1>Welcome to our Page!</h1>
        <p>Sign up to enjoy all our services</p>
    </div>
</body>

</html>