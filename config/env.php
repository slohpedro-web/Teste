<?php

/**
 * Carrega variáveis de ambiente de um arquivo .env para getenv()/$_ENV.
 * Simples, sem dependências externas (sem precisar de composer).
 */
function carregarEnv(string $caminhoArquivo): void
{
    if (!file_exists($caminhoArquivo)) {
        // Se não existir .env, assume que as variáveis já estão
        // definidas no ambiente do servidor (ex: Docker, hospedagem, etc).
        return;
    }

    $linhas = file($caminhoArquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($linhas as $linha) {
        $linha = trim($linha);

        // Ignora comentários
        if ($linha === '' || str_starts_with($linha, '#')) {
            continue;
        }

        if (!str_contains($linha, '=')) {
            continue;
        }

        [$chave, $valor] = explode('=', $linha, 2);
        $chave = trim($chave);
        $valor = trim($valor);

        // Remove aspas, se houver
        $valor = trim($valor, "\"'");

        if (!array_key_exists($chave, $_ENV)) {
            putenv("$chave=$valor");
            $_ENV[$chave] = $valor;
        }
    }
}

carregarEnv(__DIR__ . '/../.env');
