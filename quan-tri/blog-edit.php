<?php
  include 'pages/header.php';
  include 'dao/blog.php';
  include 'pages/h.php';

  $blog = new blog();

  if(isset($_GET['id'])){
    $id_blog = $_GET['id'];
    $edit = $blog->get_blog($id_blog);
  }
  if($id_blog){
    $rs = $edit->fetch_assoc();
  }

  if(isset($_POST['adddt'])){
    $tittle = $_POST['tittle'];
    $seoname = $_POST['seoname'];
    $seodescription = $_POST['seodescription'];
    $title_th = $_POST['title_th'];
    $alt_text = $_POST['alt_text'];
    $description_th = $_POST['description_th'];
    $content = $_POST['editorContent'];
    $caption_th = $_POST['caption_th'];
    $createdby = $_SESSION['username'];
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
    if($tittle != null){
      $add_list = $blog->update_blog($tittle, $seoname, $seodescription, $title_th, $alt_text, $description_th, $thumbnail, $caption_th, $content, $createdby, $id);
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
  <h1>Thêm tin tức- bài viết</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
      <li class="breadcrumb-item">Forms</li>
      <li class="breadcrumb-item active">Thêm tin tức- bài viết</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
              <form class="row g-3" style="margin-top: 10px;" action="blog-edit.php" method="post" enctype="multipart/form-data">
                <div class="col-md-6">
                  <label for="inputName5" class="form-label">Tiêu đề bài viết</label>
                  <input type="text" class="form-control" id="inputName5" name="tittle"  value="<?php echo $rs['tittle']  ?>">
                </div>
                <div class="col-md-6">
                  <label for="inputName5" class="form-label">Seo bài viết</label>
                  <input type="text" class="form-control" id="inputName5" name="seoname"  value="<?php echo $rs['seoname']  ?>">
                </div>
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">Seo Description*</label>
                  <textarea class="form-control" name="seodescription"> <?php echo $rs['seodescription']  ?></textarea>
                </div>
                <div class="col-md-6">
                  <label for="inputName5" class="form-label">Tiêu đề ảnh</label>
                  <input type="text" class="form-control" id="inputName5" name="title_th"  value="<?php echo $rs['title_th']  ?>">
                </div>
                <div class="col-md-6">
                  <label for="inputName5" class="form-label">Văn bản thay thế ảnh</label>
                  <input type="text" class="form-control" id="inputName5" name="alt_text"  value="<?php echo $rs['alt_text']  ?>">
                </div>
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">Mô tả ảnh</label>
                  <textarea class="form-control" name="description_th">  <?php echo $rs['description_th']  ?></textarea>
                </div>
                <div class="col-md-12">
                  <label for="inputNumber" class="form-label">Ảnh đại diện</label>
                  <div class="col-sm-12">
                    <input class="form-control" type="file" name="thumbnail" id="thumbnailInput" onchange="displayImage()">
                    <img id="thumbnailPreview" src="" style="max-width: 100%; max-height: 200px; margin-top: 10px;" alt="Ảnh mới">
                    <img style="max-width: 100%; max-height: 200px; margin-top: 10px;" src="./upload/<?php echo $rs['thumbnail']; ?>" alt="Ảnh cũ">
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">Caption</label>
                  <input type="text" class="form-control" id="inputName5" name="caption_th"  value="<?php echo $rs['caption_th']  ?>">
                </div>
                <!-- <div class="col-md-6">
                  <label class="form-label">Danh mục tin tức</label>
                  <?php
                  // if ($cate_list) {
                  //     foreach ($cate_list as $category) {
                  //         echo '<div class="form-check">';
                  //         echo '<input class="form-check-input" type="checkbox" name="categories[]" value="' . $category['id'] . '">';
                  //         echo '<label class="form-check-label">' . $category['namecate'] . '</label>';
                  //         echo '</div>';
                  //     }
                  // }
                  ?> -->
              <!-- </div> -->
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
                <input type="hidden" name="old_thumbnail" value="<?php echo $rs['thumbnail'] ?>">
                <input type="hidden" name="idh" value="<?php echo $rs['id'] ?>">
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="adddt">Cập nhật</button>
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
         const contentFromDatabase = <?php echo json_encode($contentFromDatabase = $rs['content']); ?>;
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
    quill.clipboard.dangerouslyPasteHTML(contentFromDatabase);
    // Add a custom Button to the Quill Editor's toolbar:
    document.querySelector('form').onsubmit = function() {
    var editorContent = quill.root.innerHTML; // Lấy nội dung HTML của Quill
    document.getElementById('editorContent').value = editorContent; // Gán nội dung vào hidden input
  };
 </script>
</body>

</html>