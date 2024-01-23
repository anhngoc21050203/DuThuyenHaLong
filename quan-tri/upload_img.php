<?php
  include 'dao/blog.php';
// Xử lý upload ảnh và lưu vào database
$uploadedFile = $_FILES['image'];
$uploadDir = 'upload/'; // Thư mục lưu trữ ảnh
$uploadPath = $uploadDir . $uploadedFile['name'];
move_uploaded_file($uploadedFile['tmp_name'], $uploadPath);

// Lưu đường dẫn vào database (sử dụng hàm insert_path_im của bạn)
$blog = new blog();
$img_path = $blog->insert_path_im($uploadPath);

// Trả lại đường dẫn ảnh
echo json_encode(['url' => $img_path]);
?>
