<?php
    use Model\Relatorio\Dao;


    class RelatorioController {
        private $relatorioDao;

        public function __construct() {
            $this->relatorioDao = new RelatorioDao();
        }
        

        public function getHistorico($tipo, $dataInicio, $dataFim) {

            if ($tipo === 'saidas') {
                return $this->relatorioDao->getSaidasPorPeriodo($dataInicio, $dataFim);
            }
            else if ($tipo === 'entradas') {
                
                return $this->relatorioDao->getEntradasPorPeriodo($dataInicio, $dataFim);
            }
            else if ($tipo === 'permanencia') {
                return $this->relatorioDao->getPermanenciaAtual();
            }
            else {
                throw new InvalidArgumentException("Tipo de relatório inválido: $tipo");
            }
        }

        public function getPermanencia() {
            return $this->relatorioDao->getPermanenciaAtual();
        }

        public function getMetricas() {
            return $this->relatorioDao->getMetricasCards();
        }
        
    }