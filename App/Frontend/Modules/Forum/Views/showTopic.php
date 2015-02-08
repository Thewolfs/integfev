<section class="row">
	<?php
		echo "<h2 class='text-center'>".$listeMsg[0]['topic']['nom']."</h2>";
		echo "<a class='aforum' href='/forum/".$listeMsg[0]['topic']['forum']['id']."' ><span class ='glyphicon glyphicon-arrow-left'></span> Retour au forum</a>";
		echo "<table class='table table-striped' >";
		echo "<thead style='font-size: 20px;'><tr><th class='text-center'>Auteur</th><th class='text-center'>".$listeMsg[0]['topic']['nom']."</th></tr></thead>";
		foreach($listeMsg as $msg)
		{
			echo "<tr style='min-height: 150px;'><td class='text-center' style='width: 20%; border-right: solid 1px #FFFFFF;'><img width='100px' height='100px' src='/uploads/imgmembre/".$msg['membre']['img']."' alt='image de ".$msg['membre']['pseudo']."'/><br />".$msg['membre']['pseudo']."</td><td style='width: 80%;'><div class='col-md-10'><div style='min-height: 121px;'>".nl2br($msg['text'])."</div>";
			
			if($msg['membreEdit']) 
			{
				echo "<div class='text-right' style='font-size: 9px; height: 12px;'>Dernière édition par : ".$msg['membreEdit']['pseudo']."</div>";
			}
			echo "</div><div class='col-md-2'>";
			
			if(($user->getAttribute('id') && $user->getAttribute('id') == $auteur['id']) || ($user->getAttribute('droit') >= 2 && $user->getAttribute('droit')))
			{
				echo "<div class='col-md-2 text-right'><a class='glyphicon glyphicon-edit' aria-hidden='true' href=/forum/editMsg/".$msg['id']."></a></div>";
			}
			if($user->getAttribute('droit') >= 2 && $user->getAttribute('droit')) 
			{
				echo "<div class='col-md-2 text-right'><a class='glyphicon glyphicon-remove' aria-hidden='true' href=/forum/deleteMsg/".$msg['id']."></a></div>";
			}
		
		
		echo "</div></td></tr>";

		}
		echo "</table>";
		echo "</div>";
		if($user->getAttribute('droit') > 0 && $user->getAttribute('droit')) 
		{
	?>
		<form class="form-horizontal row col-md-6 col-md-offset-3" action="" method="POST">
			<?php echo $form; ?>
			<button type="submit" class="btn btn-default col-md-8 col-md-offset-2">Répondre</button>
		</form>
	<?php
		}
		else 
		{
			echo "Veuillez vous connecter pour répondre au sujet";		
		}
	?>
</section>