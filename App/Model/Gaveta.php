<?php
    namespace Model;

    class Gaveta{
        private int $id;
        private int $capacidade = 0; // Capacidade padrão como 0
        private int $estado = 1; // Estado padrão como 1 (ativo)
        private ?string $cod_gaveta = null;
        private string $descricao = '';

        private int $camara = 1; // Estado padrão como 1 (ativo)

        public function getId():int{
            return $this->id;
        }

        public function setId(int $id):void{
            $this->id = $id;
        }

        public function getCapacidade():int{
            return $this->capacidade;
        }

        public function setCapacidade(int $capacidade):void{
            $this->capacidade = $capacidade;
        }

        public function getEstados():int{
            return $this->estado;
        }

        public function setEstados(int $estado):void{
            $this->estado = $estado;
        }

        public function getCodigo():?string{
            return $this->cod_gaveta;
        }

        public function setCodigo(?string $cod_gaveta):void{
            $this->cod_gaveta = $cod_gaveta;
        }

        public function getDescricao():string{
            return $this->descricao;
        }

        public function setDescricao(string $descricao):void{
            $this->descricao = $descricao;
        }
        // No Model/Gaveta.php

        public function getCamara(): int {
            return $this->camara;
        }

        public function setCamara(int $camara): void {
            $this->camara = $camara;
        }
    }