<html lang="fr">
<head>
    <link  href="style.css" rel="stylesheet">
</head>
<body>
<?php

require "header.php";

if ( isset($_GET['id']) ){ // si l'id est associé a un fichier
    include ("dbConfig.php");
    $id = $_GET['id'];
    $id_tab = intval ($id)-1; // $id-1 pour s'aligner sur le format des tableaux
    $req = "SELECT id_img, chemin, poids, type, bonne_note, mauvaise_note FROM image";
    $col = $db->query($req) -> fetchAll(); // $col[x][y] x -> balayage de haut en bas ; y -> change de colonne
    $chemin=$col[$id_tab][1];
    $poids=$col[$id_tab][2];
    $type=$col[$id_tab][3];
    $bonne_note=$col[$id_tab][4];
    $mauvaise_note=$col[$id_tab][5];

    switch($type){
        case 'video':
            echo '<video src='.$chemin.' id="upl" controls=1 autoplay=0> </video>';
            break;
        case 'audio':
            echo '<audio controls> <source src='.$chemin.' id="upl" autostart=0> </audio>';
            break;
        case 'image':
            echo '<img src='.$chemin.' id="upl">';
            break;
    }

    function verif_note_ip(){
        $sth = $db->prepare("SELECT ip FROM note_image where id_img=2");
        $sth->execute();


        print("Récupération de toutes les lignes d'un jeu de résultats :\n");
        $result = $sth->fetchAll();
        print_r($result);


        //$req_votes = "SELECT ip FROM note_image where id_img=2";
        //$liste_votes = $db->query($req_votes) -> fetchAll();
    }
    /*
      for($i=0; $i<=count($liste_votes); $i++){
          echo $i.'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';

          if($liste_votes[$i][0]==getIp()){

              echo 'deja voté !';
          }
      }
        $test = $liste_votes[4][0];
        return $test;
  }*/

    echo '<form method="post" class="note">
            '.$bonne_note.'<button type="submit" class="bnote" name="up" value="+1"><img src="images/ico/thumbsup.png" alt="note" width="40px"></button>
            Note moi!
            <button type="submit" class="bnote" name="down" value="-1"><img src="images/ico/thumbsdown.png" alt="note" width="40px"></button>'.$mauvaise_note.'
          </form>';




    if (isset($_POST['up'])) { // si l'utilisateur à cliqué sur le pouce vert
        verif_note_ip();
        $db->query("INSERT INTO note_image(id_img, ip) VALUES ($id, '".getIp()."'); UPDATE image SET bonne_note = (bonne_note + 1) WHERE id_img=$id"); // on incrémente la note positive
        header('Location: apercu.php?id='.$_GET['id'].''); // on recharge la page pour actualiser les votes
    }

    if (isset($_POST['down'])){
        $majNote=$db->query('UPDATE image SET mauvaise_note = (mauvaise_note + 1) WHERE id_img='.$_GET['id'].'');
        header('Location: apercu.php?id='.$_GET['id'].'');
    }
    echo '<h2> Lien à partager: </h2>
          <textarea rows="1" cols="40" readonly>sopham.fr/'.$chemin.'</textarea>
          <div class="button">
            <a href="'.$chemin.'" download> Télécharger </a>
            <p class="bottom">'.$poids.'ko '.$type.'</p>
          </div>';
} else
    echo "404 - L'image n'existe pas";

require "footer.php";
?>
</body>
</html>
