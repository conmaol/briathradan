<?php

echo <<<HTML
      <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
      <nav class="navbar navbar-dark bg-primary fixed-bottom navbar-expand-lg">
		    <a class="navbar-brand" href="index.php">🏛 Am Briathradan</a>
		    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			    <div class="navbar-nav">
HTML;
if (SUPERUSER) {
  echo <<<HTML
      <a class="nav-item nav-link" href="?m=admin" data-toggle="tooltip" title="">rianachd</a>
HTML;
}
echo <<<HTML
				    <a class="nav-item nav-link" href="?m=entry&a=random" data-toggle="tooltip" title="View random entry">sonas</a>
			    </div>
		    </div>
	    </nav>
	  </div>
    <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    </script>
	</body>
</html>
HTML;
