<?php
session_start();

// Se já estiver logado, vai direto pro perfil
if (isset($_SESSION['usuario_id'])) {
    header("Location: usuario.php");
    exit();
}

// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "wave84");
if ($conn->connect_error) die("Erro: " . $conn->connect_error);
$conn->set_charset("utf8");

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($usuario) || empty($senha)) {
        echo "Preencha usuário e senha.";
        exit();
    }

    // Busca o usuário no banco
    $stmt = $conn->prepare("SELECT id, nome, usuario, senha FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verifica a senha
        if (password_verify($senha, $row['senha'])) {
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario_nome'] = $row['nome'];
            $_SESSION['usuario_login'] = $row['usuario'];

            header("Location: usuario.php");
            exit();
        } else {
            echo "Senha incorreta.";
            exit();
        }
    } else {
        echo "Usuário não encontrado.";
        exit();
    }

    $stmt->close();
}

$conn->close();
?>