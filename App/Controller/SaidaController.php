<?php
    use Model\Saida\Dao;
    use Model\Saida;

    class SaidaController{
        private $saidaDao;
        private $saida;

        public function __construct(){
            $this->saidaDao = new SaidaDao();
            $this->saida = new Saida();
        }
        public function index(){
            $saida = $this->saidaDao->read();
            require_once __DIR__ . '/../Views/saidas.php';
            return $saida;
        }
        public function lista(){
            return $this->saidaDao->read();
        }
        public function total_h(){
            $total_e = $this->saidaDao->TotalSaidaHoje();
            require_once __DIR__ . '/../Views/index.php';
            return $total_e;
        }

        public function insert($codigo,$falecido,$nome_receptor,$bi_receptor,$estado){
            try{
                $usuario = $_SESSION['usuario_logged']['id'] ?? null;

                if (!$usuario) {
                    $_SESSION['erro'] = "Sessão inválida ou expirada. Faça login novamente!";
                    return false;
                }
                if($this->saidaDao->findByCodigo($codigo)) {
                    $_SESSION['erro'] = "O código {$codigo} já está em uso!";
                    return false;
                }
                
                $this->saida->setCodigo($codigo);
                $this->saida->setFalecido($falecido);
                $this->saida->setUsuario($usuario);
                $this->saida->setNomeReceptor($nome_receptor);
                $this->saida->setBiReceptor($bi_receptor); 
                $this->saida->setEstado($estado);

               $idSaida = $this->saidaDao->create($this->saida);

                if ($idSaida !== false) {
                    header("Location: pdf/ficha_saida.php?id=" . $idSaida);
                    exit();
                }
                
                return false;
            } catch (\Exception $e) {
                die("ERRO NO CONTROLLER: " . $e->getMessage());
            }
        }
        public function delete($codigo) {
            try {
                $idSanitizado = (int) $codigo;

                if ($idSanitizado <= 0) {
                    $_SESSION['erro'] = "ID inválido fornecido!";
                    return false;
                }
                return $this->saidaDao->delete($codigo);
            } catch (\Exception $e) {
                die("ERRO NO CONTROLLER: " . $e->getMessage());
            }
        }

        public function getForId($id){
            $saida = $this->saidaDao->getId($id);
            require_once __DIR__ . '/../Views/edit_saida.php';
            return $saida;
        }

        public function update($nome, $bi, $id) {
            try {
                $this->saida->setNomeReceptor($nome);
                $this->saida->setBiReceptor($bi); 
                $this->saida->setIdSaida($id);

                $this->saidaDao->update($this->saida);
            } catch (\Exception $e) {
                die("ERRO NO CONTROLLER: " . $e->getMessage());
            }
        }

         public function fichaById($id){
            return $this->saidaDao->FichaById($id);
        }

        public function confi(){
            return $this->saidaDao->Confi();
        }
    }