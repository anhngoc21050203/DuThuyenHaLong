<?php
    include 'lib/database.php'
?>

<?php
    class duthuyen{

        private $db;

        public function __construct(){
            $this ->db = new Database();
        }

        public function insert_du_thuyen($namedt, $seoname, $seodescription, $title_th, $alt_text, $description_th, $thumbnail, $caption_th, $content, $year, $price, $price_sales, $createdby, $category_ids, $point_ids, $tour_ids) {
            $currentDateTime = date('Y-m-d');
            $query = "INSERT INTO duthuyen (namedt, seoname, seodescription, title_th, alt_text, description_th, thumbnail, caption_th, content, year, price, price_sales, createddate, createdby) VALUES ('$namedt', '$seoname', '$seodescription', '$title_th', '$alt_text', '$description_th', '$thumbnail', '$caption_th', '$content', '$year', '$price', '$price_sales', '$currentDateTime','$createdby')";
            $result = $this->db->insert($query);
        
            if ($result) {
                // Lấy id của du thuyền vừa được thêm vào
                $duThuyenId = $this->db->getLastInsertedId();
        
                // Chuyển sang hàm insert_du_thuyen_category để thêm loại cho du thuyền
                $this->insert_du_thuyen_category($duThuyenId, $category_ids);
                $this->insert_du_thuyen_category($duThuyenId, $tour_ids);
                $this->insert_du_thuyen_point($duThuyenId, $point_ids);
        
                echo '<script>window.location.href = "du-thuyen-list.php";</script>';
            } else {
                echo 'Thêm không thành công';
            }
        
            return $result;
        }
        
        public function insert_du_thuyen_category($duThuyenId, $category_ids) {
            foreach ($category_ids as $category_id) {
                // Thêm dữ liệu vào bảng duthuyen_dt_cate
                $query = "INSERT INTO duthuyen_dt_cate (duthuyen_id, cate_id) VALUES ('$duThuyenId', '$category_id')";
                $result = $this->db->insert($query);
        
                if (!$result) {
                    // Xử lý lỗi (nếu cần)
                    echo 'Thêm không thành công';
                    return false;
                }
            }
        
            return true;
        }
        public function insert_du_thuyen_point($duThuyenId, $point_ids) {
            foreach ($point_ids as $point_id) {
                // Thêm dữ liệu vào bảng duthuyen_dt_cate
                $query = "INSERT INTO duthuyen_dt_point (duthuyen_id, point_id) VALUES ('$duThuyenId', '$point_id')";
                $result = $this->db->insert($query);
        
                if (!$result) {
                    // Xử lý lỗi (nếu cần)
                    echo 'Thêm không thành công';
                    return false;
                }
            }
        
            return true;
        }
        

        public function show_du_thuyen(){
            $query = "SELECT * FROM duthuyen
                        ";
            $result = $this -> db ->select($query);
            return $result;
        }

        public function show_du_thuyen_cate(){
            $query = "SELECT * FROM duthuyen_cate";
            $result = $this -> db ->select($query);
            return $result;
        }

        public function show_du_thuyen_point(){
            $query = "SELECT * FROM duthuyen_point";
            $result = $this -> db ->select($query);
            return $result;
        }
        public function get_duthuyen($id){
            $query = "SELECT * FROM duthuyen WHERE id = '$id'";
            $result = $this -> db ->select($query);
            return $result;
        }
        public function get_duthuyen_cate($id){
            $query = "SELECT * FROM duthuyen_dt_cate WHERE duthuyen_id = '$id'";
            $result = $this -> db ->select($query);
            return $result;
        }
        public function get_duthuyen_cate_t($id){
        
            $query = "SELECT duthuyen_dt_cate.duthuyen_id, duthuyen_cate.id
                      FROM duthuyen_dt_cate
                      INNER JOIN duthuyen_cate ON duthuyen_dt_cate.cate_id = duthuyen_cate.id
                      WHERE duthuyen_dt_cate.duthuyen_id = '$id' AND duthuyen_cate.parent_id != 0";
        
            $result = $this->db->select($query);
        
            if ($result === false) {
                // Xử lý lỗi ở đây
                return false;
            }
        
            return $result;
        }
        
        public function get_duthuyen_point($id){
            $query = "SELECT * FROM duthuyen_dt_point WHERE duthuyen_id = '$id'";
            $result = $this -> db ->select($query);
            return $result;
        }
        public function delete_du_thuyen_cate($duThuyenId, $removedCategories) {
            foreach ($removedCategories as $removedCategory) {
                $query = "DELETE FROM duthuyen_dt_cate WHERE duthuyen_id = '$duThuyenId' AND cate_id = '$removedCategory'";
                $result = $this->db->delete($query);
        
                if (!$result) {
                    // Xử lý lỗi nếu cần thiết
                    return false;
                }
            }        
            return true;
        }
        public function delete_du_thuyen_point($duThuyenId, $removedCategories) {
            foreach ($removedCategories as $removedCategory) {
                $query = "DELETE FROM duthuyen_dt_point WHERE duthuyen_id = '$duThuyenId' AND point_id = '$removedCategory'";
                $result = $this->db->delete($query);
        
                if (!$result) {
                    // Xử lý lỗi nếu cần thiết
                    return false;
                }
            }        
            return true;
        }
        public function update_du_thuyen($namedt, $seoname, $seodescription, $thumbnail, $content, $year, $price, $price_sales, $createdby, $id, $category_ids, $point_ids, $tour_ids) {
            $currentDateTime = date('Y-m-d');
            $query = "UPDATE duthuyen SET 
                            namedt = '$namedt', 
                            seoname = '$seoname',
                            seodescription = '$seodescription',
                            thumbnail = '$thumbnail', 
                            content = '$content', 
                            year = '$year', 
                            price = '$price', 
                            price_sales = '$price_sales',
                            modifieddate = '$currentDateTime',
                            modifiedby = '$createdby'
                        WHERE id = '$id'";
            $result = $this -> db ->update($query);
            $result_set_c = $this->get_duthuyen_cate($id);
            $result_set_p = $this->get_duthuyen_point($id);
            $result_set_c_c = $this->get_duthuyen_cate_t($id);

            if ($result_set_c && $result_set_p && $result_set_c_c) {
                $cate_list_cheked_old = [];
                while ($row = $result_set_c->fetch_assoc()) {
                    $cate_list_cheked_old[] = $row['cate_id'];
                }
                $point_list_cheked_old = [];
                while ($row = $result_set_p->fetch_assoc()) {
                    $point_list_cheked_old[] = $row['point_id'];
                }
                $cate_list_t_cheked_old = [];
                while ($row = $result_set_c_c->fetch_assoc()) {
                    $cate_list_t_cheked_old[] = $row['cate_id'];
                }
                $removedPointies = array_diff($point_list_cheked_old, $point_ids);
                $removedCategories = array_diff($cate_list_cheked_old, $category_ids);
                $removedCategories_c = array_diff($cate_list_t_cheked_old, $tour_ids);
                $addPointies = array_diff($point_ids, $point_list_cheked_old);
                $addCategories = array_diff($category_ids, $cate_list_cheked_old);
                $addCategories_c = array_diff($tour_ids, $cate_list_t_cheked_old);

                
                if (!empty($removedCategories) ) {
                    $delete_result = $this->delete_du_thuyen_cate($id, $removedCategories);
                    
                    if (!$delete_result) {
                        // Xử lý lỗi nếu cần thiết
                        return false;
                    }
                }
                if (!empty($removedCategories_c) ) {
                    $delete_result = $this->delete_du_thuyen_cate($id, $removedCategories_c);
                    
                    if (!$delete_result) {
                        // Xử lý lỗi nếu cần thiết
                        return false;
                    }
                }
                if (!empty($removedPointies) ) {
                    $delete_result = $this->delete_du_thuyen_point($id, $removedPointies);
                    
                    if (!$delete_result) {
                        // Xử lý lỗi nếu cần thiết
                        return false;
                    }
                }
                if (!empty($addCategories) ) {
                    $delete_result = $this->insert_du_thuyen_category($id, $addCategories);
                    
                    if (!$delete_result) {
                        // Xử lý lỗi nếu cần thiết
                        return false;
                    }
                }
                if (!empty($addPointies) ) {
                    $delete_result = $this->insert_du_thuyen_point($id, $addPointies);
                    
                    if (!$delete_result) {
                        // Xử lý lỗi nếu cần thiết
                        return false;
                    }
                }
                if (!empty($addCategories_c) ) {
                    $delete_result = $this->insert_du_thuyen_point($id, $addCategories_c);
                    
                    if (!$delete_result) {
                        // Xử lý lỗi nếu cần thiết
                        return false;
                    }
                }
            } else {
                // Xử lý lỗi hoặc thông báo người dùng về lỗi khi lấy danh sách danh mục
                return false;
            }
            if($result){
                echo '<script>window.location.href = "du-thuyen-list.php";</script>';
            }
            return $result;
        }
        public function delete_du_thuyen($id){
            $query = "DELETE  FROM duthuyen WHERE id = '$id'";
            $result = $this -> db ->delete($query);
            if ($result) {
                echo '<script>window.location.href = "du-thuyen-list.php";</script>';
            }
            return $result;
        }
    
    }
?>