<?php
  include 'pages/header.php';
  include 'dao/duthuyen.php';
  include 'pages/h.php';

  $duthuyen = new duthuyen();
  $cate_list = $duthuyen->show_du_thuyen_cate();
  $point_list = $duthuyen->show_du_thuyen_point();
  if(isset($_POST['adddt'])){
    $namedt = $_POST['namedt'];
    $seoname = $_POST['seoname'];
    $seodescription = $_POST['seodescription'];
    $title_th = $_POST['title_th'];
    $alt_text = $_POST['alt_text'];
    $description_th = $_POST['description_th'];
    $caption_th = $_POST['caption_th'];
    $content = $_POST['editorContent'];
    $year = $_POST['year'];
    $category_ids = isset($_POST['categories']) ? $_POST['categories'] : array();
    $point_ids = isset($_POST['points']) ? $_POST['points'] : array();
    $tour_ids = isset($_POST['tours'])? $_POST['tours'] : array();
    $price = $_POST['price'];
    $createdby = $_SESSION['username'];
    $price_sales = $_POST['price_sales'];
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
    if(!empty($category_ids) && !empty($point_ids) && !empty($tour_ids)){
      $add_list = $duthuyen->insert_du_thuyen($namedt, $seoname, $seodescription, $title_th, $alt_text, $description_th, $thumbnail, $caption_th, $content, $year, $price, $price_sales, $createdby, $category_ids, $point_ids, $tour_ids);
    }
  }

?>
<?php
  if( $_SESSION['role_id'] != 1 &&  $_SESSION['role_id'] != 2){
    echo '<script>window.location.href = "index.php";</script>';
  }
?>

<body>
  <?php
    include 'pages/menu.php'
  ?>


<main id="main" class="main">

<div class="pagetitle">
  <h1>Thêm du thuyền</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
      <li class="breadcrumb-item">Forms</li>
      <li class="breadcrumb-item active">Thêm du thuyền</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
              <form class="row g-3" style="margin-top: 10px;" action="du-thuyen-add.php" method="post" enctype="multipart/form-data">
                <div class="col-md-6">
                  <label for="inputName9" class="form-label">Tên du thuyền</label>
                  <input type="text" class="form-control" id="inputName9" name="namedt">
                </div>
                <div class="col-md-6">
                  <label for="inputNam5" class="form-label">Seo du thuyền</label>
                  <input type="text" class="form-control" id="inputNam5" name="seoname">
                </div>
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">Seo Description*</label>
                  <textarea class="form-control" name="seodescription"></textarea>
                </div>
                <div class="col-md-6">
                  <label for="inputNme5" class="form-label">Tiêu đề ảnh</label>
                  <input type="text" class="form-control" id="inputNme5" name="title_th">
                </div>
                <div class="col-md-6">
                  <label for="inputName5" class="form-label">Văn bản thay thế ảnh</label>
                  <input type="text" class="form-control" id="inputName5" name="alt_text">
                </div>
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">Mô tả ảnh</label>
                  <textarea class="form-control" name="description_th"></textarea>
                </div>
                <div class="col-md-12">
                  <label for="inputNumber" class="form-label">Ảnh đại diện</label>
                  <div class="col-sm-12">
                    <input class="form-control" type="file" name="thumbnail" id="thumbnailInput" onchange="displayImage()">
                    <img id="thumbnailPreview" src="" style="max-width: 100%; max-height: 200px; margin-top: 10px;">
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="inputame5" class="form-label">Caption</label>
                  <input type="text" class="form-control" id="inputame5" name="caption_th">
                </div>
                <div class="col-md-6">
                  <label for="inputAddress5" class="form-label">Năm ra mắt</label>
                  <select class="form-select" id="inputAddress5" name="year">
                      <?php
                      // Tạo danh sách năm từ 2000 đến 2023
                      for ($year = 2000; $year <= 2023; $year++) {
                          echo '<option value="' . $year . '">' . $year . '</option>';
                      }
                      ?>
                  </select>
              </div>
                <div class="col-md-6">
                  <label for="inputAddress2" class="form-label">Giá</label>
                  <input type="text" class="form-control" id="inputAddress2" name="price">
                </div>
                <div class="col-md-6">
                  <label for="inputCity" class="form-label">Giá giảm</label>
                  <input type="text" class="form-control" id="inputCity" name="price_sales">
                </div>
                <div class="col-md-6">
                  <div class="alert alert-warning" role="alert" style="display: none;" id="errorAlert">Hãy chọn ít nhất 1 trường</div>
                  <label class="form-label">Danh mục/ </label><a href="pocess.html"><i class="ri-add-circle-line"></i>Thêm danh mục</a>
                  <?php
                  // $category_list là mảng danh sách danh mục từ dữ liệu của bạn

                  if ($cate_list) {
                      foreach ($cate_list as $category) {
                        if($category['parent_id'] == 0){
                          echo '<div class="form-check">';
                          echo '<input class="form-check-input" type="checkbox" name="categories[]" value="' . $category['id'] . '" >';
                          echo '<label class="form-check-label">' . $category['namecate'] . '</label>';
                          echo '</div>';
                        }
                      }
                  }
                  ?>
              </div>
              <div class="col-md-6">
                  <label class="form-label">Điểm đến/ </label><a href="pocess.html"><i class="ri-add-circle-line"></i>Thêm điểm đến</a>
                  <?php
                  // $category_list là mảng danh sách danh mục từ dữ liệu của bạn
                  if ($point_list ) {
                      foreach ($point_list  as $poi) {
                          echo '<div class="form-check">';
                          echo '<input class="form-check-input" type="checkbox" name="points[]" value="' . $poi['id'] . '" >';
                          echo '<label class="form-check-label">' . $poi['namep'] . '</label>';
                          echo '</div>';
                      }
                  }
                  ?>
              </div>
              <div class="col-md-6">
                  <label class="form-label">Tour/ </label><a href="pocess.html"><i class="ri-add-circle-line"></i>Thêm tour</a>
                  <?php
                  if ($cate_list) {
                      foreach ($cate_list as $category) {
                        if($category['parent_id'] != 0){
                          echo '<div class="form-check">';
                          echo '<input class="form-check-input" type="checkbox" name="tours[]" value="' . $category['id'] . '" >';
                          echo '<label class="form-check-label">' . $category['namecate'] . '</label>';
                          echo '</div>';
                        }
                      }
                  }
                  ?>
              </div><div class="col-md-6">
                  <label class="form-label">Dịch vụ/ </label><a href="pocess.html"><i class="ri-add-circle-line"></i>Thêm dịch vụ</a>
                  <?php
                  // $category_list là mảng danh sách danh mục từ dữ liệu của bạn
                  // if ($cate_list) {
                  //     foreach ($cate_list as $category) {
                  //         echo '<div class="form-check">';
                  //         echo '<input class="form-check-input" type="checkbox" name="categories[]" value="' . $category['id'] . '">';
                  //         echo '<label class="form-check-label">' . $category['namecate'] . '</label>';
                  //         echo '</div>';
                  //     }
                  // }
                  ?>
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
                  <button type="submit" class="btn btn-primary" name="adddt">Thêm mới</button>
                  <button type="reset" class="btn btn-secondary">Hủy</button>
                </div>
              </form><!-- End Multi Columns Form -->
            </div>
          </div>
        </div>
    </section>

  </main><!-- End #main -->
  <div class="modal fade" id="verticalycentered" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Thêm danh mục</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

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
                    ['link', 'image', 'video'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'script': 'sub' }, { 'script': 'super' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],

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