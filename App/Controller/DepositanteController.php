<?php
    use Model\Depositante;
    use Model\Depositante\Dao;

    class DepositanteController{
        private $depositante;
        private $depositanteDao;

        public function __construct(){
            $this->depositante = new Depositante();
            $this->depositanteDao = new DepositanteDao();
        }

        public function index(){
            $depositante = $this->depositanteDao->read();
            require_once __DIR__ . '/../Views/depositantes.php';
            return $depositante;
        }
        public function getForId($id){
            $depositante = $this->depositanteDao->findById($id);
            require_once __DIR__ . '/../Views/edit_depositante.php';
            return $depositante;
        }

        public function insert($nome, $bi, $telefone, $tipo) {
            try {

                // Verificar se o BI já existe
                if ($this->depositanteDao->findByBi($bi)) {
                    $_SESSION['erro'] = "O BI {$bi} já está em uso!";
                    return false;
                }
                
                $this->depositante->setNome($nome);
                $this->depositante->setBi($bi);
                $this->depositante->setTelefone($telefone);
                $this->depositante->setTipo($tipo);

                return $this->depositanteDao->create($this->depositante);
            } catch (\PDOException $e) {
                echo "Erro MySQL: " . $e->getMessage(); exit();
                return false;
            }
        }

        public function update($id, $nome, $bi, $telefone, $tipo) {
            try {
                $this->depositante->setId($id);
                $this->depositante->setNome($nome);
                $this->depositante->setBi($bi);
                $this->depositante->setTelefone($telefone);
                $this->depositante->setTipo($tipo);

                $this->depositanteDao->update($this->depositante);
            } catch (\PDOException $e) {
                echo "Erro MySQL: " . $e->getMessage(); exit();
                return false;
            }
        }
        public function delete($id) {
            
            try {
                $idSanitizado = (int) $id;

                if ($idSanitizado <= 0) {
                    $_SESSION['erro'] = "ID inválido fornecido!";
                    return false;
                }
                $this->depositanteDao->delete($id);
            } catch (\PDOException $e) {
                echo "Erro MySQL: " . $e->getMessage(); exit();
                return false;
            }
        }
    }