<?php
    include 'lib/database.php'
?>

<?php
    class point{

        private $db;

        public function __construct(){
            $this ->db = new Database();
        }

        public function insert_point($namedt, $thumbnail, $content){
            $query = "INSERT INTO duthuyen_point (namep, thumbnail, content) VALUES ('$namedt', '$thumbnail', '$content')";
            $result = $this ->db ->insert($query);
            if ($result) {
                echo '<script>window.location.href = "point_list.php";</script>';

            }else{
                echo 'Thêm không thanh công';
            }
            return $result;   
        }

        public function show_point(){
            $query = "SELECT * FROM duthuyen_point";
            $result = $this -> db ->select($query);
            return $result;
        }
        public function get_duthuyen_point($id){
            $query = "SELECT * FROM duthuyen_point WHERE id = '$id'";
            $result = $this -> db ->select($query);
            return $result;
        }
        public function update_point($namedt, $thumbnail, $content, $id) {
            $query = "UPDATE duthuyen_point SET 
                            namep = '$namedt', 
                            thumbnail = '$thumbnail',
                            content = '$content'
                        WHERE id = '$id'";
            $result = $this -> db ->update($query);
            if($result){
                echo '<script>window.location.href = "point_list.php";</script>';
            }
            return $result;
        }
        public function delete_point($id){
            $query = "DELETE  FROM duthuyen_point WHERE id = '$id'";
            $result = $this -> db ->delete($query);
            if ($result) {
                echo '<script>window.location.href = "point_list.php";</script>';
            }
            return $result;
        }
    
    }
?>