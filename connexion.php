<!DOCTYPE html>
<!--[if lt IE 9]>
<script
src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->


<?php
 
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');

		if(isset($_POST['formconexion']))
		{
			$mailconnect = htmlspecialchars($_POST['mailconnect']);
			$mdpconnect = sha1($_POST['mdpconnect']);

			if(!empty($mailconnect AND !empty($mdpconnect)))
			{
					$requser = $bdd->prepare("SELECT * FROM membres WHERE mail= ? AND motdepasse = ?");
					$requser -> execute-array($mailconnect);
					if($userexist) 
					{
						# code...
					}
					else
					{
						$erreur = "Mauvais mail ou mauvais mot de passe";
					}

			}
			else 
			{
				$erreur = "Tous les champs doivent être completés";
			} 
		}

	
		
		
	
?>

<html>
    <head>
        <meta charset="UTF-8">
            <title>...</title>
    </head>
    <body>
          <div align="center">
              <h2>Connexion</h2>
              <br/><br/>
              <form method="POST" action="">

              		<input type="text" name="mailconnect" placeholder="Mail" />
              		<input type="password" name="mdpconnect" placeholder="Mot de passe" />
              		<input type="submit" name="formconexion" value="Se connecter !" />
              		
              </form>

				<?php

					//fonction d'erreur
						if (isset($erreur))
						 {
							echo '<font color=red>' .$erreur. "</font>";
						}
				?>


          </div>
    </body>
</html>
