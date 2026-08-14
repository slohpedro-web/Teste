<?php

require_once __DIR__ . '/../src/UsuarioRepository.php';

$repositorio = new UsuarioRepository();

// Exemplo: criar um usuário
// $id = $repositorio->criar('Maria Silva', 'maria@exemplo.com');

// Exemplo: listar todos
$usuarios = $repositorio->listarTodos();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
