<?php
  include 'pages/header.php';
  include 'dao/nguoidung.php';
  $nguoidung = new nguoidung();

  $error_message = ''; // Khởi tạo biến error_message

  if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra xem username và password có tồn tại không
    if(!empty($username) && !empty($password)){
        // Gọi hàm login từ đối tượng nguoidung
        $result = $nguoidung->login($username, $password);

        // Kiểm tra trạng thái đăng nhập
        switch($result['status']){
          case 1:
            // Đăng nhập thành công, lưu thông tin vào session và chuyển hướng
            session_start(); // Khởi động phiên session
        
            // Lưu thông tin người dùng vào session
            $_SESSION['user_id'] = $result['user']['id']; // Giả sử id của người dùng lưu trong trường 'id'
            $_SESSION['username'] = $result['user']['username']; // Giả sử id của người dùng lưu trong trường 'id'
            $_SESSION['role_id'] = $result['user']['role_id']; // Giả sử id của người dùng lưu trong trường 'id'


            // Chuyển hướng đến trang dashboard
           
            if($result['user']['role_id'] < 5){
              echo '<script>window.location.href = "index.php";</script>';
            }else{
              header('Location: /trang-chu');
            }
            exit;
            break;
        
            case 2:
                // Sai mật khẩu
                $error_message = "Sai mật khẩu";
                $alert = "alert-warning";
                break;
            case 3:
                // Không tìm thấy người dùng với username đã nhập
                $error_message = "Không tìm thấy người dùng";
                $alert = "alert-danger";
                break;
        }
    } else {
        // Thông báo lỗi nếu username hoặc password trống
        $error_message = "Vui lòng nhập đầy đủ thông tin đăng nhập";
    }
  }
?>
<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.php" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/z4844540580064_6e9388c04ddf3d7999017066712f7a95-removebg-preview copy.png" alt="">
                  <span class="d-none d-lg-block">Quản trị du thuyền</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Đăng nhập vào hệ thống</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>
                  <?php if (!empty($error_message)) : ?>
                    <div class="alert <?php echo $alert ?>" role="alert">
                      <?php echo $error_message; ?>
                    </div>
                  <?php endif; ?>

                  <form class="row g-3 needs-validation" action="pages-login.php" method="post" autocomplete="">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <div class="password-container">
                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                        <i class="ri-eye-line" id="togglePasswordIcon" onclick="togglePassword()"></i>
                      </div>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="login">Đăng nhập</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Bạn chưa có tài khoản <a href="#">Đang kí ngay</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by BootstrapMade
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <?php
  include 'pages/footer.php'
?>

</body>

</html>