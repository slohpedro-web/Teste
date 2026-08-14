<?php

require_once __DIR__ . '/../config/database.php';

/**
 * Exemplo de CRUD usando PDO com prepared statements
 * (protegido contra SQL Injection).
 *
 * Estrutura de tabela esperada:
 *
 * CREATE TABLE usuarios (
 *     id INT AUTO_INCREMENT PRIMARY KEY,
 *     nome VARCHAR(100) NOT NULL,
 *     email VARCHAR(150) NOT NULL UNIQUE,
 *     criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
 * );
 */
class UsuarioRepository
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = Database::getConexao();
    }

    public function listarTodos(): array
    {
        $stmt = $this->conexao->query('SELECT * FROM usuarios ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public function buscarPorId(int $id): array|false
    {
        $stmt = $this->conexao->prepare('SELECT * FROM usuarios WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function criar(string $nome, string $email): int
    {
        $stmt = $this->conexao->prepare(
            'INSERT INTO usuarios (nome, email) VALUES (:nome, :email)'
        );
        $stmt->execute([
            'nome'  => $nome,
            'email' => $email,
        ]);

        return (int) $this->conexao->lastInsertId();
    }

    public function atualizar(int $id, string $nome, string $email): bool
    {
        $stmt = $this->conexao->prepare(
            'UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id'
        );

        return $stmt->execute([
            'nome'  => $nome,
            'email' => $email,
            'id'    => $id,
        ]);
    }

    public function deletar(int $id): bool
    {
        $stmt = $this->conexao->prepare('DELETE FROM usuarios WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
