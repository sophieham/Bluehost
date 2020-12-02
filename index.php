<html lang="fr">
<head>
 <link rel="icon" href="images/logo.ico" />
 <title>Bluehost</title>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="style.css"rel="stylesheet">
</head>
<body>
<?php
require 'dbConfig.php';
require 'header.php';
?>
<section class="goupload">
  	<h2>Partager des fichiers n'a jamais été aussi facile</h2>
  	<p>Commence dès maintenant à envoyer les tiens!</p>
  	<ul class="actions">
  		  <form enctype="multipart/form-data" action="fileupload.php" method="post">
  			     <input type="hidden" name="MAX_FILE_SIZE" value="150000000" />
             <li> Donne un titre à ton image:
                <input type="text" name="titre" pattern="[\w 'âêéèàùô]{2,30}" required>
                <input type="checkbox" name="private" value="oui"> Ne pas l'afficher dans la galerie </li> <br>
  			     <li> <input type="file" name="upload"> </li>
             <li> Format acceptés: jpeg, jpg, png, avi, mp4, mov, mp3, wav, wma. Taille max: 150Mo </li>
  			     <input type="submit" value="Envoyer" class="bouton" width="150px">
        </form>
  	</ul>
</section>

<section>
    <div class="header">
      <h2>Pourquoi choisir Bluehost?</h2>
      <p>Voici 3 raisons pour lesquelles Bluehost est si apprécié</p>
    </div>
    <div class="container">
      <div class="box">
        <img src='images/simple.png' height="100px" width="100px" alt="simple d'utilisation">
        <h3>Simple d'utilisation</h3>
        <p>Bluehost est très simple à utiliser, il suffit de cliquer sur "Parcourir" puis cliquer sur envoyer pour heberger vos fichiers et les partager en 1 clic!</p>
      </div>
      <div class="box">
        <img src='images/picture.png' height="100px" width="100px" alt="galerie">
        <h3> Galerie interactive</h3>
        <p>Avant d'envoyer un fichier, vous pouvez décider si vous nous autorisez à l'afficher dans la galerie. Dans la galerie vous pouvez noter quel fichier vous preferez le plus!</p>
      </div>
      <div class="box">
        <img src='images/printer.png' height="100px" width="100px" alt="impression">
        <h3>Impression de photos <img src="images/ico/new.png" alt="nouveaute" height="24px" width="24px"> </h3>
        <p>Grâce à notre nouveau système d'impression, nous pouvons bientôt imprimer vos photos et les envoyer à votre domicile, pour garder un souvenir de vos photos!</p>
      </div>
    </div>
</section>
<?php
include 'footer.php';
?>
</body>
</html>
