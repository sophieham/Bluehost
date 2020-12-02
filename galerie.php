<html lang="fr">
<head>
 <title>Bluehost</title>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link  href="style.css" rel="stylesheet">
</head>
<body class="bgalerie">
<?php
require 'dbConfig.php';
require "header.php";
?>
<header class="header">
  <h2>Retrouvez tous les fichiers hebergées sur Bluehost! </h2>
  <p> <img src="images/ico/info.png" width="18px" height="18px" alt="info" class="infoimg"> Cliquez sur les images pour les afficher dans l'aperçu </p>
  <div class="searchbar">
    <form method="get">
      Recherche par:<input type="radio" name="choix" value="user.username" required>Auteur<input type="radio" name="choix" value="nom" width="25px"required>Titre<input type="text" name="search" placeholder="Entrez les termes de votre recherche ici" pattern="[\w 'âêéèàùô]{2,30}" size="40" required>
      Format:<input type="radio" name="format" value="image" required> Image <input type="radio" name="format" value="audio" required> Audio <input type="radio" name="format" value="video" required> Vidéo
      <p class="sep"> --- OU --- </p>
      <form class="bartri">
        Trier par:
        <select name="tri" onchange="this.form.submit();">
        <option selected> Selectionner... </option>
        <option value="bonne_note"> Note </option>
        <option value="date"> Date (le plus récent) </option>
        <option value="id_user"> Utilisateurs inscrits </option>
        <option value="type"> Type </option>
        </select> <br/>
      </form>
      <input type="submit" value="Rechercher" class="bouton" name="recherche" width="150px">
    </form>
</div>
</header>
<?php
if (isset($_GET['tri']))
{
  switch($_GET['tri'])
  {
    case 'bonne_note':
      $req='SELECT id_img, chemin, chemin_mini, type, nom, bonne_note, mauvaise_note, user.username, poids
              FROM image INNER JOIN user ON image.id_user = user.id_user
              WHERE nom IS NOT null AND private=0 ORDER BY bonne_note DESC';
      $qry = $db->query($req) -> fetchAll() ; // $qry[x][y] x -> balayage de haut en bas ; y -> change de colonne
      $req2 = "SELECT COUNT(*) as nbImage FROM image INNER JOIN user ON image.id_user = user.id_user WHERE nom IS NOT null AND private=0";
      break;

    case 'date':
      $req='SELECT id_img, chemin, chemin_mini, type, nom, bonne_note, mauvaise_note, user.username, poids
            FROM image INNER JOIN user ON image.id_user = user.id_user
            WHERE nom IS NOT null AND private=0 ORDER BY chemin_mini DESC '; // le nom de chaque image etant l'heure exacte a laquelle elle a été envoyé, on peut utiliser le nom pour trier par date
      $qry = $db->query($req) -> fetchAll() ;
      $req2 = "SELECT COUNT(*) as nbImage FROM image INNER JOIN user ON image.id_user = user.id_user WHERE nom IS NOT null AND private=0";
      break;

    case 'id_user':
      $req='SELECT id_img, chemin, chemin_mini, type, nom, bonne_note, mauvaise_note, user.username, poids
              FROM image INNER JOIN user ON image.id_user = user.id_user
              WHERE nom IS NOT null AND private=0 AND NOT image.id_user=1';
      $qry = $db->query($req) -> fetchAll() ;
      $req2 = "SELECT COUNT(*) as nbImage FROM image INNER JOIN user ON image.id_user = user.id_user WHERE nom IS NOT null AND private=0 AND NOT image.id_user=1";
      break;

    case 'type':
      $req='SELECT id_img, chemin, chemin_mini, type, nom, bonne_note, mauvaise_note, user.username, poids
              FROM image INNER JOIN user ON image.id_user = user.id_user
              WHERE nom IS NOT null AND private=0 ORDER BY type';
      $qry = $db->query($req) -> fetchAll() ;
      $req2 = "SELECT COUNT(*) as nbImage FROM image INNER JOIN user ON image.id_user = user.id_user WHERE nom IS NOT null AND private=0";
      break;
  }
}

  elseif(isset($_GET['recherche']))
  {
    $typesrc= htmlentities($_GET['choix']);
    $search = htmlentities($_GET['search']);
    $format = htmlentities($_GET['format']);
	echo $typesrc .'-'.$search.'-'.$format;
    $sep = '"';
    $req = "SELECT id_img, chemin, chemin_mini, type, nom, bonne_note, mauvaise_note, user.username, poids
            FROM image INNER JOIN user ON image.id_user = user.id_user
            WHERE nom IS NOT null AND private=0 AND ".$typesrc."=".$sep.$search.$sep." AND type LIKE '".$format."%'" ;
    $qry = $db->query($req) -> fetchAll() ;
    $req2 = "SELECT COUNT(*) as nbImage FROM image INNER JOIN user ON image.id_user = user.id_user WHERE nom IS NOT null AND private=0 AND ".$typesrc."=".$sep.$search.$sep." AND type LIKE '".$format."%'";
  }
  else
  {
    $req = "SELECT id_img, chemin, chemin_mini, type, nom, bonne_note, mauvaise_note, user.username, poids FROM image INNER JOIN user ON image.id_user = user.id_user WHERE nom IS NOT null AND private=0" ;
    $qry = $db->query($req) -> fetchAll(); // $qry[x][y] x -> balayage de haut en bas ; y -> change de colonne
    $req2 = "SELECT COUNT(*) as nbImage FROM image WHERE nom IS NOT null AND private=0";
  }

$count = $db->query($req2)-> fetch();
$nbImage =$count['nbImage'];
echo '<div class="container">';
for($i=0; $i<$nbImage; $i++)
{
  echo '<div class="boxg">';
  $id=$qry[$i][0];
  $idfix=$qry[$i][0];
  $chemin=$qry[$i][1];
  $chemin_mini=$qry[$i][2];
  $type=$qry[$i][3];
  $auteur=$qry[$i][7];
  $titre=$qry[$i][4];
  $bon=$qry[$i][5];
  $mauvais=$qry[$i][6];
  $poids=floor(($qry[$i][8])/1024);
  switch($type)
  {
    case preg_match('/(image)/', $type)==1:
      echo "<a href='apercu.php?id=$id'> <img src='$chemin' alt='photo' id='imagedl'> </a>";
      break;
    case preg_match('/(audio)/', $type)==1:
      echo "<audio controls> <source src='$chemin' autostart='0' class='gaudio'> </audio> <br/>
			<a href='apercu.php?id=$id' class='bouton'> Afficher dans l'aperçu </a>";
      break;
    case preg_match('/(video)/', $type)==1:
      echo "<video class='gvideo' src='$chemin' autostart='0' controls='1'> </video>
            <a href='apercu.php?id=$id' class='bouton'> Afficher dans l'aperçu </a>";
      break;
    }
    echo '<p class="desc">
            <img src="images/ico/auteur.png" width="20px" height="20px" alt="auteur"> Auteur: '.$auteur.' <br>
            <img src="images/ico/desc.png" width="20px" height="20px" alt="titre"> Titre: '.$titre.' <br>
            '.$bon.' <img src="images/ico/thumbsup.png" alt="note" width="35px"><img src="images/ico/thumbsdown.png" alt="note" width="35px"> '.$mauvais.'
            <div class="button g">
              <a href="'.$chemin.'" download> Télécharger </a>
              <p class="bottom">'.$poids.'ko '.$type.'</p>
            </div>
          </p>
    </div>';
}
echo '</div>';
require "footer.php";
?>
</body>
</html>
