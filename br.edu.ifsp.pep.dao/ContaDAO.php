<?php

class ContaDAO {

    public function inserir() {
        try {
            $conn = new PDO('mysql:host=localhost;dbname=meuBancoDeDados', $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare('');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                print_r($row);
            }
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
}
