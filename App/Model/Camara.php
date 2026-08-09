<?php
    namespace Model;

    class Camara{
        private int $id;
        private string $codigo = '';
        private int $capacidade = 1 ;
        private float $temperatura = 0.0;
        private int $estado = 1;
        private string $obs = '';
        private string $data_cadastro = '';
        private string $data_atualizacao = '';

        public function getId():int{
            return $this->id;
        }

        public function setId(int $id):void{
            $this->id = $id;
        }

        public function getCodigo():string{
            return $this->codigo;
        }

        public function setCodigo(string $codigo):void{
            $this->codigo = $codigo;
        }

        public function getCapacidade():int{
            return $this->capacidade;
        }

        public function setCapacidade(int $capacidade):void{
            $this->capacidade = $capacidade;
        }

        public function getTemperatura():float{
            return $this->temperatura;
        }

        public function setTemperatura(float $temperatura):void{
            $this->temperatura = $temperatura;
        }

        public function getEstado():int{
            return $this->estado;
        }

        public function setEstado(int $estado):void{
            $this->estado = $estado;
        }

        public function getObs():string{
            return $this->obs;
        }

        public function setObs(string $obs):void{
            $this->obs = $obs;
        }

        public function getDataCadastro():string{
            return $this->data_cadastro;
        }

        public function setDataCadastro(string $data_cadastro):void{
            $this->data_cadastro = $data_cadastro;
        }

        public function getDataAtualizacao():string{
            return $this->data_atualizacao;
        }

        public function setDataAtualizacao(string $data_atualizacao):void{
            $this->data_atualizacao = $data_atualizacao;
        }


    }