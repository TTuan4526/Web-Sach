<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}
//code cập nhật tình trạng đơn đặt hàng
if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'Tình trạng thanh toán đã được cập nhật!';

}

//code xóa sản phẩm
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- chèn link font awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- chèn link file css  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">Đơn Đặt Hàng</h1>

   <div class="box-container">
      <?php
      //lấy dữ liệu trong orders
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <!-- Thông tin đơn đặt hàng -->
      <div class="box">
         <p> Mã khách hàng : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> Thời gian đặt hàng : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> Họ Tên : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> SĐT : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Địa chỉ : <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> Tổng số sản phẩm : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Tổng giá : <span><?php echo $fetch_orders['total_price']; ?> vnd</span> </p>
         <p> Phương thức thanh toán : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="pending">Đang chờ</option>
               <option value="completed">Đã xử lý</option>
            </select>
            <input type="submit" value="Cập nhật" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Có chắc chắn xóa đơn hàng này?');" class="delete-btn">Xóa</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">Chưa có đơn đặt hàng nào!</p>';
      }
      ?>
   </div>

</section>










<!-- chèn link file js tự tạo cho trang admin -->
<script src="js/admin_script.js"></script>

</body>
</html>