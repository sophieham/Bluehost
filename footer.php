<div id="divfooter">
<ul class="footer left">
  <li> <img src="images/logo.png" width="220px" height="50px">
  <li> 103 Avenue du Maru </li>
  <li> 37000 Tours </li>
</ul>

<ul class="footer">
  <li> Plan du site </li> <br>
  <li> <a href="index.php"> Heberger un fichier </a> </li>
  <li> <a href="galerie.php"> Visionner la galerie </a> </li>
  <li> <a href="impression.php"> Impression de photos </a> </li>
</ul>

<ul class="footer">
  <li> Espace perso </li> <br>
  <?php
  if(isset($_SESSION['username']))
  {
    echo '<li><a href="profil.php">Voir ma galerie</a></li>
          <li><a href="moncompte.php">Gérer mon compte</a></li>
          <li><a href="deconnexion.php">Se déconnecter</a></li> ';
  }
  else
  {
    echo '<li> <a href="inscription.php">S\'inscrire</a></li>
          <li>  <a href="connexion.php"> Se connecter </a> </li>
          <li>  <a href="reset.php"> Mot de passe oublié </a> </li> ';
  }
?>
</ul>
<div id="down">
</div>
</div>
