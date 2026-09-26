<?php
    use Model\Estados\Dao;
    use Model\Estados;

    class EstadosController{
        private $estadosDao;
        private $estados;

        public function __construct()
        {
            $this->estadosDao = new  estadosDao();
            $this->estados = new Estados();
        }

        public function index(){
            $estados = $this->estadosDao->read();
            require_once __DIR__ . '/../Views/estados.php';
            return $estados;
        }

        public function insert($nome, $tipo, $descricao) {
            try {
                // . Verificar se o nome já existe
                if ($this->estadosDao->findByNome($nome)) {
                    $_SESSION['erro'] = "O nome {$nome} já está em uso!";
                    return false;
                }

                // 2. Instanciar e preencher o objeto Estados com os dados recebidos
                $this->estados->setNome($nome);
                $this->estados->setTipo($tipo);
                $this->estados->setDescricao($descricao);

                // 3. Inserir no banco de dados
                return $this->estadosDao->create($this->estados);
            } catch (\PDOException $e) {
                 echo "Erro MySQL: " . $e->getMessage(); exit();
                return false;
            }
        }

        

        public function delete($id){
            $idSanitizado = (int) $id;

            if ($idSanitizado <= 0) {
                $_SESSION['erro'] = "ID inválido fornecido!";
                return false;
            }
            $this->estadosDao->delete($id);
        }

        public function Edit($id){
            return $this->estadosDao->FindId($id);
        }

        public function Update($nome,$tipo,$descricao,$id){
            $this->estados->setNome($nome);
            $this->estados->setTipo($tipo);
            $this->estados->setDescricao($descricao);
            $this->estados->setId($id);

            $this->estadosDao->update($this->estados);
        }
        
    }