<?php
    include 'lib/database.php'
?>

<?php
    class blog{

        private $db;

        public function __construct(){
            $this ->db = new Database();
        }

        public function insert_blog($tittle, $seoname, $seodescription, $title_th, $alt_text, $description_th, $thumbnail, $caption_th, $content, $createdby) {
            $currentDateTime = date('Y-m-d');
            $query = "INSERT INTO blog (tittle, seoname, seodescription, title_th, alt_text, description_th, thumbnail, caption_th, content, createdby, createddate) VALUES ('$tittle', '$seoname', '$seodescription', '$title_th', '$alt_text', '$description_th', '$thumbnail', '$caption_th', '$content','$createdby', '$currentDateTime')";
            $result = $this->db->insert($query);
        
            if ($result) {
                // // Lấy id của du thuyền vừa được thêm vào
                // $blogId = $this->db->getLastInsertedId();
        
                // // Chuyển sang hàm insert_du_thuyen_category để thêm loại cho du thuyền
                // $this->insert_du_thuyen_category($blogId, $category_ids);
                // $this->insert_du_thuyen_point($blogId, $point_ids);
        
                echo '<script>window.location.href = "blog.php";</script>';
            } else {
                echo 'Thêm không thành công';
            }
        
            return $result;
        }
        public function insert_path_im($path) {
            $query = "INSERT INTO img_dt (path_img) VALUES ('$path')";
            $result = $this->db->insert($query);
            return $result;
        }
        

        public function show_blog(){
            $query = "SELECT * FROM blog
                        ";
            $result = $this -> db ->select($query);
            return $result;
        }

        // public function show_du_thuyen_cate(){
        //     $query = "SELECT * FROM blog_cate";
        //     $result = $this -> db ->select($query);
        //     return $result;
        // }

        // public function show_du_thuyen_point(){
        //     $query = "SELECT * FROM blog_point";
        //     $result = $this -> db ->select($query);
        //     return $result;
        // }
        public function get_blog($id){
            $query = "SELECT * FROM blog WHERE id = '$id'";
            $result = $this -> db ->select($query);
            return $result;
        }

        public function update_blog($tittle, $seoname, $seodescription, $title_th, $alt_text, $description_th, $thumbnail, $caption_th, $content, $createdby, $id) {
            $currentDateTime = date('Y-m-d');
            $query = "UPDATE blog SET 
                            tittle = '$tittle', 
                            seoname = '$seoname',
                            seodescription = '$seodescription',
                            title_th = '$title_th', 
                            alt_text = '$alt_text', 
                            description_th = '$description_th',
                            thumbnail = '$thumbnail', 
                            caption_th = '$caption_th',
                            content = '$content', 
                            modifieddate = '$currentDateTime',
                            modifiedby = '$createdby'
                        WHERE id = '$id'";
            $result = $this -> db ->update($query);
            if($result){
                echo '<script>window.location.href = "blog.php";</script>';
            }
            return $result;
        }
        public function delete_blog($id){
            $query = "DELETE  FROM blog WHERE id = '$id'";
            $result = $this -> db ->delete($query);
            if ($result) {
                echo '<script>window.location.href = "blog.php";</script>';
            }
            return $result;
        }
    
    }
?>