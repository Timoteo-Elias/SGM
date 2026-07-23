<?php
    require_once __DIR__ . '/../../config/conexao.php';
    use Model\Falecido;

    class FalecidoDao{

        public function create(Falecido $f){
            $sql = "INSERT INTO falecidos(codigo, nome_completo, sexo, data_nascimento, estado_civil, nacionalidade, bi, pai, mae, endereco, observacoes)
            VALUES(?,?,?,?,?,?,?,?,?,?,?)";
            $result = Connect::getConn()->prepare($sql);

            $result->bindValue(1, $f->getCodigo());
            $result->bindValue(2, $f->getNome());
            $result->bindValue(3, $f->getSexo());
            $result->bindValue(4, $f->getNascimento(), $f->getNascimento() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $result->bindValue(5, $f->getEstadoCivil(), $f->getEstadoCivil() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $result->bindValue(6, $f->getNacionalidade(), $f->getNacionalidade() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $result->bindValue(7, $f->getBi(), $f->getBi() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $result->bindValue(8, $f->getPai(), $f->getPai() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $result->bindValue(9, $f->getMae(), $f->getMae() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $result->bindValue(10, $f->getEndereco(), $f->getEndereco() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $result->bindValue(11, $f->getObs());

            return $result->execute();
        }
        public function read(){
            $sql = "SELECT *, TIMESTAMPDIFF(YEAR, data_nascimento, NOW()) AS idade FROM falecidos";
            $res = Connect::getConn()->query($sql);
            $falecido = $res->rowCount()>0 ? $res->fetchAll(PDO::FETCH_ASSOC) : [];
            return $falecido;
        }
        public function readTotal(){
            $sql = "SELECT COUNT(*) AS total_falecidos FROM falecidos";
            $res = Connect::getConn()->query($sql);
            $total_falecido = $res->rowCount()>0 ? $res->fetch() : [];
            return $total_falecido;
        }

        public function delete($id){
            $sql = "DELETE FROM falecidos WHERE id_falecido = ?";
            $res = Connect::getConn()->prepare($sql);
            $res->bindParam(1, $id);
            $res->execute();

        }

        public function getById($id){
            $sql = "SELECT * FROM falecidos WHERE id_falecido = $id";
            $res = Connect::getConn()->query($sql);
            $falecido = $res->rowCount()>0 ? $res->fetch() : [];
            return $falecido;
        }

        public function update(Falecido $f){
            $sql = "UPDATE falecidos SET codigo = ?, nome_completo = ?, sexo = ?, data_nascimento = ?, estado_civil = ?, nacionalidade = ?, bi = ?, pai = ?, mae = ?, endereco = ?, observacoes = ? WHERE id_falecido = ?";
            $res = Connect::getConn()->prepare($sql);
            $res->bindValue(1, $f->getCodigo());
            $res->bindValue(2, $f->getNome());
            $res->bindValue(3, $f->getSexo());
            $res->bindValue(4, $f->getNascimento(), $f->getNascimento() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $res->bindValue(5, $f->getEstadoCivil(), $f->getEstadoCivil() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $res->bindValue(6, $f->getNacionalidade(), $f->getNacionalidade() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $res->bindValue(7, $f->getBi(), $f->getBi() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $res->bindValue(8, $f->getPai(), $f->getPai() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $res->bindValue(9, $f->getMae(), $f->getMae() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $res->bindValue(10, $f->getEndereco(), $f->getEndereco() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $res->bindValue(11, $f->getObs());
            $res->bindValue(12, $f->getId());

            $res->execute();
        }
        
    }