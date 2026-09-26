<?php
    namespace Model;
    class Config{
        private int $id;
        private string $nome = '';
        private string $telefone = '';
        private string $email = '';
        private string $dias_permanencia = '';
        private string $endereco = '';
        private string $data_atualizacao = '';

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

        public function getTelefone():string{
            return $this->telefone;
        }

        public function setTelefone(string $telefone):void{
            $this->telefone = $telefone;
        }

        public function getEmail():string{
            return $this->email;
        }

        public function setEmail(string $email):void{
            $this->email = $email;
        }

        public function getDiasPermanencia():string{
            return $this->dias_permanencia;
        }

        public function setDiasPermanencia(string $dias_permanencia):void{
            $this->dias_permanencia = $dias_permanencia;
        }

        public function getEndereco():string{
            return $this->endereco;
        }

        public function setEndereco(string $endereco):void{
            $this->endereco = $endereco;
        }
    }