<?php

echo <<<HTML
	<nav class="navbar navbar-dark bg-primary fixed-bottom navbar-expand-lg">
			<a class="navbar-brand" href="index.php">🍒 Briathradan</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<!-- <a class="nav-item nav-link" href="about.html" data-toggle="tooltip" title="About this site">fios</a> -->
					<a class="nav-item nav-link" href="viewRandomEntry.php" data-toggle="tooltip" title="View random entry">sonas</a>
				</div>
			</div>
		</nav>
	</div>
	<script src="js/main.js"></script>
	</body>
</html>
HTML;
