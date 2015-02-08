<section class="row">
	<h2 class="text-center">Création d'un nouveau forum</h2>
	<form class="form-horizontal row col-md-6 col-md-offset-3" action="" method="POST">
		<?php echo $form; ?>
		<label for="choix">Catégroie associée : </label>
		<label class="inline-radio"><input type="radio" value="1" name="choix"/>Existante</label>
		<label class="inline-radio"><input type="radio" value="0" name="choix"/>Nouvelle</label>*
		<div class="form-group" id="categex">
			<label for="idcateg">Choisir la catégorie associée : </label>
			<select class="form-control">
				
			</select>
		</div>
	</form>
</section>