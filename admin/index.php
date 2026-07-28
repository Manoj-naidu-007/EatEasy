<!DOCTYPE html>
<html lang="en" >
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if(isset($_POST['submit']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if(!empty($_POST["submit"])) 
     {
	$loginquery ="SELECT * FROM admin WHERE username='$username' && password='".md5($password)."'";
	$result=mysqli_query($db, $loginquery);
	$row=mysqli_fetch_array($result);
	
	                        if(is_array($row))
								{
                                    	$_SESSION["adm_id"] = $row['adm_id'];
										header("refresh:1;url=dashboard.php");
	                            } 
							else
							    {
										echo "<script>alert('Invalid Username or Password!');</script>"; 
                                }
	 }
	
	
}

?>

<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

      <link rel="stylesheet" href="css/login.css">

  <style>
    /* ====== BODY BACKGROUND ====== */
body {
  background: url('../images/bg.jpg') no-repeat center center/cover;
  font-family: "Roboto", sans-serif;
  min-height: 100vh;
  margin: 0;
}

/* Dark overlay */
body:before {
  content: "";
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.55);
  z-index: 0;
}

/* ====== TRANSPARENT LOGIN BOX ====== */
.form {
  position: relative;
  z-index: 2;
  background: rgba(255, 255, 255, 0.12);  /* Transparent */
  backdrop-filter: blur(15px);            /* Glass effect */
  -webkit-backdrop-filter: blur(15px);
  max-width: 350px;
  margin: 80px auto;
  padding: 40px 30px;
  border-radius: 15px;
  text-align: center;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

/* ====== PROFILE CIRCLE ====== */
.form .thumbnail {
  background: linear-gradient(135deg, #6a5acd, #8a2be2);
  width: 120px;
  height: 120px;
  margin: 0 auto 25px;
  padding: 25px;
  border-radius: 50%;
  box-shadow: 0 10px 25px rgba(106, 90, 205, 0.5);
}

/* ====== INPUT FIELDS ====== */
.form input {
  background: rgba(255, 255, 255, 0.25);
  border: none;
  width: 100%;
  margin: 0 0 15px;
  padding: 14px;
  border-radius: 8px;
  font-size: 14px;
  color: #fff;
  outline: none;
}

.form input::placeholder {
  color: #eee;
}

.form input:focus {
  background: rgba(255, 255, 255, 0.35);
}

/* ====== GRADIENT BUTTON ====== */
.form input[type="submit"],
.form button {
  background: linear-gradient(135deg, #25c5fa);
  border: none;
  padding: 14px;
  width: 100%;
  border-radius: 30px;   /* Radio/rounded style */
  color: #fff;
  font-size: 15px;
  font-weight: 500;
  cursor: pointer;
  transition: 0.3s ease;
  box-shadow: 0 8px 20px rgba(61, 62, 63, 0.4);
}

.form input[type="submit"]:hover,
.form button:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 25px rgba(35, 203, 249, 0.6);
}

/* ====== TITLE ====== */
.container .info h1 {
  color: #ffffff;
  font-weight: 500;
}</style>
</head>

<body>

  <img src="images/pimg.jpg" 
     style="position:fixed; top:0; left:0; width:100%; height:100%; object-fit:cover; z-index:-1;">
<div class="container">
  <div class="info">
    <h1>Admin Panel </h1>
  </div>
</div>
<div class="form">
  <div class="thumbnail"><img src="images/admin.png" alt="Chef Logo" width="120"></div>
  <span style="color:red;"><?php echo $message; ?></span>
   <span style="color:green;"><?php echo $success; ?></span>
  <form class="login-form" action="index.php" method="post">
    <input type="text" placeholder="Username" name="username"/>
    <input type="password" placeholder="Password" name="password"/>
    <input type="submit"  name="submit" value="Login" />

  </form>
  
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src='js/index.js'></script>
</body>

</html>
