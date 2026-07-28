<?php
session_start();

/* DB CONNECTION */
$conn = mysqli_connect("localhost", "root", "", "onlinefoodphp");
if (!$conn) {
    die("Database connection failed");
}

/* REGISTER */
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM delivery_users WHERE phone='$phone'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "Phone number already registered!";
    } else {
        mysqli_query($conn, "INSERT INTO delivery_users (name, phone, password) VALUES ('$name','$phone','$password')");
        $msg = "Registration successful! Please login.";
        $_GET['page'] = "login";
    }
}

/* LOGIN */
if (isset($_POST['login'])) {
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM delivery_users WHERE phone='$phone'");
    $row = mysqli_fetch_assoc($query);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['delivery_id'] = $row['id'];
        $_SESSION['delivery_name'] = $row['name'];

        header("Location:dashboard.php"); // change if needed
        exit;
    } else {
        $msg = "Invalid phone or password!";
    }
}

/* PAGE SWITCH */
$page = isset($_GET['page']) ? $_GET['page'] : 'login';
?>

<!DOCTYPE html>
<html>
<head>
<title>Delivery Auth</title>

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

<?php if(isset($msg)) echo "<div class='msg'>$msg</div>"; ?>

<div class="switch">
    <a href="?page=login" class="<?php echo ($page=='login')?'active':''; ?>">Login</a>
    <a href="?page=register" class="<?php echo ($page=='register')?'active':''; ?>">Register</a>
</div>

<?php if ($page == "register") { ?>
   <div class="header">
    <img src="images/delivery1.png" alt="delivery logo" style="width: 70px;height:auto;">
    <h2>Delivery Registration</h2>
</div>
    <form method="POST">
        <input type="text" name="name" placeholder="Delivery Partner Name" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="register">Register</button>
    </form>
<?php } else { ?>
    <div class="header">
    <img src="images/delivery1.png" alt="delivery logo" style="width: 70px;height:auto;">
    <h2>Delivery Login</h2>
</div>
    <form method="POST">
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="login">Login</button>
    </form>
<?php } ?>

</div>

</body>
</html>
