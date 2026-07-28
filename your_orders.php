<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

if(empty($_SESSION['user_id']))  
{
	header('location:login.php');
}
else
{
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>My Orders</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<style type="text/css" rel="stylesheet">


.indent-small {
  margin-left: 5px;
}
.form-group.internal {
  margin-bottom: 0;
}
.dialog-panel {
  margin: 10px;
}
.datepicker-dropdown {
  z-index: 200 !important;
}
.panel-body {
  background: #e5e5e5;
  /* Old browsers */
  background: -moz-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
  /* FF3.6+ */
  background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, #e5e5e5), color-stop(100%, #ffffff));
  /* Chrome,Safari4+ */
  background: -webkit-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
  /* Chrome10+,Safari5.1+ */
  background: -o-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
  /* Opera 12+ */
  background: -ms-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
  /* IE10+ */
  background: radial-gradient(ellipse at center, #e5e5e5 0%, #ffffff 100%);
  /* W3C */
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e5e5e5', endColorstr='#ffffff', GradientType=1);
  font: 600 15px "Open Sans", Arial, sans-serif;
}
label.control-label {
  font-weight: 600;
  color: #777;
}

/* 
table { 
	width: 750px; 
	border-collapse: collapse; 
	margin: auto;
	
	}

/* Zebra striping */
/* tr:nth-of-type(odd) { 
	background: #eee; 
	}

th { 
	background: #404040; 
	color: white; 
	font-weight: bold; 
	
	}

td, th { 
	padding: 10px; 
	border: 1px solid #ccc; 
	text-align: left; 
	font-size: 14px;
	
	} */ */


@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	/* table { 
	  	width: 100%; 
	}

	
	table, thead, tbody, th, td, tr { 
		display: block; 
	} */
	
	
	/* thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; } */
	
	/* td { 
		
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}

	td:before { 
		
		position: absolute;
	
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
		
		content: attr(data-column);

		color: #000;
		font-weight: bold;
	} */

}







	</style>

	</head>

<body>
    
      
        <header id="header" class="header-scroll top-header headrom">
  
            <nav class="navbar navbar-dark">
                <div class="container">
                    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                    <a class="navbar-brand" href="index.php">  <img class="img-rounded" src="images/eateasy1.png" alt="EatEasy Logo"
       style="width: 60px;height: 60px;">
</a>
                    <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                            <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants <span class="sr-only"></span></a> </li>
                            
							<?php
						if(empty($_SESSION["user_id"]))
							{
								echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
							}
						else
							{
									
									
									echo  '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
									echo  '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
							}

						?>
							 
                        </ul>
                    </div>
                </div>
            </nav>
  
        </header>
        <div class="page-wrapper">
       
           
    
            <div class="inner-page-hero bg-image" data-image-src="images/img/pimg.jpg">
                <div class="container"> </div>
        
            </div>
            <div class="result-show">
                <div class="container">
                    <div class="row">
                       
                       
                    </div>
                </div>
            </div>
    
            <section class="restaurants-page">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                          </div>
                        <div class="col-xs-12">
                            <div class="bg-gray">
                                <div class="row">
								
							<table class="table table-bordered table-hover">
						  <thead style = "background: #404040; color:white;">
							<tr>
							
							  <th>Item</th>
							  <th>Quantity</th>
							  <th>Price</th>
							   <th>Status</th>
							     <th>Date</th>
								   <th>Action</th>
							  
							</tr>
						  </thead>
						  <tbody>
						  
						  
							<?php 
				
						$query_res= mysqli_query($db,"select * from users_orders where u_id='".$_SESSION['user_id']."'");
												if(!mysqli_num_rows($query_res) > 0 )
														{
															echo '<td colspan="6"><center>You have No orders Placed yet. </center></td>';
														}
													else
														{			      
										  
										  while($row=mysqli_fetch_array($query_res))
										  {
						
							?>
												<tr>	
														 <td data-column="Item"> <?php echo $row['title']; ?></td>
														  <td data-column="Quantity"> <?php echo $row['quantity']; ?></td>
														  <td data-column="price">₹<?php echo $row['price']; ?></td>
														   <td data-column="status"> 
														   <?php 
																			$status=$row['status'];
																			if($status=="" or $status=="NULL")
																			{
																			?>
																			<button type="button" class="btn btn-info"><span class="fa fa-bars"  aria-hidden="true" ></span> Dispatch</button>
																		   <?php 
																			  }
																			   if($status=="in process")
																			 { ?>
																				<button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin"  aria-hidden="true" ></span> On The Way!</button>
																			<?php
																				}
																			if($status=="closed")
																				{
																			?>
																			 <button type="button" class="btn btn-success" ><span  class="fa fa-check-circle" aria-hidden="true"></span> Delivered</button> 
																			<?php 
																			} 
																			?>
																			<?php
																			if($status=="rejected")
																				{
																			?>
																			 <button type="button" class="btn btn-danger"> <i class="fa fa-close"></i> Cancelled</button>
																			<?php 
																			} 
																			?>
														   
														   
														   
														   
														   
														   
														   </td>
														  <td data-column="Date"> <?php echo $row['date']; ?></td>
														   <td data-column="Action"> <a href="delete_orders.php?order_del=<?php echo $row['o_id'];?>" onclick="return confirm('Are you sure you want to cancel your order?');" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" style="font-size:16px"></i></a> 
															</td>
														 
												</tr>
												
											
														<?php }} ?>					
							
							
										
						
						  </tbody>
					</table>
						
					
                                    
                                </div>
                           
                            </div>
                         
                            
                                
                            </div>
                          
                          
                           
                        </div>
                    </div>
                </div>
            </section>


            <footer class="footer">
                    <div class="row bottom-footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 payment-options color-gray">
                                    <h5>Payment Options</h5>
                                    <ul>
                                        <li>
                                            <a href="#"> <img src="images/paypal.png" alt="Paypal"> </a>
                                        </li>
                                        <li>
                                            <a href="#"> <img src="images/mastercard.png" alt="Mastercard"> </a>
                                        </li>
                                        <li>
                                            <a href="#"> <img src="images/maestro.png" alt="Maestro"> </a>
                                        </li>
                                        <li>
                                            <a href="#"> <img src="images/stripe.png" alt="Stripe"> </a>
                                        </li>
                                        <li>
                                            <a href="#"> <img src="images/bitcoin.png" alt="Bitcoin"> </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-sm-4 address color-gray">
                                    <h5>Address</h5>
                                    <p>Bangalore</p>
                                    <h5>Phone: 9876543211</a></h5> </div>
                                <div class="col-xs-12 col-sm-5 additional-info color-gray">
                                    <h5>Addition informations</h5>
                                   <p>Join thousands of other restaurants who benefit from having partnered with us.</p>
                                </div>
                            </div>
                        </div>
                    </div>
           
                </div>
            </footer>
        
        </div>
  
    
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>

	  <!-- ================= CHATBOT START ================= -->

<style>
#chatbot-toggle {
  position: fixed;
  bottom: 25px;
  right: 25px;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  font-size: 26px;
  cursor: pointer;

  background: linear-gradient(135deg, #ff7a00, #ffae00);
  color: #fff;

  display: flex;
  align-items: center;
  justify-content: center;

  box-shadow:
    0 0 15px rgba(255,122,0,0.6),
    0 0 30px rgba(255,174,0,0.6);

  transition: transform 0.3s ease, box-shadow 0.3s ease;
  z-index: 9999;
}

#chatbot-toggle:hover {
  transform: scale(1.1) rotate(8deg);
  box-shadow:
    0 0 25px rgba(255,122,0,0.9),
    0 0 45px rgba(255,174,0,0.9);
}

/* CHAT CONTAINER */
#chatbot {
  position: fixed;
  bottom: 95px;
  right: 25px;
  width: 340px;
  height: 430px;

  background: rgba(255, 140, 0, 0.55);
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);

  border-radius: 18px;
  display: none;
  flex-direction: column;

  box-shadow:
    0 0 20px rgba(255,122,0,0.4),
    0 20px 50px rgba(0,0,0,0.35);

  animation: chatbotPop 0.4s ease;
  z-index: 9999;
}

/* OPEN ANIMATION */
@keyframes chatbotPop {
  from {
    opacity: 0;
    transform: translateY(20px) scale(0.9);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

/* HEADER */
.chat-header {
  background: linear-gradient(135deg, #ff7a00, #ffae00);
  color: #fff;
  padding: 14px 16px;

  border-radius: 18px 18px 0 0;
  display: flex;
  justify-content: space-between;
  align-items: center;

  box-shadow: 0 4px 15px rgba(0,0,0,0.25);
}

.chat-header h4 {
  margin: 0;
  font-size: 15px;
}

.chat-header button {
  background: rgba(255, 255, 255, 0.2);
  border: none;
  color: #fff;
  font-size: 18px;
  cursor: pointer;
  padding: 4px 8px;
  border-radius: 6px;
}

.chat-header button:hover {
  background: rgba(255,255,255,0.35);
}

/* CHAT BODY */
.chat-body {
  padding: 12px;
  flex: 1;
  overflow-y: auto;
  font-size: 14px;
  scrollbar-width: thin;
  scrollbar-color: #ff7a00 transparent;
}

/* BOT MESSAGE */
.bot-msg {
  background: rgba(255,255,255,0.9);
  color: #333;
  padding: 10px 14px;
  border-radius: 14px 14px 14px 4px;
  margin-bottom: 10px;
  width: fit-content;
  max-width: 80%;

  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  animation: msgIn 0.3s ease;
}

/* USER MESSAGE */
.user-msg {
  background: linear-gradient(135deg, #ff7a00, #ffae00);
  color: #fff;
  padding: 10px 14px;
  border-radius: 14px 14px 4px 14px;
  margin-bottom: 10px;
  margin-left: auto;
  width: fit-content;
  max-width: 80%;

  box-shadow: 0 4px 12px rgba(255,122,0,0.4);
  animation: msgIn 0.3s ease;
}

/* MESSAGE ANIMATION */
@keyframes msgIn {
  from {
    opacity: 0;
    transform: translateY(8px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* QUICK BUTTONS */
.quick-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  margin-top: 6px;
}

.quick-buttons button {
  padding: 6px 12px;
  border-radius: 20px;
  border: none;
  font-size: 12px;
  cursor: pointer;

  background: rgba(255,255,255,0.8);
  color: #ff7a00;

  transition: background 0.3s, transform 0.2s;
}

.quick-buttons button:hover {
  background: linear-gradient(135deg, #ff7a00, #ffae00);
  color: #fff;
  transform: translateY(-2px);
}

/* FOOTER */
.chat-footer {
  display: flex;
  padding: 8px;
  border-top: 1px solid rgba(255,255,255,0.3);
  background: rgba(255,255,255,0.2);
}

.chat-footer input {
  flex: 1;
  padding: 10px 12px;
  border-radius: 20px;
  border: none;
  outline: none;
  background: rgba(255,255,255,0.9);
}

.chat-footer button {
  margin-left: 8px;
  padding: 0 16px;
  border-radius: 20px;
  border: none;
  cursor: pointer;

  background: linear-gradient(135deg, #ff7a00, #ffae00);
  color: #fff;
}

/* ICON BUTTON (your extra one) */
#chatbot-toggle {
  background: linear-gradient(135deg, #ff7a00, #ffae00);
}

#chatbot-icon {
  width: 50px;
  height: 50px;
}
</style>
<div id="chatbot-toggle">
  <img src="chatbot.png" alt="Chatbot" id="chatbot-icon">
</div>

<div id="chatbot">
  <div class="chat-header">
    <span>EatEasy Bot</span>
    <button onclick="toggleChat()">✖</button>
  </div>

  <div class="chat-body" id="chatBody">
    <div class="bot-msg">👋 Hi! Welcome to EatEasy</div>
    <div class="bot-msg">What would you like to do?</div>

    <div class="quick-buttons">
      <button onclick="goTo('restaurants.php')">🍽 Restaurants</button>
      <button onclick="goTo('restaurants.php')">📋 View Menu</button>
      <button onclick="goTo('your_orders.php')">🛒 My Orders</button>
      <button onclick="goTo('restaurants.php')">➕ Add to Cart</button>
      <button onclick="goTo('your_orders.php')">📦 Track Order</button>
    </div>
  </div>

  <div class="chat-footer">
    <input type="text" id="userInput" placeholder="Type here...">
    <button onclick="sendMessage()">➤</button>
  </div>
</div>

<script>
const chatbot = document.getElementById("chatbot");
const chatBody = document.getElementById("chatBody");

document.getElementById("chatbot-toggle").onclick = toggleChat;

function toggleChat() {
  chatbot.style.display = chatbot.style.display === "flex" ? "none" : "flex";
}

function appendMessage(text, type) {
  const div = document.createElement("div");
  div.className = type === "user" ? "user-msg" : "bot-msg";
  div.innerText = text;
  chatBody.appendChild(div);
  chatBody.scrollTop = chatBody.scrollHeight;
}

function goTo(page) {
  appendMessage("Opening...", "bot");
  window.location.href = page;
}

function sendMessage() {
  const input = document.getElementById("userInput");
  const msg = input.value.trim().toLowerCase();
  if (!msg) return;

  appendMessage(input.value, "user");
  input.value = "";

  if (msg.includes("restaurant")) goTo("restaurants.php");
  else if (msg.includes("menu")) goTo("restaurants.php");
  else if (msg.includes("order")) goTo("your_orders.php");
   else if (msg.includes("track order")) goTo("your_orders.php");
  else appendMessage("Please use this cmds only 😊 resturant, menu, order, track order", "bot");
}
</script>
</body>

</html>
<?php
}
?>