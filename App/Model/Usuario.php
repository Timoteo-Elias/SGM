<?php 
namespace Model;

class Usuario
{
    private int $id;
    private string $nome;
    private string $email;
    private string $perfil;
    private string $imagem;
    // ID
    public function getId():int
    {
        return $this->id;
    }

    public function setId(int $id):void
    {
        $this->id = $id;
    }

    // NOME
    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    // EMAIL
    public function getEmail():string
    {
        return $this->email;
    }

    public function setEmail(string $email):void
    {
        $this->email = $email;
    }

    // PERFIL
    public function getPerfil():string
    {
        return $this->perfil;
    }

    public function setPerfil(string $perfil):void
    {
        $this->perfil = $perfil;
    }

    // SENHA
    public function getSenha():string
    {
        return $this->senha;
    }

    public function setSenha(string $senha):void
    {
        $this->senha = $senha;
    }

    // IMAGEM
    public function getImagem():string
    {
        return $this->imagem;
    }

    public function setImagem(string $imagem):void
    {
        $this->imagem = $imagem;
    }
}
