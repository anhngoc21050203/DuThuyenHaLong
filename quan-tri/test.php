<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modal Example</title>
  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
  <?php
include 'dao/duthuyen.php';

  $duthuyen = new duthuyen();
  $cate_list = $duthuyen->show_du_thuyen_cate();
  $point_list = $duthuyen->show_du_thuyen_point();

  ?>

<script>
        function validateForm() {
            // Lấy tất cả các checkbox trong form
            var checkboxes = document.getElementsByName('categories[]');

            // Kiểm tra xem ít nhất một checkbox đã được chọn chưa
            var atLeastOneChecked = false;
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    atLeastOneChecked = true;
                    break;
                }
            }

            // Hiển thị thông báo lỗi nếu không có checkbox nào được chọn
            if (!atLeastOneChecked) {
                document.getElementById('errorAlert').style.display = 'block';
                return false; // Ngăn chặn việc gửi form
            }

            return true; // Cho phép gửi form nếu ít nhất một checkbox đã được chọn
        }
    </script>
</head>
<body>

<form class="row g-3" style="margin-top: 10px;" method="post" enctype="multipart/form-data" action="du-thuyen-add.php" onsubmit="return validateForm();">
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
</form>

</body>
</html>




</body>
</html>
