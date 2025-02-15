<?php
    // Definindo variáveis do banco
    $nomeServidor = "DESKTOP-CL6M4CP\\SQLBRENO"; // Dobre a barra invertida para evitar problemas
    
    $conectioninfo = array(
        "Database" => "Login",  
        "TrustServerCertificate" => true  // Evita problemas com certificados SSL
    );

    // Criando conexão com autenticação do Windows
    $conexao = sqlsrv_connect($nomeServidor, $conectioninfo);

    // Testando conexão
    if ($conexao) {
        echo "Conexao feita com sucesso!";
    } else {
        echo "Conexao nao foi feita";
        die(print_r(sqlsrv_errors(), true));
    }
?>
