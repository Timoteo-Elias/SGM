<?php
    use Model\Gaveta\Dao;
    use Model\Gaveta;

    class GavetaController{
        private $gavetaDao;
        private $gaveta;
        private $CamaraDao;

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
                // 1. Normalizar o código da gaveta
                $cod_gaveta = trim($cod_gaveta);

                // 2. Buscar os dados da câmara PRIMEIRO (guardamos o ID original numa variável separada)
                $camaraId = (int)$camara;
                $dadosCamara = $this->gavetaDao->findById($camaraId);

                // Valida se a câmara realmente existe no banco
                if (!$dadosCamara || !is_array($dadosCamara)) {
                    $_SESSION['erro'] = "Câmara não encontrada na base de dados!";
                    return false;
                }

                // 3. Verificar o limite de gavetas existentes vs capacidade total da câmara
                $gavetasExistentes = $this->gavetaDao->camarasOcupada($camaraId);
                $capacidadeMaxima = (int)$dadosCamara['capacidade']; // Garante que a coluna na DB se chama 'capacidade'

                if ($gavetasExistentes >= $capacidadeMaxima) {
                    $_SESSION['erro'] = "Não é possível adicionar a gaveta! A câmara " . htmlspecialchars($dadosCamara['codigo']) . " já atingiu a capacidade máxima (" . $capacidadeMaxima . " gavetas).";
                    return false;
                }

                // 4. Se o código vier vazio, gera o automático
                if (empty($cod_gaveta)) {
                    $cod_gaveta = $this->gavetaDao->getProximoCodigo();
                }

                // 5. Verificar se o código da gaveta já existe
                if ($this->gavetaDao->findByCodigo($cod_gaveta)) {
                    $_SESSION['erro'] = "O código {$cod_gaveta} já está em uso!";
                    return false;
                }

                // 6. Validação de capacidade individual da gaveta
                if ((int)$capacidade < 0) {
                    $_SESSION['erro'] = "A capacidade não pode ser um número negativo!";
                    return false;
                }

                // 7. Preencher o objeto Gaveta
                $this->gaveta->setCodigo($cod_gaveta);
                $this->gaveta->setCapacidade((int)$capacidade);
                $this->gaveta->setEstados($estado);
                $this->gaveta->setCamara($camaraId); // Passa o ID numérico limpo
                $this->gaveta->setDescricao($descricao);

                // 8. Enviar o objeto totalmente preenchido para a DAO
                return $this->gavetaDao->create($this->gaveta);

            } catch (\Exception $e) {
                die("ERRO NO CONTROLLER: " . $e->getMessage());
            }
        }
        public function getForId($id){
            $gaveta = $this->gavetaDao->getId($id);
            require_once __DIR__ . '/../Views/edit_gaveta.php';
            return $gaveta;
        }
         public function delete($id){
            $idSanitizado = (int) $id;

            if ($idSanitizado <= 0) {
                $_SESSION['erro'] = "ID inválido fornecido!";
                return false;
            }
            $this->gavetaDao->delete($id);
        }
        public function Update($capacidade,$estado,$camaraId,$descricao,$id){
            
            $this->gaveta->setCapacidade((int)$capacidade);
            $this->gaveta->setEstados($estado);
            $this->gaveta->setCamara($camaraId); // Passa o ID numérico limpo
            $this->gaveta->setDescricao($descricao);
            $this->gaveta->setId($id);

            $this->gavetaDao->update($this->gaveta);
        }
        public function gavetasOcupadas(){
            $total_o = $this->gavetaDao->gavetasOcupadas();
            require_once __DIR__ . '/../Views/gavetas.php';
            return $total_o;
        }
        public function gavetasDisponivel(){
            $total_D = $this->gavetaDao->gavetasDisponivel();
            require_once __DIR__ . '/../Views/gavetas.php';
            return $total_D;
        }
    }