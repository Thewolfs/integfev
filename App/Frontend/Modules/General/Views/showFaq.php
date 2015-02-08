<section class="row">
	<h2 class="text-center">FAQ (Frequently asked question)</h2>
	<div class="col-md-10 col-md-offset-1">
	<?php
		foreach($listeFaq as $i=>$faq)
		{
			echo "<b>Question ".($i + 1)." : ".$faq['question']."</b><br />";
			echo $faq['text'];
		}
		?>
	</div>
</section>