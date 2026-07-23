<?php

use Model\Falecido\DAO;
use Model\Falecido;

    class FalecidoController{
            private $falecidoDao;
            private $falecido;

        public function __construct()
        {
            $this->falecidoDao = new  FalecidoDao();
            $this->falecido = new Falecido();
        }

        public function index(){
            // 1. Procuramos os dados no banco e guardamos na variável $falecidos
            $falecidos = $this->falecidoDao->read();

            // 2. Caminho seguro para a View voltando uma pasta atrás (__DIR__ . '/../')
            require_once __DIR__ . '/../Views/falecidos.php';

            // 3. O teu return no final do método
            return $falecidos;
        }
        public function totalFalecido(){
            // 1. Procuramos os dados no banco e guardamos na variável $falecidos
            $total_falecidos = $this->falecidoDao->readTotal();

            // 2. Caminho seguro para a View voltando uma pasta atrás (__DIR__ . '/../')
            require_once __DIR__ . '/../Views/index.php';

            // 3. O teu return no final do método
            return $total_falecidos;
        }
        
        public function insert($codigo,$nome,$sexo,$obs){

            // 3. Injetar os dados na Model tratando os opcionais (Vazios viram NULL)
            $this->falecido->setCodigo($codigo);
            $this->falecido->setNome($nome);
            $this->falecido->setSexo($sexo);
                
            // Tratamento inteligente: Se o campo do HTML estiver vazio, a Model recebe null
            $this->falecido->setNascimento(!empty($_POST['nascimento']) ? $_POST['nascimento'] : null);
            $this->falecido->setBi(!empty($_POST['bi']) ? trim($_POST['bi']) : null);
            $this->falecido->setEstadoCivil(!empty($_POST['estado_civil']) ? $_POST['estado_civil'] : null);
            $this->falecido->setNacionalidade(!empty($_POST['nacionalidade']) ? $_POST['nacionalidade'] : null);
            $this->falecido->setPai(!empty($_POST['pai']) ? trim($_POST['pai']) : null);
            $this->falecido->setMae(!empty($_POST['mae']) ? trim($_POST['mae']) : null);
            $this->falecido->setEndereco(!empty($_POST['endereco']) ? trim($_POST['endereco']) : null);
            $this->falecido->setObs($obs);

            $this->falecidoDao->create($this->falecido);
        }

        public function delete($id){
            $this->falecidoDao->delete($id);
        }

        public function getForId($id){
            return $this->falecidoDao->getById($id);
        }

        public function Update($codigo,$nome,$sexo,$obs,$id){
            $this->falecido->setCodigo($codigo);
            $this->falecido->setNome($nome);
            $this->falecido->setSexo($sexo);
                
            // Tratamento inteligente: Se o campo do HTML estiver vazio, a Model recebe null
            $this->falecido->setNascimento(!empty($_POST['nascimento_up']) ? $_POST['nascimento_up'] : null);
            $this->falecido->setBi(!empty($_POST['bi_up']) ? trim($_POST['bi_up']) : null);
            $this->falecido->setEstadoCivil(!empty($_POST['estado_civil_up']) ? $_POST['estado_civil_up'] : null);
            $this->falecido->setNacionalidade(!empty($_POST['nacionalidade_up']) ? $_POST['nacionalidade_up'] : null);
            $this->falecido->setPai(!empty($_POST['papa']) ? trim($_POST['papa']) : null);
            $this->falecido->setMae(!empty($_POST['mama']) ? trim($_POST['mama']) : null);
            $this->falecido->setEndereco(!empty($_POST['endereco_up']) ? trim($_POST['endereco_up']) : null);
            $this->falecido->setObs($obs);
            $this->falecido->setId($id);

            $this->falecidoDao->update($this->falecido);
        }
    }