<section class="row">
	<article class="col-md-6" style="border-right: solid white 2px;">
		<h2 class="text-center"><?php echo $stitre; ?></h2>
		<div class="text-center"><img src="/uploads/imgmembre/<?php echo $membre['img']; ?>" alt="image de <?php echo $membre['pseudo']; ?>" width="200px" height="200px" /></div><br />
		Pseudo : 
		<?php echo $membre['pseudo']; ?><br />
		Rang : 
		<?php switch ($membre['droit'])
		{
			case 1:
				echo "Membre<br />";
				break;
			case 2: 
				echo "Modérateur<br />";
				break;
			case 3:
				echo "Administrateur<br />";
				break;
		} 
		
		?>
		<div class="form-group">
		<label>Signature :</label>
		<textarea readonly="readonly" rows=7 class="form-control"><?php echo $membre['signature']; ?></textarea>
		</div>
		<?php echo $links; ?>
	</article>
	<aside class="col-md-6">
		<h2 class="text-center">Rechercher un membre du site</h2>
		<form class="form-horizontal row col-md-6 col-md-offset-3" action="" method="POST">
			<div class="form-group">
				<label for="pseudo">Pseudo :</label>
				<input type="text" name="pseudo" class="form-control"/>
			</div>
			<button type="submit" class="btn btn-default col-md-8 col-md-offset-2">Rechercher</button>
		</form>
	</aside>
</section>