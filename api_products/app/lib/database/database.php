<?php 

    namespace API\LIB\Database;

    class Database {
        private static $instance = null;
        private $conn;

        private function __construct() {
            try {
                $this->conn = new \PDO("mysql:host=" . DATABASE_HOST_NAME . ";dbname=" . DATABASE_DB_NAME, DATABASE_USER_NAME, DATABASE_PASSWORD);
                $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch(\PDOException $e) {
                echo json_encode([
                    "Connection failed" => $e->getMessage()
                ]);
            }
        }

        public static function getInstance() {
            if (!self::$instance) {
                self::$instance = new Database();
            }
            return self::$instance;
        }

        public function getConnection() {
            return $this->conn;
        }
    }
    

?>