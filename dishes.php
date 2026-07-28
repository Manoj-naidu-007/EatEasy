<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php"); 
error_reporting(0);
session_start();

include_once 'product-action.php'; 

?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Dishes</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet"> </head>

<body>
    
        <header id="header" class="header-scroll top-header headrom">
            <nav class="navbar navbar-dark">
                <div class="container">
                    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                    <a class="navbar-brand" href="index.php">  <img class="img-rounded" src="images/eateasy1.png" alt="EatEasy Logo"
       style="width: 55px;height: 45px;">
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
            <div class="top-links">
                <div class="container">
                    <ul class="row links">
                      
                        <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose Restaurant</a></li>
                        <li class="col-xs-12 col-sm-4 link-item active"><span>2</span><a href="dishes.php?res_id=<?php echo $_GET['res_id']; ?>">Pick Your favorite food</a></li>
                        <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order and Pay</a></li>
                        
                    </ul>
                </div>
            </div>
			<?php $ress= mysqli_query($db,"select * from restaurant where rs_id='$_GET[res_id]'");
									     $rows=mysqli_fetch_array($ress);
										  
										  ?>
            <section class="inner-page-hero bg-image" data-image-src="images/img/restrrr.png">
                <div class="profile">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12  col-md-4 col-lg-4 profile-img">
                                <div class="image-wrap">
                                    <figure><?php echo '<img src="admin/Res_img/'.$rows['image'].'" alt="Restaurant logo">'; ?></figure>
                                </div>
                            </div>
							
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 profile-desc">
                                <div class="pull-left right-text white-txt">
                                    <h6><a href="#"><?php echo $rows['title']; ?></a></h6>
                                    <p><?php echo $rows['address']; ?></p>   
                                </div>
                            </div>
							
							
                        </div>
                    </div>
                </div>
            </section>
            <div class="breadcrumb">
                <div class="container">
                   
                </div>
            </div>
            <div class="container m-t-30">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                        
                         <div class="widget widget-cart">
                                <div class="widget-heading">
                                    <h3 class="widget-title text-dark">
                                 Your Cart
                              </h3>
							  				  
							  
                                    <div class="clearfix"></div>
                                </div>
                                <div class="order-row bg-white">
                                    <div class="widget-body">
									
									
	<?php

$item_total = 0;

foreach ($_SESSION["cart_item"] as $item)  
{
?>									
									
                                        <div class="title-row">
										<?php echo $item["title"]; ?><a href="dishes.php?res_id=<?php echo $_GET['res_id']; ?>&action=remove&id=<?php echo $item["d_id"]; ?>" >
										<i class="fa fa-trash pull-right"></i></a>
										</div>
										
                                        <div class="form-group row no-gutter">
                                            <div class="col-xs-8">
                                                 <input type="text" class="form-control b-r-0" value=<?php echo "₹".$item["price"]; ?> readonly id="exampleSelect1">
                                                   
                                            </div>
                                            <div class="col-xs-4">
                                               <input class="form-control" type="text" readonly value='<?php echo $item["quantity"]; ?>' id="example-number-input"> </div>
                                        
									  </div>
									  
	<?php
$item_total += ($item["price"]*$item["quantity"]); 
}
?>								  
									  
									  
									  
                                    </div>
                                </div>
                               
                         
                             
                                <div class="widget-body">
                                    <div class="price-wrap text-xs-center">
                                        <p>TOTAL</p>
                                        <h3 class="value"><strong><?php echo "₹".$item_total; ?></strong></h3>
                                        <p>Free Delivery!</p>
                                        <?php
                                        if($item_total==0){
                                        ?>

                                        
                                        <a href="checkout.php?res_id=<?php echo $_GET['res_id'];?>&action=check"  class="btn btn-danger btn-lg disabled">Checkout</a>

                                        <?php
                                        }
                                        else{   
                                        ?>
                                        <a href="checkout.php?res_id=<?php echo $_GET['res_id'];?>&action=check"  class="btn btn-success btn-lg active">Checkout</a>
                                        <?php   
                                        }
                                        ?>

                                    </div>
                                </div>
								
						
								
								
                            </div>
                    </div>

                    <div class="col-md-8">
                      
             
                        <div class="menu-widget" id="2">
                            <div class="widget-heading">
                                <h3 class="widget-title text-dark">
                              MENU <a class="btn btn-link pull-right" data-toggle="collapse" href="#popular2" aria-expanded="true">
                              <i class="fa fa-angle-right pull-right"></i>
                              <i class="fa fa-angle-down pull-right"></i>
                              </a>
                           </h3>
                                <div class="clearfix"></div>
                            </div>
                            <div class="collapse in" id="popular2">
						<?php  
									$stmt = $db->prepare("select * from dishes where rs_id='$_GET[res_id]'");
									$stmt->execute();
									$products = $stmt->get_result();
									if (!empty($products)) 
									{
									foreach($products as $product)
										{
						
													
													 
													 ?>
                                <div class="food-item">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-lg-8">
										<form method="post" action='dishes.php?res_id=<?php echo $_GET['res_id'];?>&action=add&id=<?php echo $product['d_id']; ?>'>
                                            <div class="rest-logo pull-left">
                                                <a class="restaurant-logo pull-left" href="#"><?php echo '<img src="admin/Res_img/dishes/'.$product['img'].'" alt="Food logo">'; ?></a>
                                            </div>
                                
                                            <div class="rest-descr">
                                                <h6><a href="#"><?php echo $product['title']; ?></a></h6>
                                                <p> <?php echo $product['slogan']; ?></p>
                                            </div>
                           
                                        </div>
                               
                                        <div class="col-xs-12 col-sm-12 col-lg-3 pull-right item-cart-info"> 
										<span class="price pull-left" >₹<?php echo $product['price']; ?></span>
										  <input class="b-r-0" type="text" name="quantity"  style="margin-left:30px;" value="1" size="2" />
										  <input type="submit" class="btn theme-btn" style="margin-left:40px;" value="Add To Cart" />
										</div>
										</form>
                                    </div>
              
                                </div>
                
								
								<?php
									  }
									}
									
								?>
								
								
                              
                            </div>
             
                        </div>
            
                       
                    </div>
                    
                </div>
     
            </div>
        
            <footer class="footer">
                <div class="container">
           
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
                                    <p>1086 Stockert Hollow Road, Seattle</p>
                                    <h5>Phone: 75696969855</a></h5> </div>
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
  
    </div>

 
    <div class="modal fade" id="order-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                <div class="modal-body cart-addon">
                    <div class="food-item white">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-lg-6">
                                <div class="item-img pull-left">
                                    <a class="restaurant-logo pull-left" href="#"><img src="http://placehold.it/70x70" alt="Food logo"></a>
                                </div>
              
                                <div class="rest-descr">
                                    <h6><a href="#">Sandwich de Alegranza Grande Menü (28 - 30 cm.)</a></h6> </div>
               
                            </div>
           
                            <div class="col-xs-6 col-sm-2 col-lg-2 text-xs-center"> <span class="price pull-left">$ 2.99</span></div>
                            <div class="col-xs-6 col-sm-4 col-lg-4">
                                <div class="row no-gutter">
                                    <div class="col-xs-7">
                                        <select class="form-control b-r-0" id="exampleSelect2">
                                            <option>Size SM</option>
                                            <option>Size LG</option>
                                            <option>Size XL</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-5">
                                        <input class="form-control" type="number" value="0" id="quant-input-2"> </div>
                                </div>
                            </div>
                        </div>
               
                    </div>
              
                    <div class="food-item">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-lg-6">
                                <div class="item-img pull-left">
                                    <a class="restaurant-logo pull-left" href="#"><img src="http://placehold.it/70x70" alt="Food logo"></a>
                                </div>
                    
                                <div class="rest-descr">
                                    <h6><a href="#">Sandwich de Alegranza Grande Menü (28 - 30 cm.)</a></h6> </div>
                
                            </div>
               
                            <div class="col-xs-6 col-sm-2 col-lg-2 text-xs-center"> <span class="price pull-left">$ 2.49</span></div>
                            <div class="col-xs-6 col-sm-4 col-lg-4">
                                <div class="row no-gutter">
                                    <div class="col-xs-7">
                                        <select class="form-control b-r-0" id="exampleSelect3">
                                            <option>Size SM</option>
                                            <option>Size LG</option>
                                            <option>Size XL</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-5">
                                        <input class="form-control" type="number" value="0" id="quant-input-3"> </div>
                                </div>
                            </div>
                        </div>
            
                    </div>
            
                    <div class="food-item">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-lg-6">
                                <div class="item-img pull-left">
                                    <a class="restaurant-logo pull-left" href="#"><img src="http://placehold.it/70x70" alt="Food logo"></a>
                                </div>
                       
                                <div class="rest-descr">
                                    <h6><a href="#">Sandwich de Alegranza Grande Menü (28 - 30 cm.)</a></h6> </div>
                 
                            </div>
                
                            <div class="col-xs-6 col-sm-2 col-lg-2 text-xs-center"> <span class="price pull-left">$ 1.99</span></div>
                            <div class="col-xs-6 col-sm-4 col-lg-4">
                                <div class="row no-gutter">
                                    <div class="col-xs-7">
                                        <select class="form-control b-r-0" id="exampleSelect5">
                                            <option>Size SM</option>
                                            <option>Size LG</option>
                                            <option>Size XL</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-5">
                                        <input class="form-control" type="number" value="0" id="quant-input-4"> </div>
                                </div>
                            </div>
                        </div>
                 
                    </div>
               
                    <div class="food-item">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-lg-6">
                                <div class="item-img pull-left">
                                    <a class="restaurant-logo pull-left" href="#"><img src="http://placehold.it/70x70" alt="Food logo"></a>
                                </div>
                 
                                <div class="rest-descr">
                                    <h6><a href="#">Sandwich de Alegranza Grande Menü (28 - 30 cm.)</a></h6> </div>
                      
                            </div>
                       
                            <div class="col-xs-6 col-sm-2 col-lg-2 text-xs-center"> <span class="price pull-left">$ 3.15</span></div>
                            <div class="col-xs-6 col-sm-4 col-lg-4">
                                <div class="row no-gutter">
                                    <div class="col-xs-7">
                                        <select class="form-control b-r-0" id="exampleSelect6">
                                            <option>Size SM</option>
                                            <option>Size LG</option>
                                            <option>Size XL</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-5">
                                        <input class="form-control" type="number" value="0" id="quant-input-5"> </div>
                                </div>
                            </div>
                        </div>
           
                    </div>
             
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn theme-btn">Add To Cart</button>
                </div>
            </div>
        </div>
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
