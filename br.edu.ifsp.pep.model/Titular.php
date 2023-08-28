<?php

class Titular {

    private int $id;
    private String $nome;
    private String $email;
    private String $endereco;
    
    public function __construct(int $id, String $nome, String $email, String $endereco) {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->endereco = $endereco;
    }

    public function __destruct() {
 
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNome(): String {
        return $this->nome;
    }

    public function getEmail(): String {
        return $this->email;
    }

    public function getEndereco(): String {
        return $this->endereco;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setNome(String $nome): void {
        $this->nome = $nome;
    }

    public function setEmail(String $email): void {
        $this->email = $email;
    }

    public function setEndereco(String $endereco): void {
        $this->endereco = $endereco;
    }
}
