<?php
session_start();

// Se não estiver logado, você pode deixar o perfil padrão ou esconder
$usuario = null;
$avatar = "img/user-icon-on-transparent-background-free-png.webp"; // default

if (isset($_SESSION['usuario_id'])) {
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "wave84";

    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
    if ($conn) {
        $id = $_SESSION['usuario_id'];
        $stmt = $conn->prepare("SELECT usuario, avatar FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $usuario = $row['usuario'];
            if (!empty($row['avatar'])) {
                $avatar = $row['avatar'];
            }
        }
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wave84 - Comunidade</title>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="comunidade.css" />
  <link rel="icon" href="favicon.ico" type="image/x-icon"> 
</head>
<body>

 <!-- Navbar simples -->
    <header class="navbar">
    
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="hamburguer">
            <span></span>
            <span></span>
            <span></span>
        </label>
        <div class="logo">Wave84</div>
        <nav>
           <div>
            <ul class="nav-links">
                <li><a href="index.php">Início</a></li>
                <li><a href="sobre.php">Sobre</a></li>
                <li><a href="historia.php">Histórias</a></li>
                <li><a href="comunidade.php">Comunidade</a></li>
                <li><a href="registro.html">Cadastre-se</a></li>
                <li><a href="login.html">Login</a></li>
                
                <form action="usuario.php">

               <form action="usuario.php">
                
                <div class="ft">
<li>
  <a href="usuario.php" class="user-profile">
    <img src="<?php echo htmlspecialchars($avatar); ?>" width="50" height="50" style="border-radius:50%;" />
    <?php if ($usuario): ?>
      <span style="margin-left:8px; color:#fff;"><?php echo htmlspecialchars($usuario); ?></span>
    <?php endif; ?>
  </a>
</li>
</div>

                </form>
            </ul>
        </nav>
    </header>

  <!-- Conteúdo principal -->
  <main class="main-content">
    <section class="community-intro">
      <h1>Junte-se à nossa Comunidade no Discord!</h1>
      <p>
        No Wave84, acreditamos que os games unem pessoas. Venha conversar, trocar dicas,
        participar de eventos, competições e fazer parte de um grupo apaixonado por videogames!
      </p>
      <p>
        Nosso servidor no Discord é um espaço seguro e acolhedor para todos os níveis,
        desde iniciantes até veteranos.
      </p>
      <a href="https://discord.gg/j2nqffrf" target="_blank" class="cta-btn">
        <i class='bx bxl-discord'></i> Entrar no Discord
      </a>
    </section>

    <section class="community-rules">
      <h2>Regras da Comunidade</h2>
      <ul>
        <li>Respeite todos os membros.</li>
        <li>Evite spam e conteúdos ofensivos.</li>
        <li>Use canais adequados para cada assunto.</li>
        <li>Divirta-se e ajude os outros!</li>
      </ul>
      
    </section>
  </main>
 <section class="user-phrase-section">
  <div class="user-phrase-card" id="userPhraseCard">
    <p><i class="fa-solid fa-comment-dots"></i> <span id="userPhraseText">Compartilhe também sua frase de efeito!</span></p>
  </div>
</section>



 <footer class="footer">
        <div class="footer-content">
            <div class="logo">Wave84</div>
            <p>Preservando a história dos video games para as futuras gerações</p>
            <div class="social-links">
                <a href="https://www.instagram.com/wave84_/"><i class="fab fa-instagram"></i></a>
                <a href="https://discord.gg/j2nqffrf"><i class="fab fa-discord"></i></a>
                <a href="https://github.com/FutureEngine2000"><i class="fab fa-github"></i></a>
            </div>
            <p>&copy; 2025 Wave84. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>

</html>
