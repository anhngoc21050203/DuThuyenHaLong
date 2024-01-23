<?php
  include 'pages/header.php';
  include 'pages/h.php';
  include 'dao/category.php';

  $category = new category();
  $category_list = $category->show_cate();

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
  <h1>Danh sách danh mục</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
      <li class="breadcrumb-item">Bảng</li>
      <li class="breadcrumb-item active">Dữ liệu danh mục</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <!-- Table with stripped rows -->
          <table class="table datatable table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>
                  Tên danh mục
                </th>
                <th>Ảnh đại diện</th>
                <th>Mổ tả</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $dem = 1;
                if($category_list){
                  foreach($category_list as $dt){
                    if($dt['parent_id'] == 0){
                      echo '
                      <tr>
                        <td>'.$dem.'</td>
                        <td>'.$dt['namecate'].'</td>
                        <td><img style="width: 70px;" src="./upload/' . $dt['thumbnail'] . '" alt="Thumbnail"></td>
                        <td>'.$dt['content'].'</td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" role="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-layout-grid-fill"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="cate_edit.php?id='.$dt['id'].'"><i class="ri-ball-pen-line"></i>  Sửa</a></li>
                                    <li><a class="dropdown-item add-cate-btn" href="#" data-bs-toggle="modal" data-bs-target="#addcatecon" data-id="'.$dt['id'].'"><i class="ri-ball-pen-line"></i>Thêm danh mục con</a></li>
                                    <li><a class="dropdown-item delete-btn" data-bs-toggle="modal" data-bs-target="#verticalycentered" data-id="'. $dt['id'].'"><i class="ri-delete-bin-2-fill"></i>  Xóa</a></li>
                                    </ul>
                            </div>
                        </td>
                      </tr>
                      ';
                      $dem++;
                    }
                  }
                }
              ?>
            </tbody>
          </table>
          <!--Modal xác nhận xóa-->
          <div class="modal fade" id="verticalycentered" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Xác nhận</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <p id="">Bạn có chắc chắn muốn xóa không?</p>
                  </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="deleteConfirmBtn">Xác nhận</button>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </section>
    <div class="pagetitle">
  <h1>Danh sách danh mục con</h1>
    </div>
    <section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <!-- Table with stripped rows -->
          <table class="table datatable table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>
                  Tên danh mục
                </th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $dem = 1;
                if($category_list){
                  foreach($category_list as $dt){
                    if($dt['parent_id'] != 0){
                      echo '
                      <tr>
                        <td>'.$dem.'</td>
                        <td>'.$dt['namecate'].'</td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" role="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-layout-grid-fill"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="cate_edit.php?id='.$dt['id'].'"><i class="ri-ball-pen-line"></i>  Sửa</a></li>
                                    <li><a class="dropdown-item delete-btn" data-bs-toggle="modal" data-bs-target="#verticalycentered" data-id="'. $dt['id'].'"><i class="ri-delete-bin-2-fill"></i>  Xóa</a></li>
                                    </ul>
                            </div>
                        </td>
                      </tr>
                      ';
                      $dem++;
                    }
                  }
                }
              ?>
            </tbody>
          </table>
          <!--Modal xác nhận xóa-->
        </div>
      </div>
    </section>
    <div class="modal fade" id="addcatecon" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Thêm danh mục con</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="dmcon">Tên danh mục con</label>
            <input type="text" class="form-control" id="dmcon" name="namecatec">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" id="add-cate">Xác nhận</button>
      </div>
    </div>
  </div>
</div>


</main>
<?php
    include 'pages/footer.php'
  ?>
  <script>
    // Đoạn mã JavaScript
    document.addEventListener('DOMContentLoaded', function () {
        // Lấy danh sách tất cả các nút "Xóa" có class "delete-btn"
        var deleteButtons = document.querySelectorAll('.delete-btn');

        // Lặp qua từng nút và thêm sự kiện click
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                // Lấy id từ thuộc tính data-id của nút "Xóa"
                var id = this.getAttribute('data-id');
                
                // Gán id vào thuộc tính data-id của nút "Xác nhận"
                document.getElementById('deleteConfirmBtn').setAttribute('data-id', id);
            });
        });

        // Thêm sự kiện click cho nút "Xác nhận" trong modal
        document.getElementById('deleteConfirmBtn').addEventListener('click', function () {
            // Lấy id từ thuộc tính data-id của nút "Xác nhận"
            var id = this.getAttribute('data-id');

            // Thực hiện xóa bằng cách gửi id đến server hoặc xử lý xóa theo nhu cầu của bạn
            // Ví dụ: Gửi yêu cầu Ajax đến server để xóa dữ liệu với id được truyền
            // Gọi hàm xóa với id
            window.location.href ="cate_delete.php?id=" +id;
        });
    });
  </script>
  <script>
document.addEventListener('DOMContentLoaded', function () {
    // Khai báo biến namecatecValue ở mức độ toàn cục
    var namecatecValue;

    // Lấy danh sách tất cả các nút "Thêm danh mục" có class "add-cate-btn"
    var addCateButtons = document.querySelectorAll('.add-cate-btn');

    // Lặp qua từng nút và thêm sự kiện click
    addCateButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            // Lấy id từ thuộc tính data-id của nút "Thêm danh mục"
            var id = this.getAttribute('data-id');
            
            // Gán id vào thuộc tính data-id của nút "Xác nhận thêm danh mục"
            document.getElementById('add-cate').setAttribute('data-id', id);
        });
    });

    // Thêm sự kiện click cho nút "Xác nhận thêm danh mục" trong modal
    document.getElementById('add-cate').addEventListener('click', function () {
        // Lấy id từ thuộc tính data-id của nút "Xác nhận thêm danh mục"
        var id = this.getAttribute('data-id');

        // Lấy giá trị từ trường input có id là "dmcon"
        namecatecValue = $("#dmcon").val();

        // Chuyển hướng trang với tham số idc và namecatec
        window.location.href = "cate-add.php?idc=" + id + "&namecatec=" + namecatecValue;
    });
});

  </script>

</body>

</html>
