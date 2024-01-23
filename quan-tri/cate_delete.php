<?php
    include 'dao/category.php';
    include 'pages/sessionpq.php';

    $category = new category();
    if(isset($_GET['id'])){
        $id_del = $_GET['id'];
        $category_del = $category->delete_du_thuyen($id_del);
    }
    else{
        echo '<script>window.location.href = "index.php";</script>';  
    }
?>