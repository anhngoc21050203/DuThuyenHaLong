<?php
    include 'lib/database.php'
?>

<?php
    class brand{

        private $db;

        public function __construct(){
            $this ->db = new Database();
        }

        public function insert_brand($namedt, $thumbnail){
            $query = "INSERT INTO duthuyen_brand (namebr, thumbnail) VALUES ('$namedt', '$thumbnail')";
            $result = $this ->db ->insert($query);
            if ($result) {
                echo '<script>window.location.href = "brand_list.php";</script>';

            }else{
                echo 'Thêm không thanh công';
            }
            return $result;   
        }

        public function show_brand(){
            $query = "SELECT * FROM duthuyen_brand";
            $result = $this -> db ->select($query);
            return $result;
        }
        public function get_duthuyen_brand($id){
            $query = "SELECT * FROM duthuyen_brand WHERE id = '$id'";
            $result = $this -> db ->select($query);
            return $result;
        }
        public function update_brand($namedt, $thumbnail, $id) {
            $query = "UPDATE duthuyen_brand SET 
                            namebr = '$namedt', 
                            thumbnail = '$thumbnail'
                        WHERE id = '$id'";
            $result = $this -> db ->update($query);
            if($result){
                echo '<script>window.location.href = "brand_list.php";</script>';
            }
            return $result;
        }
        public function delete_brand($id){
            $query = "DELETE  FROM duthuyen_brand WHERE id = '$id'";
            $result = $this -> db ->delete($query);
            if ($result) {
                echo '<script>window.location.href = "brand_list.php";</script>';
            }
            return $result;
        }
    
    }
?>