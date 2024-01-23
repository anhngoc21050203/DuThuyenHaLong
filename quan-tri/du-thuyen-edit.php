<?php
  include 'pages/header.php';
  include 'dao/duthuyen.php';
  include 'pages/h.php';

  $duthuyen = new duthuyen();
  $cate_list = $duthuyen->show_du_thuyen_cate();
  $point_list = $duthuyen->show_du_thuyen_point();
  if(isset($_GET['id'])){
    $id_dt = $_GET['id'];
    $duthuyen_get = $duthuyen->get_duthuyen($id_dt);
    $cate_list_cheked = $duthuyen->get_duthuyen_cate($id_dt);
    $point_list_cheked= $duthuyen->get_duthuyen_point($id_dt);
    $cate_list_t_cheked = $duthuyen->get_duthuyen_cate_t($id_dt);
    $cate_list_cheked_old = [];
    $cate_list_t_cheked_old = [];
    $point_list_cheked_old = [];
    if (!empty($cate_list_cheked)) {
      while ($row = $cate_list_cheked->fetch_assoc()) {
        $cate_list_cheked_old[] = $row['cate_id'];
      }
    }
    var_dump($cate_list_t_cheked);

  // Check if $point_list_cheked is not empty before entering the loop
  if (!empty($point_list_cheked)) {
      while ($row = $point_list_cheked->fetch_assoc()) {
          $point_list_cheked_old[] = $row['point_id'];
      }
  }
  if (!empty($cate_list_t_cheked)) {
    while ($row = $cate_list_t_cheked->fetch_assoc()) {
        $cate_list_t_cheked_old[] = $row['cate_id'];
    }
}
  }
  if($duthuyen_get){
    $result = $duthuyen_get ->fetch_assoc();
  }
  if(isset($_POST['update'])){
    $namedt = $_POST['namedt'];
    $seoname = $_POST['seoname'];
    $seodescription = $_POST['seodescription'];
    $content = $_POST['editorContent'];
    $year = $_POST['year'];
    $category_ids = isset($_POST['categories']) ? $_POST['categories'] : array();
    $point_ids = isset($_POST['points']) ? $_POST['points'] : array();
    $tour_ids = isset($_POST['tours'])? $_POST['tours'] : array();
    $price = $_POST['price'];
    $createdby = $_SESSION['username'];
    $price_sales = $_POST['price_sales'];
    $id = $_POST['idh'];
    $thumbnail = $_FILES['thumbnail']['name'];
    $target_directory = "upload/"; // Thư mục lưu trữ ảnh
    
    // Kiểm tra xem có tệp đã được chọn hay không
    if (!empty($_FILES['thumbnail']['tmp_name'])) {
        $target_file = $target_directory . basename($thumbnail);
    
        // Kiểm tra xem tệp đã tồn tại chưa
        if (file_exists($target_file)) {
            echo "Tệp đã tồn tại.";
        } else {
            // Di chuyển ảnh mới vào thư mục lưu trữ
            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target_file)) {
                echo "Ảnh mới đã được tải lên thành công.";
            } else {
                echo "Có lỗi khi tải lên ảnh mới.";
            }
        }
    } else {
        // Nếu không có ảnh mới, giữ lại ảnh cũ
        $thumbnail = $_POST['old_thumbnail']; // Thay thế $old_thumbnail_path bằng đường dẫn tới ảnh cũ trong cơ sở dữ liệu của bạn
    } 
    if($category_ids && $point_ids && $tour_ids){
      $update = $duthuyen->update_du_thuyen($namedt, $seoname, $seodescription, $thumbnail, $content, $year, $price, $price_sales, $createdby, $id, $category_ids, $point_ids, $tour_ids);
    }
  }

?>

<body>
  <?php
    include 'pages/menu.php'
  ?>


<main id="main" class="main">

<div class="pagetitle">
  <h1>Cập nhật thông tin du thuyền</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
      <li class="breadcrumb-item">Forms</li>
      <li class="breadcrumb-item active">Cập nhật thông tin</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
            <form class="row g-3" style="margin-top: 10px;" action="du-thuyen-edit.php" method="post" enctype="multipart/form-data">
                <div class="col-md-6">
                  <label for="inputName5" class="form-label">Tên du thuyền</label>
                  <input type="text" class="form-control" id="inputName5" name="namedt" value="<?php echo $result['namedt'] ?>">
                </div>
                <div class="col-md-6">
                  <label for="inputName5" class="form-label">Seo du thuyền</label>
                  <input type="text" class="form-control" id="inputName5" name="seoname" value="<?php echo $result['seoname'] ?>">
                </div>
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">Seo Description*</label>
                  <textarea class="form-control" name="seodescription" ><?php echo $result['seodescription'] ?></textarea>
                </div>
                <div class="col-md-6">
                  <label for="inputNumber" class="form-label">File Upload</label>
                  <div class="col-sm-12">
                    <input class="form-control" type="file" name="thumbnail" id="thumbnailInput" onchange="displayImage()">
                    <img id="thumbnailPreview" src="" style="max-width: 100%; max-height: 200px; margin-top: 10px;" alt="Ảnh mới">
                    <img style="max-width: 100%; max-height: 200px; margin-top: 10px;" src="./upload/<?php echo $result['thumbnail']; ?>" alt="Ảnh cũ">
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="inputAddress5" class="form-label">Năm ra mắt</label>
                  <select class="form-select" id="inputAddress5" name="year" >
                    <?php
                    // Tạo danh sách năm từ 2000 đến 2023
                    for ($year = 2000; $year <= 2023; $year++) {
                        $selected = ($year == $result['year']) ? 'selected' : ''; // Kiểm tra xem có phải là giá trị cũ không
                        echo '<option value="' . $year . '" ' . $selected . '>' . $year . '</option>';
                    }
                    ?>
                  </select>
              </div>
                <div class="col-md-6">
                  <label for="inputAddress2" class="form-label">Giá</label>
                  <input type="text" class="form-control" id="inputAddress2" name="price" value="<?php echo $result['price'] ?>">
                </div>
                <div class="col-md-6">
                  <label for="inputCity" class="form-label">Giá giảm</label>
                  <input type="text" class="form-control" id="inputCity" name="price_sales" value="<?php echo $result['price_sales'] ?>">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Danh mục</label>
                  <?php
                  // $category_list là mảng danh sách danh mục từ dữ liệu của bạn
                  if ($cate_list) {
                      foreach ($cate_list as $category) {
                        if($category['parent_id']==0){
                          echo '<div class="form-check">';
                          echo '<input class="form-check-input" type="checkbox" name="categories[]" value="' . $category['id'] . '"';
                          
                          if(!empty($cate_list_cheked_old)){
                            if (in_array($category['id'], $cate_list_cheked_old)) {
                                echo 'checked';
                            }
                          }else{
                            echo '';
                          }
                          echo '>';
                          echo '<label class="form-check-label">' . $category['namecate'] . '</label>';
                          echo '</div>';
                        }
                      }
                  }
                  ?>
              </div>
              <div class="col-md-6">
                  <label class="form-label">Điểm đến</label>
                  <?php
                  // $category_list là mảng danh sách danh mục từ dữ liệu của bạn
                  if ($point_list ) {
                      foreach ($point_list  as $poi) {
                          echo '<div class="form-check">';
                          echo '<input class="form-check-input" type="checkbox" name="points[]" value="' . $poi['id'] . '"';
                          if(!empty($point_list_cheked_old)){
                            if (in_array($poi['id'], $point_list_cheked_old)) {
                              echo 'checked';
                            }
                          }else{
                            echo '';
                          }
                          echo '>';
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
                      if($category['parent_id']!=0){
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="checkbox" name="tours[]" value="' . $category['id'] . '"';                        
                        if(!empty($cate_list_t_cheked_old)){
                          if (in_array($category['id'], $cate_list_t_cheked_old)) {
                              echo 'checked';
                          }
                        }else{
                          echo '';
                        }
                        echo '>';
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
                <input type="hidden" name="old_thumbnail" value="<?php echo $result['thumbnail'] ?>">
                <input type="hidden" name="idh" value="<?php echo $result['id'] ?>">
                <input type="hidden" id="editorContent" name="editorContent">
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="update">Lưu thay đổi</button>
                  <button type="reset" class="btn btn-secondary">Hủy</button>
                </div>
              </form><!-- End Multi Columns Form -->
            </div>
          </div>
        </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php
    include 'pages/footer.php';
    ?>
    <script>
        const contentFromDatabase = <?php echo json_encode($contentFromDatabase = $result['content']); ?>;
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
    quill.clipboard.dangerouslyPasteHTML(contentFromDatabase);
    // Add a custom Button to the Quill Editor's toolbar:
    document.querySelector('form').onsubmit = function() {
    var editorContent = quill.root.innerHTML; // Lấy nội dung HTML của Quill
    document.getElementById('editorContent').value = editorContent; // Gán nội dung vào hidden input
  };
 </script>
</body>

</html>