<?php
    namespace Model;

    class Depositante{
        private int $id;
        private string $nome = '';
        private string $bi = '';
        private string $telefone = '';
        private string $tipo = '';

        public function getId():int{
            return $this->id;
        }
        public function setId(int $id):void{
            $this->id = $id;
        }
        public function getNome():string{
            return $this->nome;
        }
        public function setNome(string $nome):void{
            $this->nome = $nome;
        }
        public function getBi():string{
            return $this->bi;
        }
        public function setBi(string $bi):void{
            $this->bi = $bi;
        }
        public function getTelefone():string{
            return $this->telefone;
        }
        public function setTelefone(string $telefone):void{
            $this->telefone = $telefone;
        }
        public function getTipo():string{
            return $this->tipo;
        }
        public function setTipo(string $tipo):void{
            $this->tipo = $tipo;
        }
    }