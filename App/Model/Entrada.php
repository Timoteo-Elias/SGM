<?php
    namespace Model;

    class Entrada{
        private int $id;
        private string $codigo = '';
        private int $falecido = 0;
        private int $usuario = 0;
        private int $depositante = 0;
        private int $gaveta = 0;
        private int $estado = 0;

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
        public function getFalecido():int{
            return $this->falecido;
        }
        public function setFalecido(int $falecido):void{
            $this->falecido = $falecido;
        }
        public function getUsuario():int{
            return $this->usuario;
        }
        public function setUsuario(int $usuario):void{
            $this->usuario = $usuario;
        }
        public function getDepositante():int{
            return $this->depositante;
        }
        public function setDepositante(int $depositante):void{
            $this->depositante = $depositante;
        }
        public function getGaveta():int{
            return $this->gaveta;
        }
        public function setGaveta(int $gaveta):void{
            $this->gaveta = $gaveta;
        }
        public function getEstado():int{
            return $this->estado;
        }
        public function setEstado(int $estado):void{
            $this->estado = $estado;
        }
        
    }