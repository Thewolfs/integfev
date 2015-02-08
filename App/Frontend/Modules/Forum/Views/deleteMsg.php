<section class="row">
	<h2 class="text-center">Supprimer un message</h2>
	<?php echo "<a class='aforum' href='/forum/topic/".$topicId."' ><span class ='glyphicon glyphicon-arrow-left'></span> Retour au topic</a><br />"; ?>
	<form class="form-horizontal row col-md-6 col-md-offset-3" action="" method="POST">
		<?php 
			if(!empty($form))
				echo $form;
			else
				echo "<p class='text-center'>Êtes-vous sur de vouloir supprimer ce topic ?</p>";
			?>
		<button type="submit" class="btn btn-default col-md-8 col-md-offset-2">Supprimer</button>
	</form>
</section>