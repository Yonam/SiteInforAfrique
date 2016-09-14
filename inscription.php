<!DOCTYPE html>
<!--[if lt IE 9]>
<script
src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->


<?php
 
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');
 if(isset($_POST['forminscription']))
 {
 	// protection contre les injections de code   
 	$pseudo = htmlspecialchars($_POST['pseudo']);
 	$mail = htmlspecialchars($_POST['mail']);
 	$mail2 = htmlspecialchars($_POST['mail2']);

 	//protectiondu mot de passe
 	$mdp = sha1($_POST['mdp']);
 	$mdp2 = sha1($_POST['mdp2']);

 	//verification des valeurs d'enregistrelment
 	if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
 	{
 	
 		//verification du notre de caractères 
 		$pseudolength = strlen($pseudo);
 		if ($pseudolength <= 255)
 		{
 			if ($mail == $mail2) 
 			{
				// verifie si c'est un mail
		 		if (filter_var($mail, FILTER_VALIDATE_EMAIL)) 
		 		{
		 			//verifie si le mail a été utilisée pour un autre compte	
		 			$reqmail=$bdd->prepare("SELECT * FROM membres WHERE mail = ?");
		 			$reqmail->execute(array($mail));
		 			$mailexist=$reqmail->rowcount();
		 			if ($mailexist ==0 )
		 			 {
		 			
		 			
				 			if ($mdp == $mdp2) 
				 				{	
				 					// inscription à la base de données
				 					$insertmbr =$bdd -> prepare("INSERT INTO membres(pseudo, mail, motdepasse) VALUES(?, ?, ?)");
				 					$insertmbr -> execute(array($pseudo, $mail, $mdp));
				 					
									//envoie le message lorque le compte a été crée
				 					$_SESSION['comptecree']= "Votre compte a bien été crée !";
				 					// redirigé à la page d'index
				 				header('Location: index.php');

				 				}
				 				else
				 				{
				 					$erreur = "Vos mots de passes ne correspondent pas !";
				 				}
				 	}
				 	else
				 	{
				 		$erreur="Adresse mail dejà utilsée !";
				 	}
 				}
 				else
 				{
 					$erreur = "Votre adresse mail n'est pas valide !";
 				}
 			}
 			else
 			{
 				$erreur = "Vos adresses mail ne correspondent pas !";
 			}
 		}
 		else
 		{
 			$erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
 		}
 	}

 	else
 	{
 		$erreur = "Tous les champs doivent être completés !";
 		
 	}
 }

?>

<html>
    <head>
        <meta charset="UTF-8">
            <title>index</title>
    </head>
    <body>
          <div align="center">
              <h2>Inscription</h2>
              <br/><br/>
              <form method="POST" action="">
              		
              		<table>

              		<!-- insertion du pseudo -->
						<tr>
	              			<td align="right"> 
								<label for="pseudo">Pseudo :</label>
	              			</td>
	              			<td align="right">
	              				<input type="text" name="pseudo" placeholder="Votre pseudo" id="pseudo" value="<?php if (isset($pseudo)) {
	              					echo $pseudo;
	              				}?>">
	              			</td>
	              		</tr>

					<!-- insertion du mail-->
	              		<tr>
	              			<td align="right"> 
								<label for="mail">Mail :</label>
	              			</td>
	              			<td>
	              				<input type="email" name="mail" placeholder="Votre mail" id="mail" value="<?php if (isset($mail)) {
	              					echo $mail;
	              				}?>">
	              			</td>
	              		</tr>

					<!-- vérification du mail-->
	              		<tr>
	              			<td align="right"> 
								<label for="mail2">Confirmation du mail :</label>
	              			</td>
	              			<td>
	              				<input type="email" name="mail2" placeholder="Confirmez votre mail" id="mail2" value="<?php if (isset($mail2)) {
	              					echo $mail2;
	              				}?>">
	              			</td>
	              		</tr>

					<!-- Insertion dumot de passe-->
	              		<tr>
	              			<td align="right"> 
								<label for="mdp">Mot de passe :</label>
	              			</td>
	              			<td>
	              				<input type="password" name="mdp" placeholder="Votre mot de passe" id="mdp">
	              			</td>
	              		</tr>
					<!--verification de mot de passe-->
	              		<tr>
	              			<td align="right"> 
								<label for="mdp2"> Confirmation du mot de passe :</label>
	              			</td>
	              			<td>
	              				<input type="password" name="mdp2" placeholder="Confirmez mot de passe" id="mdp2">
	              			</td>
	              		</tr>

						<!-- soumission de l'inscription-->

						<tr>
	              			<td></td>
	              			<td>
	              			<br/>
	              				<input type="submit" value="Je m'inscris" name="forminscription">
	              			</td>
	              		</tr>


              		</table>
		         	
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
