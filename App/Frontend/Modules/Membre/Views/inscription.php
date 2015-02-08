<section>
	<h2 class="text-center">Inscription</h2>	
	<form class="form-horizontal row col-md-6 col-md-offset-3" id="form" action="" method="POST">
		<?php echo $form; 
		echo $rpass_error; ?>
		<div class="form-group">
		<label for="rpass">Répéter le mot de passe :</label>
		<input type="password" name="rpass" class="form-control"/>
		</div>
		<button type="submit" class="btn btn-default col-md-8 col-md-offset-2">S'inscrire</button>
	</form>
</section>