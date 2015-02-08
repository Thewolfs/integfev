<section class="row">
	<h2 class="text-center">Modification</h2>
	<form class="form-horizontal row col-md-6 col-md-offset-3" id="form" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
		<?php echo $form; ?>
		<div class="form-group">
			<label for="npass">Nouveau mot de passe (laisser vide pour ne pas le changer) :</label>
			<input type="password" name="npass" class="form-control"/>
		</div>
		<div class="form-group">
			<label for="rpass">Répeter le nouveau mot de passe :</label>
			<input type="password" name="rpass" class="form-control"/>
		</div>
		<button type="submit" class="btn btn-default col-md-8 col-md-offset-2">Modifier le pseudo</button>
	</form>
</section>