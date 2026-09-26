<?php
    use Model\Entrada;
    use Model\Entrada\Dao;

    class EntradaController{
        private $entrada;
        private $entradaDao;

        public function __construct(){
            $this->entrada = new Entrada();
            $this->entradaDao = new EntradaDao();
        }

        public function index(){
            $entrada = $this->entradaDao->read();
            require_once __DIR__ . '/../Views/entradas.php';
            return $entrada;
        }
        public function delete($id){
            $idSanitizado = (int) $id;

            if ($idSanitizado <= 0) {
                $_SESSION['erro'] = "ID inválido fornecido!";
                return false;
            }
            $this->entradaDao->delete($id);
        }

        public function Edit($id){
            return $this->entradaDao->getById($id);
        }

        public function conservado(){
            $conservado = $this->entradaDao->Conservados();
            require_once __DIR__ . '/../Views/conservados.php';
            return $conservado;
        }
        public function ultimasentradas(){
            $ue = $this->entradaDao->UltimasEntradas();
            require_once __DIR__ . '/../Views/index.php';
            return $ue;
        }
        public function total_e(){
            $total_e = $this->entradaDao->TotalE();
            require_once __DIR__ . '/../Views/index.php';
            return $total_e;
        }
        public function total_e_r(){
            $total_e = $this->entradaDao->TotalE();
            require_once __DIR__ . '/../Views/relatorio.php';
            return $total_e;
        }
        public function total_h(){
            $total_e = $this->entradaDao->TotalEntradaHoje();
            require_once __DIR__ . '/../Views/index.php';
            return $total_e;
        }
        public function total_h_R(){
            $total_e = $this->entradaDao->TotalEntradaHoje();
            require_once __DIR__ . '/../Views/relatorio.php';
            return $total_e;
        }

        public function insert($codigoGerado, $falecido, $depositante, $gaveta, $estado) {
            try {
                // 1. Resgatar e validar o utilizador logado da sessão
                $idUsuario = $_SESSION['usuario_logged']['id'] ?? null;

                if (!$idUsuario) {
                    $_SESSION['erro'] = "Sessão inválida ou expirada. Faça login novamente!";
                    return false;
                }

                if ($this->entradaDao->findFalecido($falecido)) {
                    $_SESSION['erro'] = "Atenção: Este falecido já se encontra registado com uma entrada ativa no sistema!";
                    return false;
                }

                // 2. Validação da Capacidade da Gaveta / Câmara
                $gavetaId = (int)$gaveta;
                $dadosGaveta = $this->entradaDao->findGaveta($gavetaId);
                $gavetasExistentes = $this->entradaDao->gavetasOcupadas($gavetaId);
                
                $capacidadeMaxima = (int)($dadosGaveta['capacidade']); 

                if ($gavetasExistentes >= $capacidadeMaxima) {
                    $codigoGaveta = htmlspecialchars($dadosGaveta['codigo_gaveta'] ?? 'N/A');
                    $_SESSION['erro'] = "Não é possível alocar! A Gaveta {$codigoGaveta} já atingiu a capacidade máxima de ({$capacidadeMaxima}).";
                    return false;
                }

                // 3. Gerar o Código Automático de Entrada e Garantir que é único
                $codigoGerado = $this->entradaDao->getProximoCodigo();

                if ($this->entradaDao->findByCodigo($codigoGerado)) {
                    $_SESSION['erro'] = "O código {$codigoGerado} já está em uso na base de dados!";
                    return false;
                }

                // 4. Preencher o Objeto Model da Entrada
                $this->entrada->setCodigo($codigoGerado);
                $this->entrada->setFalecido($falecido);
                $this->entrada->setUsuario($idUsuario); // 👈 ID corrigido da sessão
                $this->entrada->setDepositante($depositante);
                $this->entrada->setGaveta($gavetaId);
                $this->entrada->setEstado($estado);

                // 5. Persistir na Base de Dados
                $idEntrada = $this->entradaDao->create($this->entrada);

                if ($idEntrada !== false) {
                    header("Location: pdf/ficha_entrada.php?id=" . $idEntrada);
                    exit();
                }
                
                return false;
            } catch (\PDOException $e) {
                // Log para ambiente de desenvolvimento / mensagem amigável em produção
                $_SESSION['erro'] = "Erro de Base de Dados: " . $e->getMessage();
                return false;
            }
        }

        public function update($depositante,$gaveta,$id){
            try{
                $this->entrada->setDepositante($depositante);
                $this->entrada->setGaveta($gaveta);
                $this->entrada->setId($id);

                $this->entradaDao->update($this->entrada);

            } catch (\PDOException $e) {
                // Log para ambiente de desenvolvimento / mensagem amigável em produção
                $_SESSION['erro'] = "Erro de Base de Dados: " . $e->getMessage();
                return false;
            }
        }

        public function fichaById($id){
            return $this->entradaDao->FichaById($id);
        }

        public function confi(){
            return $this->entradaDao->Confi();
        }
    }