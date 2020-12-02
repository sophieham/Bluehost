<html lang="fr">
<head>
 <link  href="compte.css" rel="stylesheet">
</head>
<body class="bcompte">
<?php
require "header.php";
require "dbConfig.php";
if((isset($_SESSION['username'])))
{
    echo '<h1> Bienvenue '.$_SESSION['username'].' </h1>
          <h2> <a href="moncompte.php"> Modifier les paramètres de mon compte </a> </h2>';
    $req = 'SELECT id_img, chemin, chemin_mini, type, nom, bonne_note, mauvaise_note, user.username FROM image INNER JOIN user ON image.id_user = user.id_user WHERE nom IS NOT null AND image.id_user='.$_SESSION['id_user'].'' ;
    $col = $db->query($req) -> fetchAll(); // $col[x][y] x -> balayage de haut en bas ; y -> change de colonne
    echo '<fieldset class="compte">
          <legend> Galerie personnelle </legend>';
    $req2 = 'SELECT COUNT(*) as nbImage FROM image WHERE nom IS NOT null AND id_user='.$_SESSION['id_user'].'';
    $count = $db->query($req2)-> fetch();
    $nbImage = $count['nbImage'];
	if($nbImage>1){
    for($i=0; $i<$nbImage; $i++)
    {
      echo '<div class="boxg">';
      $id=$col[$i][0];
      $chemin=$col[$i][1];
      $chemin_mini=$col[$i][2];
      $type=$col[$i][3];
      switch($type)
      {
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
        $auteur=$col[$i][7];
        $titre=$col[$i][4];
        $bon=$col[$i][5];
        $mauvais=$col[$i][6];
        echo '<div class="desc">
              <img src="images/ico/auteur.png" width="20px" height="20px" alt="auteur"> Auteur: '.$auteur.' <br>
              <img src="images/ico/desc.png" width="20px" height="20px" alt="titre"> Titre: '.$titre.' <br>
              '.$bon.' <img src="images/ico/thumbsup.png" alt="note" width="35px"><img src="images/ico/thumbsdown.png" alt="note" width="35px"> '.$mauvais.'
              </div>
            </div>';
    }
    echo '</fieldset>';
	}
} else header('Location: index.php');


require "footer.php";
?>
</body>
</html>
