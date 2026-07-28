<?php
session_start();

/* DATABASE CONNECTION */
$conn = mysqli_connect("localhost", "root", "", "onlinefoodphp");
if (!$conn) {
    die("Database connection failed");
}

/* HANDLE REGISTRATION */
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM restaurant_users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "Email already registered!";
    } else {
        mysqli_query($conn, "INSERT INTO restaurant_users (name,email,password) VALUES ('$name','$email','$password')");
        $msg = "Registration successful! Please login.";
        $_GET['page'] = "login";
    }
}

/* HANDLE LOGIN */
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM restaurant_users WHERE email='$email'");
    $row = mysqli_fetch_assoc($query);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['restaurant_id'] = $row['id'];
        $_SESSION['restaurant_name'] = $row['name'];
        header("Location: add_menu.php");
        exit;
    } else {
        $msg = "Invalid email or password!";
    }
}

/* PAGE SWITCH */
$page = isset($_GET['page']) ? $_GET['page'] : 'login';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Auth</title>
<style>
body {
    background: linear-gradient(120deg, #141E30, #243B55);
    font-family: 'Segoe UI', sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
}

/* NEON GLASS BOX */
.auth-box {
    width: 370px;
    padding: 35px;
    border-radius: 18px;
    text-align: center;
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);

    box-shadow:
        0 0 15px rgba(0,255,255,0.6),
        0 0 30px rgba(255,0,255,0.5);

    animation: neonPulse 3s infinite alternate;
}

@keyframes neonPulse {
    from {
        box-shadow:
            0 0 12px rgba(0,255,255,0.4),
            0 0 25px rgba(255,0,255,0.4);
    }
    to {
        box-shadow:
            0 0 22px rgba(0,255,255,0.9),
            0 0 40px rgba(255,0,255,0.9);
    }
}

/* SWITCH */
.switch {
    display: flex;
    margin-bottom: 20px;
}

.switch a {
    flex: 1;
    padding: 10px;
    text-decoration: none;
    color: rgba(255,255,255,0.7);
    font-weight: bold;
    position: relative;
}

.switch a.active {
    color: #fff;
}

.switch a::after {
    content: "";
    position: absolute;
    bottom: -5px;
    left: 50%;
    width: 0;
    height: 3px;
    background: linear-gradient(90deg, #00ffff, #ff00ff);
    transition: 0.4s;
    transform: translateX(-50%);
}

.switch a.active::after {
    width: 60%;
}

/* TEXT */
h2, p {
    color: #fff;
}

/* INPUT */
input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.4);
    background: rgba(255,255,255,0.25);
    color: #fff;
    outline: none;
}

input::placeholder {
    color: rgba(255,255,255,0.8);
}

/* BUTTON */
button {
    width: 100%;
    padding: 12px;
    margin-top: 12px;
    background: linear-gradient(135deg, #00ffff, #ff00ff);
    border: none;
    border-radius: 8px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: transform 0.2s;
}

button:hover {
    transform: translateY(-2px);
}

/* MESSAGE */
.msg {
    color: #ffdddd;
    margin-bottom: 12px;
}

/* FORM ANIMATION */
form {
    animation: slideFade 0.5s ease;
}

@keyframes slideFade {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
</head>
<body>
<img src="images/pimg.jpg" 
     style="position:fixed; top:0; left:0; width:100%; height:100%; object-fit:cover; z-index:-1;">
<div class="auth-box">

    <?php if (isset($msg)) echo "<div class='msg'>$msg</div>"; ?>

    <?php if ($page == "register") { ?>
        <div style="text-align:center;">
    <img src="images/chef.png" alt="Chef Logo" width="120">
    <h2>Restaurant Registration </h2>
</div>
        <form method="POST">
            <input type="text" name="name" placeholder="Restaurant Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Register</button>
        </form>
        <p>Already registered? <a href="?page=login">Login</a></p>

    <?php } else { ?>
              <div style="text-align:center;">
    <img src="images/chef.png" alt="Chef Logo" width="120">
    <h2>Restaurant Login </h2>
</div>
        <form method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p>New restaurant? <a href="?page=register">Register</a></p>
    <?php } ?>

</div>

</body>
</html>
