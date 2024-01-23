<?php
  include 'pages/header.php';
  include 'pages/h.php';
  include 'dao/duthuyen.php';

  $duthuyen = new duthuyen();
  $duthuyen_list = $duthuyen->show_du_thuyen();

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
  <h1>Danh sách du thuyền</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
      <li class="breadcrumb-item">Bảng</li>
      <li class="breadcrumb-item active">Dữ liệu du thuyền</li>
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
                  Tên Du thuyền
                </th>
                <th>Seo</th>
                <th>Seo description</th>
                <th>Ảnh đại diện</th>
                <th>Nội dung</th>
                <th>Năm ra mắt</th>
                <th>Giá</th>
                <th>Giá sales</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $dem = 1;
                if($duthuyen_list){
                  foreach($duthuyen_list as $dt){
                    echo '
                    <tr>
                      <td>'.$dem.'</td>
                      <td>'.$dt['namedt'].'</td>
                      <td>'.$dt['seoname'].'</td>
                      <td>'.$dt['seodescription'].'</td>
                      <td><img style="width: 70px;" src="./upload/' . $dt['thumbnail'] . '" alt="Thumbnail"></td>
                      <td>'.$dt['content'].'</td>
                      <td>'.$dt['year'].'</td>
                      <td>'.$dt['price'].'</td>
                      <td>'.$dt['price_sales'].'</td>
                      <td class="text-right">
                          <div class="dropdown dropdown-action">
                              <a href="#" class="action-icon dropdown-toggle" role="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                  <i class="ri-layout-grid-fill"></i>
                              </a>
                              <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                  <li><a class="dropdown-item" href="du-thuyen-edit.php?id='.$dt['id'].'"><i class="ri-ball-pen-line"></i>  Sửa</a></li>
                                  <li><a class="dropdown-item" href="#"><i class="ri-gift-fill"></i>  Thêm ưu đãi</a></li>
                                  <li><a class="dropdown-item" href="#"><i class="ri-customer-service-2-line"></i>  Thêm dịch vụ</a></li>
                                  <li><a class="dropdown-item delete-btn" data-bs-toggle="modal" data-bs-target="#verticalycentered" data-id="'. $dt['id'].'"><i class="ri-delete-bin-2-fill"></i>  Xóa</a></li>
                                  </ul>
                          </div>
                      </td>
                    </tr>
                    ';
                    $dem++;
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
        window.location.href ="du-thuyen-delete.php?id=" +id;
    });
});


  </script>

</body>

</html>
