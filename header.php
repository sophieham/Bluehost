<head>
  <link href="headerfooter.css"rel="stylesheet">
  <link rel="icon" href="images/logoico.png" />
</head>

<body>
<a href="index.php"> <img src="images/logo.png" height="106px" width="444px" class="logo"> </a>
<div class="nav">
    <ul>
      <li> <a href="index.php"> Accueil </a> </li>
      <li> <a href="impression.php"> Impression </a> </li>
      <li> <a href="galerie.php"> Galerie </a> </li>
      <?php
      session_start();
      if(isset($_SESSION['username']))
      {
        echo '<li> <a href="profil.php"> Mon Profil </a> </li>';
      }
        else echo '<li> <a href="connexion.php"> Connexion </a> </li>';
      ?>
    </ul>
</div>

</body>
