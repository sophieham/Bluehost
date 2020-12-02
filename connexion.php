<html lang="fr">
<head>
 <title>Bluehost</title>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link  href="login.css" rel="stylesheet">
</head>
<body>
<?php
require "header.php";
require "dbConfig.php";
if(isset($_POST['connexion'])) // si l'utilisateur à cliqué sur le bouton connexion
{
  $username = htmlentities(trim($_POST['username'])); // recupère les données envoyées en minimisant le risque d'injection sql
  $password = htmlentities(trim($_POST['password']));
  if($username&&$password)
  {
    $req = $db->prepare('SELECT id_user, password FROM user WHERE username = :username');
    $req->execute(array('username' => $username));
    $connexion = $req->fetch(); // met le résultat de la requête sous forme de tableau
    $isPasswordCorrect = password_verify($_POST['password'], $connexion['password']); // password_verify va vérifier si le mot de passe envoyé correspond bien avec celui présent sur la bdd

    if (!$connexion) // si la requête ne renvoie rien
    {
      echo '<h1> Mauvais identifiant ou mot de passe ! </h1>';
    }

    else
    {
        if ($isPasswordCorrect)
        {
            $_SESSION['id_user'] = $connexion['id_user']; // on associe l'id de session avec celui du compte de l'utilisateur
            $_SESSION['username'] = $username;
            echo '<h1> Vous êtes connecté ! </h1>';
        }

        else echo '<h1> Mauvais identifiant ou mot de passe ! </h1>';
    }

    if (isset($_SESSION['id_user']) AND isset($_SESSION['username'])) // si la connexion à bien été établie
    {
        header('Location: index.php');
    }
  } else echo '<h1> Veuillez saisir tous les champs </h1>';
} else echo "<fieldset>
              <h1>Connexion</h1>
              <form id='connexion' method='post'>
                <label> <input type='text' class='username' size='30' name='username' maxlength='30' placeholder='Pseudo'  pattern='{2,30}' required/> <br/> </label>
               	<label> <input type='password' class='pass' size='30' name='password' maxlength='30' placeholder='Mot de passe'  pattern='{2,30}' required/> <br/> </label>
               	<a href='reset.php'>Mot de passe oublié ?</a> <br/>
              	<input type='submit' class='button' value='Se connecter' name='connexion'>
              </form>
              <form method='post' action='inscription.php'>
              	<input id='submit' type='submit' class='button' value='Créer un compte'>
                <br/>
              </form>
            </fieldset>";
require "footer.php";
?>

</body>
</html>
