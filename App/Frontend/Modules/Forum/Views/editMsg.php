<section class="row">
	<h2 class="text-center">Editer un message</h2>
	<?php echo "<a class='aforum' href='/forum/topic/".$topicId."' ><span class ='glyphicon glyphicon-arrow-left'></span> Retour au topic</a><br />"; ?>
	<form class="form-horizontal row col-md-6 col-md-offset-3" action="" method="POST">
		<?php echo $form ?>
		<button type="submit" class="btn btn-default col-md-8 col-md-offset-2">Modifier</button>
	</form>
</section>