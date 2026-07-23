<?php 
namespace Model;

class Falecido
{
    private int $id;
    private string $codigo;
    private string $nome_completo;
    private string $sexo;
    private ?string $nascimento = null;
    private int $idade;
    private ?string $nacionalidade = null;
    private ?string $bi = null;
    private ?string $pai = null;
    private ?string $mae = null;
    private ?string $estado_civil = null;
    private ?string $endereco = null;
    private string $obs;
    private string $criado_em;
    private string $atualizado_em;

    // ID
    public function getId():int
    {
        return $this->id;
    }

    public function setId(int $id):void
    {
        $this->id = $id;
    }

    // CODIGO
    public function getCodigo():string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): void
    {
        $this->codigo = $codigo;
    }

    // NOME
    public function getNome(): string
    {
        return $this->nome_completo;
    }

    public function setNome(string $nome_completo): void
    {
        $this->nome_completo = $nome_completo;
    }

    // SEXO
    public function getSexo():string
    {
        return $this->sexo;
    }

    public function setSexo(string $sexo):void
    {
        $this->sexo = $sexo;
    }

    // NASCIMENTO
    public function getNascimento():?string
    {
        return $this->nascimento;
    }

    public function setNascimento(?string $nascimento):void
    {
        $this->nascimento = $nascimento;
    }

    // IDADE
    public function getIdade():int
    {
        if(empty($this->nascimento)) {
            return 0; // Caso seja um corpo não identificado
        }
    
        $dataNascimento = new \DateTime($this->nascimento);
        $hoje = new \DateTime();
    
        // Faz a diferença entre as datas e extrai os anos (y)
        return $dataNascimento->diff($hoje)->y;
    }

    public function setIdade(int $idade):void
    {
        $this->idade = $idade;
    }

    // ESTADO CIVIL
    public function getEstadoCivil():?string
    {
        return $this->estado_civil;
    }

    public function setEstadoCivil(?string $estado_civil):void
    {
        $this->estado_civil = $estado_civil;
    }

    // NACIONALIDADE
    public function getNacionalidade():?string
    {
        return $this->nacionalidade;
    }

    public function setNacionalidade(?string $nacionalidade):void
    {
        $this->nacionalidade = $nacionalidade;
    }

    // BI
    public function getBi():?string
    {
        return $this->bi;
    }

    public function setBi(?string $bi):void
    {
        $this->bi = $bi;
    }

    // PAI
    public function getPai():?string
    {
        return $this->pai;
    }

    public function setPai(?string $pai):void
    {
        $this->pai = $pai;
    }

    // MÃE
    public function getMae():?string
    {
        return $this->mae;
    }

    public function setMae(?string $mae):void
    {
        $this->mae = $mae;
    }

    // ENDEREÇO
    public function getEndereco():?string
    {
        return $this->endereco;
    }

    public function setEndereco(?string $endereco):void
    {
        $this->endereco = $endereco;
    }
    // OBSERVAÇÕES
    public function getObs():string
    {
        return $this->obs;
    }

    public function setObs(string $obs):void
    {
        $this->obs = $obs;
    }

    // CRIADO EM
    public function getCriadoEm():string
    {
        return $this->criado_em;
    }

    public function setCriadoEm(string $criado_em):void
    {
        $this->criado_em = $criado_em;
    }

    // ATUALIZADO EM
    public function getAtualizadoEm():string
    {
        return $this->atualizado_em;
    }

    public function setAtualizadoEm(string $atualizado_em):void
    {
        $this->atualizado_em = $atualizado_em;
    }
}
