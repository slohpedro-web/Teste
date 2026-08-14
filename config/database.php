<?php

require_once __DIR__ . '/env.php';

/**
 * Classe responsável por criar e fornecer a conexão PDO com o banco.
 * Usa Singleton para reaproveitar a mesma conexão durante a requisição.
 */
class Database
{
    private static ?PDO $instancia = null;

    public static function getConexao(): PDO
    {
        if (self::$instancia === null) {
            $host    = getenv('DB_HOST') ?: 'localhost';
            $porta   = getenv('DB_PORT') ?: '3306';
            $banco   = getenv('DB_NAME') ?: '';
            $usuario = getenv('DB_USER') ?: '';
            $senha   = getenv('DB_PASS') ?: '';
            $charset = getenv('DB_CHARSET') ?: 'utf8mb4';

            $dsn = "mysql:host={$host};port={$porta};dbname={$banco};charset={$charset}";

            $opcoes = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instancia = new PDO($dsn, $usuario, $senha, $opcoes);
            } catch (PDOException $e) {
                // Em produção, evite expor $e->getMessage() diretamente ao usuário.
                die('Erro na conexão com o banco de dados: ' . $e->getMessage());
            }
        }

        return self::$instancia;
    }
}
