<?php
// Conexão ao banco de dados
include "conexao.php";

if (!$conexao) {
    die("Erro de conexão: " . print_r(sqlsrv_errors(), true));
}
echo "Conectado ao banco >>>>>>>>";

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera e sanitiza os dados do formulário
    $nome = isset($_POST['nome']) ? substr(trim($_POST['nome']), 0, 50) : '';
    $cpf = isset($_POST['cpf']) ? substr(trim($_POST['cpf']), 0, 14) : '';
    $endereco = isset($_POST['endereco']) ? substr(trim($_POST['endereco']), 0, 100) : '';
    $cidade = isset($_POST['cidade']) ? substr(trim($_POST['cidade']), 0, 50) : '';
    $email = isset($_POST['email']) ? substr(trim($_POST['email']), 0, 100) : '';
    
    // Verifica se a senha foi enviada
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        die("Erro: A senha não foi enviada!");
    }
    
    // Criptografando a senha
    $senha = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Debug: Verificar se a senha foi gerada corretamente
    var_dump($senha);
    
    // Verificar se o nome já está cadastrado no banco
    $sql = "SELECT Nome FROM dbo.Usuario WHERE Nome = ?";
    $params = array($nome);
    $stmt = sqlsrv_query($conexao, $sql, $params);

    if ($stmt === false) {
        die("Erro na consulta: " . print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo "Nome já cadastrado!<br>";
    } else {
        // Inserir os dados no banco
        $sql = "INSERT INTO dbo.Usuario (Nome, Cpf, Endereco, Cidade, Email, Senha) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $params = array($nome, $cpf, $endereco, $cidade, $email, $senha);
        $stmt = sqlsrv_query($conexao, $sql, $params);

        if ($stmt) {
            echo "Usuário cadastrado com sucesso!<br>";
        } else {
            echo "Erro ao cadastrar usuário: " . print_r(sqlsrv_errors(), true);
        }
    }
}
?>