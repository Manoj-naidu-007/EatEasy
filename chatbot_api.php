<?php
include("connection/connect.php");
session_start();

$action = $_GET['action'] ?? '';

/* ================= LOGIN CHECK ================= */
if(empty($_SESSION['user_id'])){
    echo json_encode(["status" => "login_required"]);
    exit;
}

/* ================= RESTAURANTS ================= */
if($action == "restaurants"){
    $res = mysqli_query($db,"SELECT rs_id,title FROM restaurant");
    $data = [];

    while($row = mysqli_fetch_assoc($res)){
        $data[] = $row;
    }

    echo json_encode($data);
}

/* ================= MENU ================= */
if($action == "menu"){
    $id = $_GET['res_id'];

    $res = mysqli_query($db,"SELECT d_id,title,price FROM dishes WHERE rs_id='$id'");
    $data = [];

    while($row = mysqli_fetch_assoc($res)){
        $data[] = $row;
    }

    echo json_encode($data);
}

/* ================= SAVE CART (NEW) ================= */
if($action == "save_cart"){
    $input = json_decode(file_get_contents("php://input"), true);

    // store full cart in session
    $_SESSION['cart'] = $input;

    echo json_encode(["status" => "saved"]);
}

/* ================= PLACE ORDER ================= */
if($action == "place_order"){

    $input = json_decode(file_get_contents("php://input"), true);
    $uid = $_SESSION['user_id'];

    foreach($input as $i){

        $d_id = $i['id'];
        $price = $i['price'];
        $qty = $i['qty'];

        // Get dish name
        $dish = mysqli_fetch_assoc(mysqli_query($db,
            "SELECT title FROM dishes WHERE d_id='$d_id'"));

        $title = $dish['title'];

        mysqli_query($db,"INSERT INTO users_orders 
        (u_id, title, quantity, price, status, date)
        VALUES 
        ('$uid', '$title', '$qty', '$price', '', NOW())");
    }

    echo json_encode(["status"=>"success"]);
}
?>