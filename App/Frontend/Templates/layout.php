<!DOCTYPE html>
<html>
	<head>
		<title><? echo isset($title) ? $title : "Integ Fev' - Accueil";?></title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="/css/bootstrap.css" />
	</head>
	<body class="container" style="padding-top: 60px;">
		<header class="row page-header">
			<p class="text-center" style="margin-top: 10px;">
				<img src="/img/banniere2.png" alt="Integ Fev'" >			
			</p>
		</header>
		<nav class="navbar navbar-default navbar-fixed-top" id="nav">
			<ul class="nav navbar-nav">
				<li><a href="/">Accueil</a></li>
				<li><a href="/planning" >Planning</a></li>	
				<li><a href="/faq" >FAQ</a></li>		
				<?php if ($user->isAuthenticated()) { echo '<li><a href="/membre">Membre</a></li><li><a href="/deconnexion">Déconnexion</a></li>'; }
				else {
					echo '<li><a href="/connexion">Connexion</a></li>
				<li><a href="/inscription">Inscription</a></li>';
				} 
				if ($user->isAuthenticated() && $user->getAttribute('droit') && $user->getAttribute('droit') >=2) { echo '<li><a href="/admin/">Admin</a></li>'; }
				?>
				<li><a href="/forum/accueil">Forum</a></li>
				<p class="navbar-text navbar-right" style="font-size: 9px;">Site : Louis Duprat <br />Logo : Mart'Gyver la Bro'telle</p>
			</ul>	
		</nav>
		<div id="contenu">
			<?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
			<? echo $content; ?>
		</div>
	</body>
</html>