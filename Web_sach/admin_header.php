<!-- Tạo header cho trang admin -->
<!-- Tạo message thông báo -->
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="flex">
      <!-- Tạo logo trang admin -->
      <a href="admin_page.php" class="logo">Trang<span>Admin</span></a>

      <!-- Tạo menu trang admin -->
      <nav class="navbar">
         <a href="admin_page.php">Trang Chủ</a>
         <a href="admin_products.php">Sản Phẩm</a>
         <a href="admin_orders.php">Đơn Đặt Hàng</a>
         <a href="admin_users.php">Khách Hàng</a>
         <a href="admin_contacts.php">Tin Nhắn</a>
      </nav>

      <!-- Tạo icon thanh menu và tài khoản trang admin -->
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <!-- Tạo box tài khoản trang admin -->
      <div class="account-box">
         <p>username : <span><?php echo $_SESSION['admin_name']; ?></span></p>
         <p>email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
         <a href="logout.php" class="delete-btn">Đăng Xuất</a>
         <div><a href="login.php">Đăng nhập</a> | <a href="register.php">Đăng ký</a> mới</div>
      </div>

   </div>

</header>