# Projeto PHP + MySQL (PDO)

Estrutura pronta para versionar no GitHub sem expor credenciais do banco de dados.

## Estrutura

```
projeto-php/
├── config/
│   ├── env.php          # Carrega variáveis do .env
│   └── database.php     # Conexão PDO (Singleton)
├── src/
│   └── UsuarioRepository.php   # Exemplo de CRUD
├── public/
│   └── index.php         # Ponto de entrada de exemplo
├── .env.example           # Modelo de configuração (SEM dados reais)
├── .gitignore              # Garante que .env real nunca seja commitado
└── README.md
```

## Como usar

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/seu-repositorio.git
   cd seu-repositorio
   ```

2. Copie o arquivo de exemplo e preencha com suas credenciais reais:
   ```bash
   cp .env.example .env
   ```
   Edite o `.env` com os dados do seu banco (host, usuário, senha, etc). Esse
   arquivo **nunca** deve ser commitado — ele já está no `.gitignore`.

3. Crie a tabela de exemplo no seu banco MySQL:
   ```sql
   CREATE TABLE usuarios (
       id INT AUTO_INCREMENT PRIMARY KEY,
       nome VARCHAR(100) NOT NULL,
       email VARCHAR(150) NOT NULL UNIQUE,
       criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
   );
   ```

4. Rode um servidor local de teste:
   ```bash
   php -S localhost:8000 -t public
   ```

5. Acesse `http://localhost:8000` para ver o JSON com os usuários cadastrados.

## Segurança

- As credenciais ficam **fora do código**, em `.env` (ignorado pelo Git).
- Todas as queries usam **prepared statements** (proteção contra SQL Injection).
- Em produção, oculte mensagens de erro do PDO (não exiba `$e->getMessage()`
  diretamente ao usuário).
