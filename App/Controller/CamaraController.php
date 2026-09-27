<?php   
    use Model\Camara\Dao;
    use Model\Camara;

    class CamaraController{
        private $camaraDao;
        private $camara;
        
        public function __construct(){
            $this->camaraDao = new CamaraDao();
            $this->camara = new Camara();
        }

        public function index(){
            $camaras = $this->camaraDao->read();
            require_once __DIR__ . '/../Views/camaras.php';
            return $camaras;
        }
        public function total_l(){
            $camaras = $this->camaraDao->read();
            require_once __DIR__ . '/../Views/relatorio.php';
            return $camaras;
        }

        public function insert($codigo,$capacidade,$temperatura,$estado,$obs){

            // Se o código vier vazio, gera o automático
            if (empty($codigo)) {
                $codigo = $this->camaraDao->getProximoCodigo();
            }

            // Verificar se o código já existe
            if ($this->camaraDao->findByCodigo($codigo)) {
                $_SESSION['erro'] = "O código {$codigo} já está em uso!";
                return false;
            }

            // Validação de capacidade negativa
            if ((int)$capacidade < 0) {
                $_SESSION['erro'] = "A capacidade não pode ser um número negativo!";
                return false;
            }

            // Instanciar e preencher o objeto Camara com os dados recebidos
            $this->camara->setCodigo($codigo);
            $this->camara->setCapacidade((int)$capacidade);
            $this->camara->setTemperatura((float)$temperatura);
            $this->camara->setEstado((int)$estado);
            $this->camara->setObs($obs);
            return $this->camaraDao->create($this->camara);
        }

        public function getForId($id){
            return $this->camaraDao->getForId($id);
        }

        public function update($capacidade,$temperatura,$estado,$obs,$id){

            $this->camara->setCapacidade((int)$capacidade);
            $this->camara->setTemperatura((float)$temperatura);
            $this->camara->setEstado((int)$estado);
            $this->camara->setObs($obs);
            $this->camara->setId($id);

            $this->camaraDao->update($this->camara);
        }
        
    }