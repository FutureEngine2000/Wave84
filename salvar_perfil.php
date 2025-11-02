<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Conexão
$conn = new mysqli("localhost", "root", "", "wave84");
if ($conn->connect_error) die("Erro: " . $conn->connect_error);

// Recebe os dados
$novo_usuario = $_POST['username'] ?? '';
$nova_frase = $_POST['tagline'] ?? '';
$caminho_avatar = null;

// Upload da imagem
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $pasta = "uploads/";
    if (!is_dir($pasta)) mkdir($pasta, 0777, true);

    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $nome_arquivo = uniqid("avatar_") . "." . $ext;
    $caminho_completo = $pasta . $nome_arquivo;

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $caminho_completo)) {
        $caminho_avatar = $caminho_completo;
    }
}

// Atualiza no banco
if ($caminho_avatar) {
    $sql = "UPDATE usuarios SET usuario = ?, frase = ?, avatar = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $novo_usuario, $nova_frase, $caminho_avatar, $usuario_id);
} else {
    $sql = "UPDATE usuarios SET usuario = ?, frase = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $novo_usuario, $nova_frase, $usuario_id);
}

if ($stmt->execute()) {
    $_SESSION['usuario_login'] = $novo_usuario;
    echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href='usuario.php';</script>";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>