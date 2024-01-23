<?php
    include 'lib/database.php'
?>

<?php
    class nguoidung{

        private $db;

        public function __construct(){
            $this ->db = new Database();
        }

        public function insert_nguoi_dung($username, $password, $email, $phone, $role_id){
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO user (username, password, email, phone, role_id) VALUES ('$username', '$password_hash', '$email', '$phone', '$role_id')";
            $result = $this ->db ->insert($query);
            if ($result) {
                echo '<script>window.location.href = "nguoi-dung-list.php";</script>';

            }else{
                echo 'Thêm không thanh công';
            }
            return $result;   
        }

        public function show_nguoi_dung(){
            $query = "SELECT user.*, role.namerl
                        FROM user
                        INNER JOIN role ON user.role_id = role.id
                        ";
            $result = $this -> db ->select($query);
            return $result;
        }

        public function show_nguoi_dung_role(){
            $query = "SELECT * FROM role";
            $result = $this -> db ->select($query);
            return $result;
        }
        public function get_user($id){
            $query = "SELECT user.*, role.namerl
                        FROM user
                        INNER JOIN role ON user.role_id = role.id
                        WHERE user.id = '$id'";
            $result = $this -> db ->select($query);
            return $result;
        }
        public function update_nguoi_dung($username, $password, $email, $phone, $role_id, $id) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE user SET 
                            username = '$username', 
                            password = '$password_hash', 
                            email = '$email', 
                            phone = '$phone', 
                            role_id = '$role_id', 
                        WHERE id = '$id'";
            $result = $this -> db ->update($query);
            if($result){
                echo '<script>window.location.href = "nguoi-dung-list.php";</script>';
            }
            return $result;
        }
        public function delete_nguoi_dung($id){
            $query = "DELETE  FROM user WHERE id = '$id'";
            $result = $this -> db ->delete($query);
            if ($result) {
                echo '<script>window.location.href = "nguoi-dung-list.php";</script>';
            }
            return $result;
        }
        public function login($username, $password){
            // Sử dụng prepared statement để tránh SQL injection
            $query = "SELECT * FROM user WHERE username = '$username'";
            
            $result = $this->db->select($query);
        
            // Khởi tạo mảng kết quả
            $response = array();
        
            // Kiểm tra xem có bản ghi trả về không
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
        
                // Kiểm tra mật khẩu bằng password_verify
                if (password_verify($password, $user['password'])) {
                    // Mật khẩu đúng, đăng nhập thành công
                    $response['status'] = 1;
                    $response['user'] = $user; // Thêm thông tin người dùng vào mảng kết quả
                } else {
                    // Sai mật khẩu
                    $response['status'] = 2;
                }
            } else {
                // Không tìm thấy người dùng với username đã nhập
                $response['status'] = 3;
            }
        
            // Trả về mảng kết quả
            return $response;
        }
        
    }
?>