<?php
    class Connect{
        private static $conn;

        /**
         * @return PDO
         */
        public static function getConn()
        {
            if (!isset(self::$conn)) {

                try {
                    self::$conn = new PDO(
                        "mysql:host=localhost;dbname=gsm_cacuaco;charset=utf8mb4",
                        "root",
                        ""
                    );
                    self::$conn->setAttribute(
                        PDO::ATTR_ERRMODE,
                        PDO::ERRMODE_EXCEPTION
                    );

                } catch (PDOException $e) {
                    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
                }
            }
            return self::$conn;
        }
    }