<section class="row">
	<h2 class="text-center">Planning prévu pour la semaine de rentrée</h2>
	<div class="row">	
	<table class="table-bordered text-center col-md-10 col-md-offset-1">
		<?php 
			foreach($table as $r=>$row)
			{
				echo "<tr>";
				foreach($row as $c=>$col)
				{
					if($r)
					{
						if(!$c)
							echo "<th width='10%'>".$col."</th>";
						else
							echo "<td width='15%'>".$col."</td>";
					}
					else
					{
						if(!$c)
							echo "<th width='10%' class='text-center'>".$col."</th>";
						else
							echo "<th width='15%' class='text-center'>".$col."</th>";
					}
				}
				echo "</tr>";
			}
		?>
	</table>
	</div>
</section>