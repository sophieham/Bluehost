<html lang="fr">
<head>
 <title>Bluehost</title>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link  href="compte.css"rel="stylesheet">
</head>
<body class="bcompte">
<?php
require 'header.php';
require 'dbConfig.php';
?>
<h1> Félicitations, vous venez de créer votre compte. </h1>
<h2> Vos identifiants vont vous être envoyés par mail. <br> Vous pouvez maintenant profiter de toutes les fonctionnalités du site!</h2>

<?php
$req = "SELECT id_img, chemin, chemin_mini, type, nom, bonne_note, mauvaise_note, user.username FROM image INNER JOIN user ON image.id_user = user.id_user WHERE nom IS NOT null AND private=0 ORDER BY id_img DESC" ;
$col = $db->query($req) -> fetchAll(); // $col[x][y] x -> balayage de haut en bas ; y -> change de colonne
echo '<fieldset class="compte"> <legend> Les 3 dernières fichiers mis en ligne par des utilisateurs </legend>';
for($i=0; $i<3; $i++)
{
  $id=$col[$i][0];
  $chemin=$col[$i][1];
  $chemin_mini=$col[$i][2];
  $type=$col[$i][3];
  $titre=$col[$i][4];
  $bon=$col[$i][5]; // note du fichier
  $mauvais=$col[$i][6]; // note du fichier
  $auteur=$col[$i][7];
  echo '<div class="boxg">';
    switch($type) { // on cherche le type de l'image pour afficher le fichier avec la bonne balise
        case preg_match('/(image)/', $type)==1:
        echo "<a href='apercu.php?id=$id'><img src='$chemin' alt='photo' id='imagedl'></a>";
        break;
      case preg_match('/(audio)/', $type)==1:
        echo "<audio controls> <source src='$chemin' autostart='0' class='gaudio'> </audio>";
        break;
      case preg_match('/(video)/', $type)==1:
        echo "<video class='gvideo' src='$chemin' autostart='0' controls='1'></video>";
        break;
    }
    echo '
    <div class="desc">
      <img src="images/ico/auteur.png" width="20px" height="20px" alt="auteur"> Auteur: '.$auteur.' <br>
      <img src="images/ico/desc.png" width="20px" height="20px" alt="titre"> Titre: '.$titre.' <br>
      '.$bon.' <img src="images/ico/thumbsup.png" alt="note" width="35px"><img src="images/ico/thumbsdown.png" alt="note" width="35px"> '.$mauvais.'
    </div>
  </div>';
}
echo '</fieldset>';

require "footer.php"
?>
</body>
</html>
