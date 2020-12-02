<html lang="fr">
<head>
 <link  href="login.css" rel="stylesheet">
</head>
<body>
<?php
require "header.php";
require "dbConfig.php";
if((isset($_SESSION['username'])))
{
  $req='SELECT email FROM user WHERE id_user='.$_SESSION['id_user'].'';
  $email=$db->query($req)->fetch();
  if(isset($_POST['submit']))
  {
    $nouveauemail=htmlentities(trim($_POST['nouveauemail']));
    $confirmeremail=htmlentities(trim($_POST['confirmeremail']));
    if ($nouveauemail==$confirmeremail)
    {
      $req2=('UPDATE user SET `email` = "'.$nouveauemail.'" WHERE user.id_user = '.$_SESSION['id_user'].'');
      $change=$db->query($req2);
      echo '<h1> E-mail modifié! :) </h1>';
      header('Location: compte.php');
    }
    else echo '<h1> <img src="images/ico/erreur.png" alt="Erreur!" height="45px" width="45px"> Emails non identiques </h1>';
  }
} else header('Location:index.php');

echo ' <fieldset>
          <form class="changement" action="moncompte.php" method="post">
            <ul>
            <h2 class="moncompte"> Changer d\'adresse e-mail (actuellement: '.$email[0].') </h2> <br>
            Entrez votre nouvelle adresse email:
              <li> <input type="email" class="email" size="30" name="nouveauemail" maxlength="30" placeholder="Nouvel email"  pattern="{6,30}" required/> </li>
            Confirmer le mail:
              <li> <input type="email" class="email" size="30" name="confirmeremail" maxlength="30" placeholder="Répeter le mail"  pattern="{6,30}" required/> </li>
            </ul>
            <input type="submit" class="button" value="Modifier" name="submit">
          </form>
        </fieldset>';

require "footer.php";
?>
</body>
</html>
