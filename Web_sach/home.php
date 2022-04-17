<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}
//Thêm sản phẩm vào giỏ hàng
if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'Sản phẩm này đã có trong giỏ hàng!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'Sản phẩm đã được thêm vào giỏ hàng!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- Chèn link font-awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Chèn link css  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">



   <div class="content">
      <h3>Stories, ideas, and knowledge that will change your life forever.</h3>
      <p>Web_sach là một cửa hàng sách trực tuyến nơi mà mọi khách hàng có thể mua những đầu sách thuộc mọi thể loại khác nhau như: Kỳ ảo, Kinh dị,...</p>
      <a href="about.php" class="white-btn">Khám phá</a>
   </div>

</section>

<section class="products">



   <h1 class="title">Sản Phẩm mới nhất</h1>

   <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price"><?php echo $fetch_products['price']; ?> vnd</div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="Thêm vào giỏ hàng" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">Chưa có sản phẩm nào được thêm!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">Xem thêm</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>Thông tin cửa hàng </h3>
         <p>Web_sach là một cửa hàng sách trực tuyến nơi mà mọi khách hàng có thể mua những đầu sách thuộc mọi thể loại khác nhau như: Kỳ ảo, Kinh dị,...</p>
         <a href="about.php" class="btn">Đọc thêm</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>Nếu có gì thắc mắc?</h3>
      <p></p>
      <a href="contact.php" class="white-btn">Liên hệ với chúng tôi ngay</a>
   </div>

</section>





<?php include 'footer.php'; ?>

<!-- chèn link js  -->
<script src="js/script.js"></script>

</body>
</html>