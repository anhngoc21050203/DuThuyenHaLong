<?php
    include 'dao/nguoidung.php';
    include 'pages/sessionpq.php';

    $nguoidung = new nguoidung();
    if(isset($_GET['id'])){
        $id_del = $_GET['id'];
        $nguoidung_del = $nguoidung->delete_nguoi_dung($id_del);
    }else{
        echo '<script>window.location.href = "index.php";</script>';  
    }
?>