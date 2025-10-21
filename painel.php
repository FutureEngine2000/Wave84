<?php
session_start();

// Redireciona se não estiver logado
if (!isset($_SESSION['usuario_login'])) {
    header("Location: login.php");
    exit();
}

// Atualiza nome de usuário
if (isset($_POST['atualizar_nome'])) {
    $_SESSION['usuario'] = htmlspecialchars($_POST['novo_nome']);
}

// Upload de foto
$foto_perfil = 'default.png';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $novo_nome = "perfil_" . session_id() . "." . $extensao;
    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/$novo_nome");
    $_SESSION['foto'] = $novo_nome;
}
if (isset($_SESSION['foto'])) {
    $foto_perfil = $_SESSION['foto'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Painel do Usuário</title>
  <link rel="stylesheet" href="painel.css"/>
</head>
<body>
  <header class="navbar">
    <div class="logo">Wave84</div>
    <nav>
      <ul class="nav-links">
        <li><a href="index.html" class="active">Início</a></li>
        <li><a href="sobre.html">Sobre</a></li>
        <li><a href="historia.html">Histórias</a></li>
        <li><a href="comunidade.html">Comunidade</a></li>
        <li><a href="registro.php">Registro</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <main class="painel">
    <section class="perfil">
      <img src="uploads/<?php echo $foto_perfil; ?>" alt="Foto de Perfil" class="foto-perfil" />
      <form method="POST" enctype="multipart/form-data">
        <label>Mudar foto:</label>
        <input type="file" name="foto" accept="image/*">
        <button type="submit">Enviar</button>
      </form>
      <form method="POST">
        <label>Alterar nome de usuário:</label>
        <input type="text" name="novo_nome" placeholder="Novo nome" required />
        <button type="submit" name="atualizar_nome">Atualizar Nome</button>
      </form>
    </section>
  </main>
</body>
</html>
