<html lang="fr">
<head>
 <title>Bluehost</title>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link  href="login.css"rel="stylesheet">
</head>
<body>
<?php
require "header.php";
require 'dbConfig.php';
if(isset($_POST['submit']))
{
  $username = htmlentities(trim($_POST['username']));
  $email = htmlentities(trim($_POST['email']));
  $password = htmlentities(trim($_POST['password']));
  $confirmerpassword = htmlentities(trim($_POST['confirmerpassword']));
  if($username&&$email&&$password&&$confirmerpassword)
  {

    if($password==$confirmerpassword)
    {
      $sql =  "SELECT id_user as nbPseudo FROM user WHERE username='$username'";
      $count = $db->query($sql)-> fetch();
      $nbPseudo =$count['nbPseudo'];
        if ($nbPseudo>1)
        {
          echo '<p> <img src="images/ico/erreur.png" alt="Erreur!" height="45px" width="45px"> <h1> Nom d\'utilisateur déjà pris </h1> </p>
                <h2> Veuillez choisir un autre nom </h2>';
        }
        else
        {
        $pass_hache = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $req = $db->prepare('INSERT INTO user(username, email, password, date_inscription) VALUES(:username, :email, :password, current_timestamp())');
        $req->execute(array(
            'username' => $username,
            'email' => $email,
            'password' => $pass_hache
          ));
          header('Location: http://localhost/bluehost/');
          exit();
         }
    } else echo '<p> <img src="images/ico/erreur.png" alt="Erreur!" height="45px" width="45px">Les deux mots de passes doivent être identiques </p>';
  } else echo '<p> <img src="images/ico/erreur.png" alt="Erreur!" height="45px" width="45px"> Veuillez saisir tous les champs </p>';
}
?>

<fieldset>
<h1>S'enregistrer</h1>
<br>
<ul>
  <br>
<form id="register" action="inscription.php" method="post">
  Nom d'utilisateur:
  <li>
 	<input type="text" class="username" size="30" name="username" maxlength="30" placeholder="entre 2 et 30 caractères"  pattern="[a-zA-Z]{2,30}" required/>
 	</li>
  Adresse e-mail:
  <li>
 	<input type="email" class="email" size="30" name="email" maxlength="30" placeholder="exemple@mail.fr"  pattern="{2,30}" required/>
 	</li>
  Mot de passe:
 	<li>
 	<input type="password" class="pass" size="30" name="password" minlength="6" maxlength="30" placeholder="6 caractères minimum"  pattern="{6,30}" required/>
 	</li>
  Confirmer le mot de passe:
  	<li>
 	<input type="password" class="pass" size="30" name="confirmerpassword" minlength="6" maxlength="30" placeholder="Répeter le mot de passe"  pattern="{6,30}" required/>
 	</li>
</ul>
 	<input type="submit" class="button" value="S'inscrire" name="submit">
</fieldset>

</body>
</html>
<?php
require "footer.php";
?>
