<?php
    include 'dao/blog.php';
    include 'pages/sessionpq.php';

    $blog = new blog();
    if(isset($_GET['id'])){
        $id_del = $_GET['id'];
        $blog_del = $blog->delete_blog($id_del);
    }
    else{
        echo '<script>window.location.href = "index.php";</script>';  
    }
?>