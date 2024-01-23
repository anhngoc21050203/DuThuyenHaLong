<?php
// Kiểm tra xem người dùng đã đăng nhập chưa
session_start();

if (!isset($_SESSION['username'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang login
    echo '<script>window.location.href = "pages-login.php";</script>';
    exit;
}
?>