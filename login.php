<?php
session_start();

    if (isset($_SESSION['usuario_id'])) {
        header("Location: painel.php");
        exit();
    }
    
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "wave84";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($usuario) || empty($senha)) {
        echo "Preencha usuário e senha.";
        exit();
    }

    $stmt = $conn->prepare("SELECT id, nome, usuario, senha FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($senha, $row['senha'])) {
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario_nome'] = $row['nome'];
            $_SESSION['usuario_login'] = $row['usuario'];

            header("Location: painel.php");
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