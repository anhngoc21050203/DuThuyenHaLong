<?php
  include 'pages/header.php';
  include 'dao/nguoidung.php';
  include 'pages/h.php';

  $nguoidung = new nguoidung();
  $role_list = $nguoidung->show_nguoi_dung_role();
  if(isset($_POST['save'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role_id = $_POST['role_id'];
    if($username != null && $password != null){
      $add_list = $nguoidung->insert_nguoi_dung($username, $password, $email, $phone, $role_id);
    }
  }

?>
<?php
  if( $_SESSION['role_id'] != 1 &&  $_SESSION['role_id'] != 3){
    echo '<script>window.location.href = "index.php";</script>';
  }
?>

<body>
  <?php
    include 'pages/menu.php'
  ?>


<main id="main" class="main">

<div class="pagetitle">
  <h1>Thêm người dùng</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
      <li class="breadcrumb-item">Forms</li>
      <li class="breadcrumb-item active">Thêm người dùng</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
              <form class="row g-3" style="margin-top: 10px;" action="nguoi-dung-add.php" method="post">
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Tên người dùng</label>
                  <input type="text" class="form-control" id="inputNanme4" name="username">
                </div>
                <div class="col-12">
                  <label for="inputEmail4" class="form-label">Email</label>
                  <input type="email" class="form-control" id="inputEmail4" name="email">
                </div>
                <div class="col-12">
                  <label for="inputEmail4" class="form-label">Số điện thoại</label>
                  <input type="text" class="form-control" id="inputEmail4" name="phone">
                </div>

                <div class="col-12">
                    <label for="yourPassword" class="form-label">Mật khẩu</label>
                    <div class="password-container">
                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                        <i class="ri-eye-line" id="togglePasswordIcon" onclick="togglePassword()"></i>
                    </div>
                </div>
                <div class="col-12">
                  <label for="inputState" class="form-label">Vai trò</label>
                  <select id="inputState" class="form-select" name="role_id" >
                  <?php
                    if ($role_list) {
                        foreach ($role_list as $cate) {
                            echo '<option value="' . $cate['id'] . '">' . $cate['namerl'] . '</option>';
                        }
                    }
                    ?>
                  </select>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="save">Thêm mới </button>
                  <button type="reset" class="btn btn-secondary">Hủy</button>
                </div>
              </form><!-- Vertical Form -->

            </div>
          </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php
    include 'pages/footer.php';
    ?>
    
</body>

</html>