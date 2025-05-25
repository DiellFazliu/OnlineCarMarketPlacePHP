<?php
session_start();

define("MIN_PASSWORD_LENGTH", 8);
define("MAX_PASSWORD_LENGTH", 16);

$GLOBALS['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] : 0;

$username_pattern = '/^[a-zA-Z0-9]+$/';
$password_pattern = '/^[a-zA-Z0-9!@#$%^&*()_+]{8,16}$/';

$db = new PDO('pgsql:host=switchyard.proxy.rlwy.net;port=33345;dbname=railway', 'postgres', 'bpsELXfRwyqjyxghAUnKvuRygaQcSXSc', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_PERSISTENT => false
]);

class UserAuthenticator
{
    private $username;
    private $password;
    private $remember;
    private $db;

    public function __construct($db, $username, $password, $remember = false)
    {
        $this->db = $db;
        $this->username = $username;
        $this->password = $password;
        $this->remember = $remember;
    }

    public function validateInput()
    {
        global $username_pattern, $password_pattern;

        $errors = [];

        if (empty($this->username)) {
            $errors['username'] = "Username cannot be empty";
        } elseif (!preg_match($username_pattern, $this->username)) {
            $errors['username'] = "Username can only contain letters and numbers";
        }

        if (empty($this->password)) {
            $errors['password'] = "Password cannot be empty";
        } elseif (!preg_match($password_pattern, $this->password)) {
            $errors['password'] = "Password must be 8-16 characters long";
        }

        return $errors;
    }

    public function authenticate()
    {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE username = :username");
        $stmt->execute([':username' => $this->username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        if (password_verify($this->password, $user['password_hash'])) {
            return $user;
        }

        return false;
    }

    public function rememberLogin()
    {
        if ($this->remember) {
            $token = bin2hex(random_bytes(32));
            $expires = time() + (30 * 24 * 60 * 60);

            $stmt = $this->db->prepare("UPDATE Users SET remember_token = :token, token_expires = :expires WHERE username = :username");
            $stmt->execute([
                ':token' => $token,
                ':expires' => date('Y-m-d H:i:s', $expires),
                ':username' => $this->username
            ]);

            setcookie('remember_token', $token, $expires, '/', true, true);
        }
    }
}

if (empty($_SESSION['user']) && isset($_COOKIE['remember_token'])) {
    $stmt = $db->prepare("SELECT * FROM Users WHERE remember_token = :token AND token_expires > NOW()");
    $stmt->execute([':token' => $_COOKIE['remember_token']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = [
            'email' => $user['email'],
            'name' => $user['name']
        ];
        $_SESSION['role'] = $user['role'];
        header('Location: project.php');
        exit();
    }
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['rememberMe']);

    $authenticator = new UserAuthenticator($db, $username, $password, $remember);
    $errors = $authenticator->validateInput();

    if (empty($errors)) {
        $user = $authenticator->authenticate();
        if ($user) {
            $authenticator->rememberLogin();
            $_SESSION['user'] = $user['username'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user'] = [
                'email' => $user['email'],
                'name' => $user['name']
            ];
            $_SESSION['role'] = $user['role'];
            header('Location: project.php');
            exit();
        } else {
            $errors['auth'] = "Invalid username or password";
            $_SESSION['login_attempts'] = ++$GLOBALS['login_attempts'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoSphere | Login Form</title>
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
        <h3 style="text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);">Login</h3>
        <div class="login-subtitle" style="text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);">Glad you're back!</div>

        <input type="text" placeholder="Username" id="username" name="username"
            value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : (isset($_COOKIE['remembered_user']) ? htmlspecialchars($_COOKIE['remembered_user']) : ''); ?>"
            class="<?php echo isset($errors['username']) ? 'input-error' : ''; ?>">
        <?php if (isset($errors['username'])): ?>
            <div class="error-message"><?php echo $errors['username']; ?></div>
        <?php endif; ?>

        <input type="password" placeholder="Password" id="password" name="password"
            class="<?php echo isset($errors['password']) ? 'input-error' : ''; ?>">
        <?php if (isset($errors['password'])): ?>
            <div class="error-message"><?php echo $errors['password']; ?></div>
        <?php endif; ?>

        <div class="remember-me">
            <input type="checkbox" id="rememberMe" name="rememberMe" <?php echo isset($_COOKIE['remembered_user']) ? 'checked' : ''; ?>>
            <label for="rememberMe" style="text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);">Remember me</label>
        </div>
        <input id="button" type="submit" value="Login">

        <?php if (isset($errors['auth'])): ?>
            <div class="error-message" style="text-align: center; margin-top: 10px;">
                <?php echo $errors['auth']; ?>
            </div>
        <?php endif; ?>

        <div class="forgot-password">
            <a href="#" style="text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);">Forgot password?</a>
        </div>
        <div style="padding-top:10px;text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);">
            <span class="or">Or</span>
        </div>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i></div>
            <div class="fb"><i class="fab fa-facebook"></i></div>
            <div class="gh"><i class="fab fa-github"></i></div>
        </div>

        <div class="sign-up" style="text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);">
            Don't have an account? <br />
            <a href="register.php"> <br> Sign up</a>
        </div>

    </form>

    <div class="text-section" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
        <h1>Drive Your Dream Car Today</h1>
        <p>Log in to explore top car listings,<br>
            manage your profile, and find exclusive offers.</p>
    </div>
</body>

</html>