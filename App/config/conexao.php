<?php

    class Connect{
        private static $conn;

        /**
         * Retorna uma conexão com o banco de dados.
         * Caso a conexão ainda não exista, ela será criada.
         *
         * @return PDO
         */
        public static function getConn()
        {
            // Verifica se a conexão já foi criada
            if (!isset(self::$conn)) {

                try {

                    // Cria uma nova conexão PDO
                    self::$conn = new PDO(
                        "mysql:host=localhost;dbname=gsm_cacuaco;charset=utf8mb4",
                        "root",
                        ""
                    );

                    // Configura o PDO para lançar exceções em caso de erro
                    self::$conn->setAttribute(
                        PDO::ATTR_ERRMODE,
                        PDO::ERRMODE_EXCEPTION
                    );

                } catch (PDOException $e) {

                    // Exibe a mensagem de erro caso a conexão falhe
                    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
                }
            }

            // Retorna a conexão existente
            return self::$conn;
        }
    }