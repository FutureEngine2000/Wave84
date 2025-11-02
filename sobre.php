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
  <title>Wave84 - Sobre</title>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="sobre.css" />
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

    <!-- Seção Sobre -->
    <section class="hero" aria-labelledby="sobre-title">
      <h1 id="sobre-title">Sobre o Wave84</h1>
      <p>O Wave84 começou como um trabalho escolar com o objetivo de estudar e apresentar a história dos videogames e sua evolução ao longo dos anos.</p>
      <p>Mesmo sendo um projeto acadêmico, temos a intenção de expandir e transformar o Wave84 em um site completo, dedicado a explorar a cultura gamer de forma mais ampla e profissional.</p>
      <p>Queremos compartilhar curiosidades, falar sobre consoles clássicos, tendências, tecnologias e tudo que conecta os games ao cinema, à música e à arte.</p>
    </section>

    <!-- Seção Galeria -->
    <section class="gallery" aria-labelledby="gallery-title">
      <h2 id="gallery-title">Imagens da História dos Games</h2>

      <div class="gallery-grid">
        <figure class="gallery-item">
          <img src="img/Atari-2600-Wood-4Sw-Set.png" alt="Console Atari 2600 antigo" />
          <figcaption class="img-desc">Atari 2600 — Um dos pioneiros dos consoles caseiros.</figcaption>
        </figure>

        <figure class="gallery-item">
          <img src="img/images.jpg" alt="Controle retrô do Super Nintendo" />
          <figcaption class="img-desc">Controle do Super Nintendo — Ícone dos anos 90.</figcaption>
        </figure>

        <figure class="gallery-item">
          <img src="img/zelda-nes-jogoveio.jpg" alt="Gameplay clássico de The Legend of Zelda" />
          <figcaption class="img-desc">Jogos em 8 bits — The Legend of Zelda.</figcaption>
        </figure>

        <figure class="gallery-item">
          <img src="img/the-legend-of-zelda.jpeg" alt="Linha do tempo dos games com evolução gráfica" />
          <figcaption class="img-desc">A evolução dos consoles — Da pixel art ao fotorrealismo.</figcaption>
        </figure>

        <figure class="gallery-item">
          <img src="img/download.jpg" alt="Ganhador de melhor jogo 2023" />
          <figcaption class="img-desc">Baldur's Gate 3 - conquistou o título de Jogo do Ano em 2023, consolidando-se como um marco na indústria dos games.</figcaption>
        </figure>

        <figure class="gallery-item">
          <img src="img/elden ring.jpg" alt="Elden Ring Nightreign" />
          <figcaption class="img-desc">ELDEN RING NIGHTREIGN — O crepúsculo eterno sobre as Terras Intermédias</figcaption>
        </figure>

        <!-- Novos jogos adicionados -->
        <figure class="gallery-item">
          <img src="img/hollownight.jpg" alt="Hollow Knight Silksong" />
          <figcaption class="img-desc">Hollow Knight: Silksong — A aguardada sequência que leva os jogadores ao reino de Pharloom.</figcaption>
        </figure>

        <figure class="gallery-item">
          <img src="img/dyng.jpg" alt="Dying Light The Beast" />
          <figcaption class="img-desc">Dying Light: The Beast — Nova expansão que introduz mecânicas de sobrevivência radical e criaturas mutantes.</figcaption>
        </figure>

        <figure class="gallery-item">
          <img src="img/silent.jpg" alt="Silent Hill F" />
          <figcaption class="img-desc">Silent Hill F — O renascimento da franquia de terror com uma história ambientada no Japão.</figcaption>
        </figure>
      </div>
    </section>

  </main>

  <!-- Footer -->
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
