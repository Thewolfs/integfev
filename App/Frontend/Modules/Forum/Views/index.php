<section class="row">
	<h2 class="text-center">Forum - Accueil</h2>
	<?php
	$temp = -1;
	foreach($listeForum as $forum)
	{
		if($temp != $forum['categ']['id'])
		{
			if($temp != -1)
			{
				echo '</table>';
			}
			echo '<table class="table table-striped">';
			echo "<thead><tr><th style='width: 70%;'><div class='col-md-10'>".$forum['categ']['nom']."</div>";
			if($user->getAttribute('droit') && $user->getAttribute('droit') > 1) 
			{
				echo "<div class='col-md-2 text-right'><a class='glyphicon glyphicon-remove' aria-hidden='true'></a></div>";
			} 
			echo "</th><th style='width: 15%;'>Topics :</th><th style='width: 15%;'>Messages :</th></tr></thead>";
			$temp = $forum['categ']['id'];
		}
		
			echo "<tr><td><a class='aforum' href='/forum/".$forum['id']." '>".$forum['nom']."</a></td><td>".$nbreTopic->getTopicCount($forum['id'])."</td><td>".$nbreMsg->getMessageCountForum($forum['id'])."</td></tr>
		<tr><td style='font-size: 12px;' colspan=3 >".$forum['description']."</td></tr>";
	}
	if($temp == '')
	{
		echo "<p>Le forum est vide !</p>";
	}
	else
	{
		echo "</table>";
	}
	if($user->getAttribute('droit') && $user->getAttribute('droit') > 1) 
	{
		echo "<a class='btn btn-default col-md-3 aforum' href='/forum/newForum'>Nouveau forum</a>";
	}
	?>
</section>
