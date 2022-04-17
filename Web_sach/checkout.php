<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ',$cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'Giỏ hàng của bạn đang trống!';
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = 'Đơn đặt hàng đã tồn tại!'; 
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'Đơn hàng đã được đặt thành công!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      }
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thanh toán</title>

   <!-- chèn link font awesome  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- chèn link css  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Thủ tục thanh toán</h3>
   <p> <a href="home.php">Trang chủ</a> / Thanh toán </p>
</div>

<section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo $fetch_cart['price'].' vnd'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">Giỏ hàng của bạn đang trống </p>';
   }
   ?>
   <div class="grand-total"> Tổng giá : <span><?php echo $grand_total; ?> vnd</span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>Nhập thông tin đơn hàng</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Họ tên :</span>
            <input type="text" name="name" required placeholder="Nhập họ tên">
         </div>
         <div class="inputBox">
            <span>SĐT :</span>
            <input type="number" name="number" required placeholder="Nhập SĐT">
         </div>
         <div class="inputBox">
            <span>email :</span>
            <input type="email" name="email" required placeholder="Nhập email">
         </div>
         <div class="inputBox">
            <span>Phương thức thanh toán :</span>
            <select name="method">
               <option value="cash on delivery">Thanh toán khi giao hàng</option>
               <option value="credit card">Thẻ tín dụng</option>
               <option value="paypal">paypal</option>
               <option value="momo">Momo</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Số nhà :</span>
            <input type="text" min="0" name="flat" required placeholder="Nhập số nhà">
         </div>
         <div class="inputBox">
            <span>Tên đường :</span>
            <input type="text" name="street" required placeholder="Nhập tên đường">
         </div>
         <div class="inputBox">
            <span>Thành phố :</span>
            <input type="text" name="city" required placeholder="Nhập tên thành phố">
         </div>
         <div class="inputBox">
            <span>Tỉnh :</span>
            <input type="text" name="province" required placeholder="Nhập tên tỉnh">
         </div>
         <div class="inputBox">
            <span>Quốc gia :</span>
            <input type="text" name="country" required placeholder="Nhập quốc gia">
         </div>
         <div class="inputBox">
            <span>Mã vùng :</span>
            <input type="number" min="0" name="zip_code" required placeholder="Nhập mã vùng">
         </div>
      </div>
      <input type="submit" value="Đặt hàng" class="btn" name="order_btn">
   </form>

</section>









<?php include 'footer.php'; ?>

<!-- chèn file js  -->
<script src="js/script.js"></script>

</body>
</html>