<?php
    include 'dao/duthuyen.php';
    include 'pages/sessionpq.php';

    $duthuyen = new duthuyen();
    if(isset($_GET['id'])){
        $id_del = $_GET['id'];
        $duthuyen_del = $duthuyen->delete_du_thuyen($id_del);
    }
    else{
        echo '<script>window.location.href = "index.php";</script>';  
    }
?>