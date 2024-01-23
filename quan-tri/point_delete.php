<?php
    include 'dao/point.php';
    include 'pages/sessionpq.php';

    $point = new point();
    if(isset($_GET['id'])){
        $id_del = $_GET['id'];
        $point_del = $point->delete_point($id_del);
    }
    else{
        echo '<script>window.location.href = "index.php";</script>';  
    }
?>