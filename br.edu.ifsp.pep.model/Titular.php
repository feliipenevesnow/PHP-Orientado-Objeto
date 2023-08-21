<?php

class Titular {

    private Integer $id;
    private String $nome;
    private String $email;
    private String $endereco;

    public function __construct(Integer $id, String $nome, String $email, String $endereco) {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->endereco = $endereco;
    }

    public function __destruct() {
        echo 'Destroying: ', $this->name, PHP_EOL;
    }

    public function getId(): Integer {
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

    public function setId(Integer $id): void {
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
