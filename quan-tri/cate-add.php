<?php
  include 'pages/header.php';
  include 'dao/category.php';
  include 'pages/h.php';

  $category = new category();
  if(isset($_GET['idc'])&& isset($_GET['namecatec'])){
    $id_cate = $_GET['idc'];
    $namec = $_GET['namecatec'];
    $addc = $category->insert_cate_c($id_cate, $namec);
  }
  if(isset($_POST['save'])){
    $username = $_POST['namecate'];
    $content = $_POST['editorContent'];
    $thumbnail = $_FILES['thumbnail']['name'];
    $target_directory = "upload/"; // Thư mục lưu trữ ảnh
    $target_file = $target_directory . basename($thumbnail);

    // Kiểm tra xem tệp đã tồn tại chưa
    if (file_exists($target_file)) {
        echo "Tệp đã tồn tại.";
    } else {
        // Di chuyển ảnh vào thư mục lưu trữ
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target_file)) {
            echo "Ảnh đã được tải lên thành công.";
        } else {
            echo "Có lỗi khi tải lên ảnh.";
        }
    }

    if($username != null ){
      $add_list = $category->insert_cate($username, $thumbnail, $content);
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
  <h1>Thêm danh mục</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
      <li class="breadcrumb-item">Forms</li>
      <li class="breadcrumb-item active">Thêm danh mục</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
              <form class="row g-3" style="margin-top: 10px;" action="cate-add.php" method="post" enctype="multipart/form-data">
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Tên danh mục</label>
                  <input type="text" class="form-control" id="inputNanme4" name="namecate">
                </div>
                <div class="col-md-12">
                  <label for="inputNumber" class="form-label">File Upload</label>
                  <div class="col-sm-12">
                    <input class="form-control" type="file" name="thumbnail" id="thumbnailInput" onchange="displayImage()">
                    <img id="thumbnailPreview" src="" style="max-width: 100%; max-height: 200px; margin-top: 10px;">
                  </div>
                </div>
                <div class="con-md-12">
                  <div class="">
                    <h5 class="card-title">Nội dung</h5>
                    <!-- Quill Editor Full -->
                    <div id="editor">
                      <p>Lưu ý nên copy từ word</p>
                    </div>
                    <!-- End Quill Editor Full -->
                  </div>
                </div>
                <input type="hidden" id="editorContent" name="editorContent">
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
    <script>
        const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: {
                container: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],

                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'script': 'sub' }, { 'script': 'super' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],

                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['clean'],
                ]
            }
        }
    })

    // Add a custom Button to the Quill Editor's toolbar:
    document.querySelector('form').onsubmit = function() {
    var editorContent = quill.root.innerHTML; // Lấy nội dung HTML của Quill
    document.getElementById('editorContent').value = editorContent; // Gán nội dung vào hidden input
  };
 </script>
    
</body>

</html>