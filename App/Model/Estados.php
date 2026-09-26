<?php
    namespace Model;

    class Estados{
        private int $id;
        private string $nome = '';
        private string $tipo = '';
        private string $descricao = '';

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

        public function getTipo():string{
            return $this->tipo;
        }

        public function setTipo(string $tipo):void{
            $this->tipo = $tipo;
        }

        public function getDescricao():string{
            return $this->descricao;
        }

        public function setDescricao(string $descricao):void{
            $this->descricao = $descricao;
        }

    }