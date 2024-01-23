<?php
session_start();

// Xóa tất cả các biến session
session_unset();

// Hủy session
session_destroy();

// Chuyển hướng về trang đăng nhập (hoặc trang chính)
header("Location: ../trang-chu/index.html");
exit;
?>