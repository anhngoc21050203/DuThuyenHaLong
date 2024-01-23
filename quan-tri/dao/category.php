<?php
    include 'lib/database.php'
?>

<?php
    class category{

        private $db;

        public function __construct(){
            $this ->db = new Database();
        }

        public function insert_cate($namedt, $thumbnail, $content){
            $query = "INSERT INTO duthuyen_cate (namecate, thumbnail, content) VALUES ('$namedt', '$thumbnail', '$content')";
            $result = $this ->db ->insert($query);
            if ($result) {
                echo '<script>window.location.href = "cate_list.php";</script>';

            }else{
                echo 'Thêm không thanh công';
            }
            return $result;   
        }
        public function insert_cate_c($parent_id, $namedt){
            $query = "INSERT INTO duthuyen_cate (parent_id, namecate) VALUES ('$parent_id', '$namedt')";
            $result = $this ->db ->insert($query);
            if ($result) {
                echo '<script>window.location.href = "cate_list.php";</script>';

            }else{
                echo 'Thêm không thanh công';
            }
            return $result;   
        }

        public function show_cate(){
            $query = "SELECT * FROM duthuyen_cate";
            $result = $this -> db ->select($query);
            return $result;
        }
        public function get_duthuyen_cate($id){
            $query = "SELECT * FROM duthuyen_cate WHERE id = '$id'";
            $result = $this -> db ->select($query);
            return $result;
        }
        public function update_du_thuyen($namedt, $thumbnail, $content, $id) {
            $query = "UPDATE duthuyen_cate SET 
                            namecate = '$namedt', 
                            thumbnail = '$thumbnail',
                            content = '$content'
                        WHERE id = '$id'";
            $result = $this -> db ->update($query);
            if($result){
                echo '<script>window.location.href = "cate_list.php";</script>';
            }
            return $result;
        }
        public function delete_du_thuyen($id){
            $query = "DELETE  FROM duthuyen_cate WHERE id = '$id'";
            $result = $this -> db ->delete($query);
            if ($result) {
                echo '<script>window.location.href = "cate_list.php";</script>';
            }
            return $result;
        }
    
    }
?>