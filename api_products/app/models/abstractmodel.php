<?php 

    namespace API\Models;

    use API\LIB\Database\Database;
    use API\LIB\InputFilter;

    class AbstractModel{

        use InputFilter;
        const DATA_TYPE_BOOL = \PDO::PARAM_BOOL;
        const DATA_TYPE_STR = \PDO::PARAM_STR;
        const DATA_TYPE_INT = \PDO::PARAM_INT;
        const DATA_TYPE_DECIMAL = 4;
        const DATA_TYPE_DATE = 5;
        // private static $CONN = Database::getInstance()->getConnection();

        public function prepareValues(\PDOStatement &$stmt){
            foreach(get_called_class()::$table_Schema as $column_Name => $type){
                if ($type == 4) {
                    $sanitizedValue = filter_var($this->$column_Name, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $stmt->bindValue(":{$column_Name}", $sanitizedValue);
                } else {
                    $stmt->bindValue(":" . $column_Name, $this->$column_Name, $type);
                }
            }
        }

        private function buildNameParametersSQL(){
            $namedParams = '';
            foreach (get_called_class()::$table_Schema as $column_Name => $type) {
                $namedParams .= $column_Name . ' = :' . $column_Name . ', ';
            }
            return trim($namedParams, ', ');
        }

        public function getAll(){
            $sql = 'SELECT * FROM ' . get_called_class()::$table_Name . ' WHERE `user_id` = :user_id'; 
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bindValue(":user_id", $this->user_id, \PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if ($results) {
                return $results;
            };
            return false;
        }
        public function getByFk(){
            $sql = 'SELECT * FROM ' . get_called_class()::$table_Name . ' WHERE `product_id` = :product_id'; 
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bindValue(":product_id", $this->product_id, \PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if ($results) {
                return $results;
            };
            return false;
        }

        public function getByPk(){
            $sql = 'SELECT * FROM ' . get_called_class()::$table_Name . ' WHERE ' . get_called_class()::$name_id . get_called_class()::$primaryKey . '=:id ' . ' AND user_id = :user_id ';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bindValue(":id", $this->{get_called_class()::$primaryKey}, \PDO::PARAM_INT);
            $stmt->bindValue(":user_id", $this->user_id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($result):
                return $result;
            endif;
            return false;
        }

        public function create(){
            $sql = 'INSERT INTO ' . get_called_class()::$table_Name . ' SET ' . $this->buildNameParametersSQL();
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $this->prepareValues($stmt);
            if($stmt->execute()) {
                return true;
            }
            return false;
        }

        public function updateBy(array $columns){

            $key = array_keys($columns);
            $arr_columns = [];
            for ( $i = 0, $ii = count($columns); $i < $ii; $i++ ) {
                $arr_columns[] = $this->filterString($key[$i]) . ' =:' . $this->filterString($key[$i]) ;
            }
            $up_columns = implode(' , ', $arr_columns);
            $sql = 'UPDATE ' . get_called_class()::$table_Name . ' SET ' . $up_columns . ' WHERE ' . get_called_class()::$name_id . get_called_class()::$primaryKey . '=:id ' . ' AND user_id = :user_id ';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            foreach($key as $column){
                $stmt->bindValue(":" . $this->filterString($column), $this->filterString($this->$column));
            }
            $stmt->bindValue(":id", $this->{get_called_class()::$primaryKey} , \PDO::PARAM_INT); 
            $stmt->bindValue(":user_id", $this->user_id , \PDO::PARAM_INT);
            if($stmt->execute()):
                return true;
            endif;
            return false;
        }
        public function updateDetail(array $columns){

            $key = array_keys($columns);
            $arr_columns = [];
            for ( $i = 0, $ii = count($columns); $i < $ii; $i++ ) {
                $arr_columns[] = $this->filterString($key[$i]) . ' =:' . $this->filterString($key[$i]) ;
            }
            $up_columns = implode(' , ', $arr_columns);
            
            $sql = 'UPDATE ' . get_called_class()::$table_Name . ' SET ' . $up_columns . ' WHERE ' . get_called_class()::$name_id . get_called_class()::$primaryKey . '=:id ' . ' AND product_id = :product_id ';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            foreach($key as $column){
                $stmt->bindValue(":" . $this->filterString($column), $this->filterString($this->$column));
            }
            $stmt->bindValue(":id", $this->{get_called_class()::$primaryKey} , \PDO::PARAM_INT);
            $stmt->bindValue(":product_id", $this->product_id , \PDO::PARAM_INT);
            if($stmt->execute()):
                return true;
            endif;
            return false;
        }
        
        public function checkEmail($email){
            $sql = 'SELECT `email` FROM ' . get_called_class()::$table_Name . ' WHERE `email` = :email';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bindValue(":email", $email, \PDO::PARAM_STR);
            if($stmt->execute() && $stmt->rowCount()) {
                return true;
            }
            return false;
        }

        public function checkLogin(){
            $sql = 'SELECT * FROM ' . get_called_class()::$table_Name . ' WHERE ' . $this->buildNameParametersSQL();
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $this->prepareValues($stmt);
            if($stmt->execute() && $stmt->rowCount()) {
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                return $row;
                
            }
            return false;
        }

        public function delete(){
            $sql = 'DELETE FROM ' . get_called_class()::$table_Name . ' WHERE ' . get_called_class()::$name_id . get_called_class()::$primaryKey . '=:id ' . ' AND user_id = :user_id ';
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            $stmt->bindValue(":id", $this->{get_called_class()::$primaryKey}, \PDO::PARAM_INT);
            $stmt->bindValue(":user_id", $this->user_id, \PDO::PARAM_INT);
            $execute = $stmt->execute();
            if($execute):
                return true;
            endif;
            return false;
        }

        public function get($stmt, $options = array()){
            $sql = $stmt;
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            foreach($options as $option => $type){
                $stmt->bindValue(":". $this->filterString($option), $this->filterString($this->$option), $type);
            }
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($result){
                return $result;
            }
            return $result;
        }
        public function getFetchAll($stmt, $options = array()){
            $sql = $stmt;
            $stmt = Database::getInstance()->getConnection()->prepare($sql);
            foreach($options as $option => $type){
                $stmt->bindValue(":". $this->filterString($option), $this->filterString($this->$option), $type);
            }
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if($result){
                return $result;
            }
            return $result;
        }

    }

?>