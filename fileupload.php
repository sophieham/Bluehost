<html lang="fr">
<head>
 <link rel="icon" href="images/logo.ico" />
 <title>Bluehost</title>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="style.css"rel="stylesheet">
</head>
<?php
require 'header.php';

$Image=$_FILES['upload']['tmp_name'];
$nomOrigine = $_FILES['upload']['name'];
$elementsChemin = pathinfo($nomOrigine);
$extensionFichier = $elementsChemin['extension'];
$date = date("YmdHis");
$dossier = 'upload/';
$nomImage = $date.".".$extensionFichier;
$cheminImage = $dossier.$nomImage;
$cheminMini=$nomImage."_mini.".$extensionFichier;

$type=mime_content_type ($_FILES['upload']['tmp_name']);
switch($type)
      { // on regarde de quel type est notre fichier pour mettre les bonnes balises
        case preg_match('/(video)/', $type)==1:
          $type="video";
		      $cheminMini=null;
          break;
        case preg_match('/(audio)/', $type)==1:
          $type="audio";
		      $cheminMini=null;
          break;
        case preg_match('/(image)/', $type)==1:
          $type="image";
		      $cheminMini='galerie/mini_'.$nomImage;
          break;
       }
function upload($nomImage, $cheminImage, $cheminMini, $dossier, $extensionFichier, $type){
  
  $fichier = basename($_FILES['upload']['name']);
  $poids = filesize($_FILES['upload']['tmp_name']);
  $site = $_SERVER['SERVER_NAME'].'/';
  $typeAutorise = array("image/jpeg","image/jpg","image/png","video/x-msvideo","video/mp4","video/mpeg", "video/mov","audio/mp3","audio/x-wav","audio/x-ms-wma","audio/mpeg");

    // on vérifie si le fichier n'a pas une extension interdite
  if ($poids>=150000000)
  {
    echo '<h1> Votre fichier est supérieur au poids max autorisé (150Mo). </h1>';
	return;
  }

  if (!in_array(mime_content_type ($_FILES['upload']['tmp_name']), $typeAutorise))
  {
    echo "<h1>".$type.": Type de fichier non autorisé </h1>";
	return;
    // si non, on démarre la procédure d'upload
  }

  else if(move_uploaded_file($_FILES['upload']['tmp_name'], $cheminImage)) 
  {
    $titre = htmlentities($_POST['titre']);
	

    // si l'utilisateur à coché la case "privé" (ne pas afficher dans le galerie)
    if(isset($_POST['private']))
    {
      $private = 1;
    }
    else $private=0;

    if(isset($_SESSION['username'])) // si c'est un membre connecté derrière l'upload
    {
      $user=$_SESSION['id_user']; // on récupère son identifiant
    }
    else $user=1;

    //Si le fichier temporaire à été déplacé dans l'endroit voulu
      require 'dbConfig.php';
      // on rentre les données de l'image dans la base
      $req = $db->prepare('INSERT INTO image(chemin, chemin_mini, nom, private, date, type, poids, id_user) VALUES(:chemin, :chemin_mini, :titre, :private, current_timestamp(), :type, :poids, :user)');
      $req->execute(array(
        'chemin'=> $dossier.$nomImage,
        'chemin_mini' => $cheminMini,
        'titre' => $titre,
        'private' => $private,
        'type' => $type,
        'poids'=> $poids,
        'user' => $user));
      echo '<h2> Image téléchargée avec succès ! </h2>';
      switch($type)
      { // on regarde de quel type est notre fichier pour mettre les bonnes balises
        case preg_match('/(video)/', $type)==1:
          $type="video";
          echo       // on affiche le fichier et un lien redirigeant vers celui-ci
          "<a class='fileupload' href='upload/$nomImage'>
          <video src='upload/$nomImage' class='fileupload' alt='telechargement effectue' controls=1 autoplay=0> </video> </a>";
          break;
        case preg_match('/(audio)/', $type)==1:
          $type="audio";
          echo"
          <a class='fileupload' href='upload/$nomImage'>
          <audio controls> <source src='upload/$nomImage'> class='fileupload' alt='telechargement effectue' autostart=0> </audio></a>";
          break;
        case preg_match('/(image)/', $type)==1:
          $type="image";
          echo "
          <a class'fileupload' href='/upload/$nomImage'>
          <img id='upl' src='upload/$nomImage' alt='telechargement effectue'></a>";
          break;
       }
      echo '<h2> Lien à partager: </h2> <textarea rows="1" cols="40" readonly>',$site.'bluehost/upload/',$nomImage,'</textarea>';
  }
  
}

// fonction qui va redimensionner l'image (pour l'afficher proprement dans la galerie)
function miniature($cheminImage, $cheminMini) {

  // si l'image est de type png, on applique des fonctions propre à son type
  if (preg_match("/\.png/", $cheminImage))
  {
    // on crée une ressource a partir de notre image source
    $src=imagecreatefrompng($cheminImage);
  }
  // sinon c'est que la photo est de type est de type jpeg
  else {$src=imagecreatefromjpeg($cheminImage);}

  // on récupère les données de notre image
  $size = getimagesize($cheminImage);

  // on défini la taille de la largeur ou de la hauteur de la photo (selon son orientation)
  $ratio = 300;

  // si la largeur est supérieur à sa 3 fois sa longueur
  if ($size[1]>($size[0]*3))
  {
    // et si l'image est orientation "paysage" on va redimensionner la largeur de l'image
  	if ($size[0] > $size[1])
    {
  		// on crée une ressource redimensionnée par rapport aux dimensions de  l'image source
  		$im=imagecreate(round(($ratio/$size[1])*$size[0]), $ratio);
      // on place dans cette nouvelle ressource l'image source qui à été redimensionnée selon le ratio
  		imagecopyresampled($im, $src, 0, 0, 0, 0, round(($ratio/$size[1])*$size[0]),$ratio, $size[0], $size[1]);
  	}
    // sinon on redimensionne la longueur
  	else
    {
      // avec le même procédé
  		$im=imagecreate($ratio, round(($ratio/$size[0])*$size[1]));
  		imagecopyresampled($im, $src, 0, 0, 0, 0, $ratio, round($size[1]*($ratio/$size[0])), $size[0], $size[1]);
  	}
  }
  // sinon l'image est inférieur à 3 fois sa longueur
  else
  {
    // on fait l'inverse et on redimensionne selon la hauteur
  	if ($size[0] < $size[1])
    {
  		$im=imagecreate(round(($ratio/$size[1])*$size[0]), $ratio);
  		imagecopyresampled($im, $src, 0, 0, 0, 0, round(($ratio/$size[1])*$size[0]),$ratio, $size[0], $size[1]);
  	}
  	else
    {
      // on redimensionne selon la largeur
  		$im=imagecreate($ratio, round(($ratio/$size[0])*$size[1]));
  		imagecopyresampled($im, $src, 0, 0, 0, 0, $ratio, round($size[1]*($ratio/$size[0])), $size[0], $size[1]);
  	}
  }

  // si l'image est de type png
  if ($cheminImage == "/\.png/")
  {
    // on crée notre miniature
    ImagePng ($im, $cheminMini);
  }
  else ImageJpeg ($im, $cheminMini);

}

upload($nomImage, $cheminImage, $cheminMini, $dossier, $extensionFichier, $type);

include 'footer.php';
?>
