<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "wave84");
if ($conn->connect_error) die("Erro: " . $conn->connect_error);
$conn->set_charset("utf8");

// Pega dados do usuário logado
$id = $_SESSION['usuario_id'];
$stmt = $conn->prepare("SELECT nome, usuario, frase, avatar FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$dados = $result->fetch_assoc();

$nome = $dados['nome'];
$usuario = $dados['usuario'];
$frase = $dados['frase'] ?? "Sua frase aqui";
$avatar = $dados['avatar'] ?? "https://via.placeholder.com/120";

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="stylesheet" href="usuario.css">
<title>Seu Perfil</title>
</head>
<body>
<h1>Editor de Perfil</h1>
<div class="container">
  <!-- Formulário -->
  <div class="form-area">
    <form action="salvar_perfil.php" method="POST" enctype="multipart/form-data">
      <label for="avatarInput">Foto de perfil:</label>
      <input type="file" id="avatarInput" name="avatar" accept="image/*" />

      <label for="usernameInput">Nome de usuário:</label>
      <input type="text" id="usernameInput" name="username" value="<?php echo htmlspecialchars($usuario); ?>" />

      <label for="taglineInput">Frase de efeito:</label>
      <input type="text" id="taglineInput" name="tagline" value="<?php echo htmlspecialchars($frase); ?>" />

      <button class="save-btn" type="submit">Salvar Perfil</button>
    </form>
  </div>

  <!-- Cartão de perfil -->
  <div class="profile-card">
    <img id="avatarPreview" src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" />
    <div class="username" id="usernameDisplay"><?php echo htmlspecialchars($usuario); ?></div>
    <div class="tagline" id="taglineDisplay">"<?php echo htmlspecialchars($frase); ?>"</div>
  </div>
</div>

<a href="index.php" class="seta-bonita">← Voltar</a>
</body>
</html>