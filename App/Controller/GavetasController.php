<?php
    use Model\Gaveta\Dao;
    use Model\Gaveta;
    use Model\Camara\Dao as CamaraDao;

    class GavetaController{
        private $gavetaDao;
        private $gaveta;

        public function __construct()
        {
            $this->gavetaDao = new  GavetaDao();
            $this->gaveta = new Gaveta();
        }

        public function index(){
            $gavetas = $this->gavetaDao->read();
            require_once __DIR__ . '/../Views/gavetas.php';
            return $gavetas;
        }

        public function totalGavetas(){
            $total_g = $this->gavetaDao->readTotal();
            require_once __DIR__ . '/../Views/gavetas.php';
            return $total_g;
        }
        public function RestanteGavetas(){
            $restante_g = $this->gavetaDao->readTotal();
            require_once __DIR__ . '/../Views/gavetas.php';
            return $restante_g;
        }

        public function insert($cod_gaveta, $capacidade, $estado, $camara, $descricao) {
            try {
                // 1. Normalizar variáveis
                $cod_gaveta = trim($cod_gaveta);

                
                // Se o código vier vazio, gera o automático
                if (empty($cod_gaveta)) {
                    $cod_gaveta = $this->gavetaDao->getProximoCodigo();
                }
                $camara = $this->camaraDao->findById($camara);
                if ($camara['capacidade'] <= 0) {
                    $_SESSION['erro'] = "A câmara " . $camara['codigo'] . " não tem capacidade para mais gavetas!";
                    return false;
                }
                // 2. Verificar se o código já existe
                if ($this->gavetaDao->findByCodigo($cod_gaveta)) {
                    $_SESSION['erro'] = "O código {$cod_gaveta} já está em uso!";
                    return false;
                }

                // 3. Validação de capacidade negativa
                if ((int)$capacidade < 0) {
                    $_SESSION['erro'] = "A capacidade não pode ser um número negativo!";
                    return false;
                }

                // 4. Instanciar e preencher o objeto Gaveta com os dados recebidos
                
                $this->gaveta->setCodigo($cod_gaveta);
                $this->gaveta->setCapacidade((int)$capacidade);
                $this->gaveta->setEstados($estado); // ou setEstadoId((int)$estado) conforme o nome na tua entidade
                $this->gaveta->setCamara((int)$camara);
                $this->gaveta->setDescricao($descricao);

                // 5. Enviar o objeto totalmente preenchido para a DAO
                return $this->gavetaDao->create( $this->gaveta);

            } catch (\Exception $e) {
                die("ERRO NO CONTROLLER: " . $e->getMessage());
            }
        }
    }