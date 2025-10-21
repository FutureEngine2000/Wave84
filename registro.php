<?php
session_start();
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "wave84";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if (!$conn) {
      die("Falha na Conexão: " . mysqli_connect_error());
    }

    mysqli_set_charset($conn, 'utf8');

    $mensagem = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nome = ($_POST['nome']);
        $usuario = ($_POST['usuario']);
        $senha = ($_POST['senha']);
        $email = ($_POST['email']);
        $telefone = ($_POST['telefone']);
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        // Caso algum dos campos esteja vazio retorna uma mensagem de erro
        if (empty($nome) || empty($usuario) || empty($senha) || empty($email) || empty($telefone)){
          die("Por favor, preencha todos os campos.");
        }

        $stmt = $conn->prepare("INSERT INTO usuarios (nome, usuario, senha, email, telefone) VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("sssss", $nome, $usuario, $senha_hash, $email, $telefone);

        if ($stmt->execute()){
          echo "Cadastro realizado! Redirecionando...";
          sleep(2);
          header("Location: login.html");
          exit();
        } else {
          $mensagem =  "<div class='erro'>Erro ao cadastrar: " . $stmt->error . "</div>";
        }

    $stmt->close();
    }

$conn->close();
?>