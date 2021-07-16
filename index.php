<?php

namespace controllers;

require_once 'includes/include.php';

$module = isset($_GET["m"]) ? $_GET["m"] : "";
$action = isset($_GET["a"]) ? $_GET["a"] : "";

if (empty($_SESSION["gd"])) {
	$_SESSION["gd"] = "no";
}

echo <<<HTML
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="js/main.js"></script>
HTML;
  if ($_GET["search"]) {
		echo "<title>🏛 \"" . $_GET["search"] . "\" ??</title>";
	}
	else if ($_GET["mhw"]) {
		echo "<title>🏛 " . $_GET["mhw"] . "</title>";
	}
	else {
		echo "<title>🏛 Am Briathradan</title>";
	}
echo <<<HTML
</head>
<body style="padding-top: 20px; padding-bottom: 100px;">
  <div class="container-fluid">
HTML;

switch ($module) {
	case "entry":
		$controller = new entry(); // view entry
		break;
	default:
		$controller = new search(); // show search box
}
$controller->run($action);

/**
 * Handle request in the URL to display an entry automatically on page load
 */
$loadEntryJS = "";
if ($_GET["mhw"]) {
	$loadEntryJS =  <<<JS
		let mhw = '{$_GET["mhw"]}';
	  let mpos = '{$_GET["mpos"]}';
	  let msub = '{$_GET["msub"]}';
	  writeEntry(mhw, mpos, msub);
JS;
}

echo <<<HTML
    <nav class="navbar navbar-dark bg-primary fixed-bottom navbar-expand-lg">
		  <a class="navbar-brand" href="index.php">🏛 Am Briathradan</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			  <div class="navbar-nav">
				  <a class="randomEntry nav-item nav-link" href="#" data-toggle="tooltip" title="View random entry">sonas</a>
			  </div>
		  </div>
	  </nav>
	</div>
	<div class="modal fade" id="entryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
        </div>
      </div>
    </div>
 </div>
  <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        
        {$loadEntryJS}
      })
  </script>
</body>
</html>
HTML;
