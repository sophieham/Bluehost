<html lang="fr">
<head>
 <title>Bluehost</title>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link  href="style.css"rel="stylesheet">
 <link  href="login.css"rel="stylesheet">
</head>
<body>
<?php
require "header.php";
?>

<fieldset>
  <form id="mail" action="ficVide.php" method="get">
    <label>
	     <h2>Saisissez votre adresse mail pour recevoir un nouveau mot de passe</h2><br/>
   	   <input type="email" size="30" name="identifiant" maxlength="30" placeholder="Adresse e-mail"  pattern="{2,30}" required/> <br/>
 	  </label>
    <br/>
 	  <input type="submit" />
  </form>
</fieldset>

<?php
require "footer.php";
?>
</body>
</html>
