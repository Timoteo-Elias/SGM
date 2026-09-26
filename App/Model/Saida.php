<?php
    namespace Model;

    class Saida{
        private int $id_saida;
        private string $codigo = '';
        private int $falecido = 0;
        private int $usuario = 0;
        private string $nome_receptor = '';
        private string $bi_receptor = '';
        private int $estado = 0;

        public function getIdSaida(): int {
            return $this->id_saida;
        }

        public function setIdSaida(int $id_saida): void {
            $this->id_saida = $id_saida;
        }

        public function getCodigo(): string {
            return $this->codigo;
        }

        public function setCodigo(string $codigo): void {
            $this->codigo = $codigo;
        }

        public function getFalecido(): int {
            return $this->falecido;
        }

        public function setFalecido(int $falecido): void {
            $this->falecido = $falecido;
        }

        public function getUsuario():int{
            return $this->usuario;
        }
        public function setUsuario(int $usuario):void{
            $this->usuario = $usuario;
        }

        public function getNomeReceptor(): string {
            return $this->nome_receptor;
        }

        public function setNomeReceptor(string $nome_receptor): void {
            $this->nome_receptor = $nome_receptor;
        }

        public function getBiReceptor(): string {
            return $this->bi_receptor;
        }

        public function setBiReceptor(string $bi_receptor): void {
            $this->bi_receptor = $bi_receptor;
        }

        public function getEstado(): int {
            return $this->estado;
        }

        public function setEstado(int $estado): void {
            $this->estado = $estado;
        }
    }