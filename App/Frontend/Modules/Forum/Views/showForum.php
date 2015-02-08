<section>
	<?php
	$temp = 1;
		foreach ($listeTopic as $topic)
		{
			if($temp)
			{
				echo "<h2 class='text-center'>Forum - ".$topic['forum']['nom']."</h2>";
				$temp = 0;
				echo "<table class='table table-striped' >";
				echo "<thead><tr><th style='width: 80%;'><div class='col-md-10'>".$topic['forum']['nom'].'</div>';
				if($user->getAttribute('droit') && $user->getAttribute('droit') > 1) 
				{
					echo "<div class='col-md-2 text-right'><a class='glyphicon glyphicon-remove' aria-hidden='true' href=".$idForum."></a></div>";
				}	
				echo "</th><th style='width: 20%;'>Messages :</th></tr></thead>";
			}
			echo "<tr><td><a class='aforum' href='/forum/topic/".$topic['id']."'>".$topic['nom']."</a></td><td>".$nbreMsg->getMessageCountTopic($topic['id'])."</td></tr>";
			
		}
		echo "</table>";
		if($user->getAttribute('droit') && $user->getAttribute('droit') > 0) 
		{
			echo "<a class='btn btn-default col-md-3 aforum' href='/forum/createTopic/".$topic['forum']['id']."'>Nouveau topic</a>";
		}
	?>
</section>