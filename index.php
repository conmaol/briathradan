<?php

session_start();
//$_SESSION["groupId"] = 3; //need to set this for the database queries
require_once 'includes/include.php';

echo <<<HTML
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	    <script src="js/main.js"></script>
	    <title>Briathradan</title>
	    <link rel="icon" type="image/jpeg" href="./dluth.jpeg"> <!-- favicon -->
    </head>
    <body style="padding-top: 20px; padding-bottom: 100px;">
        <div class="container-fluid">
HTML;

$model = new models\search();
$view = new views\search($model);
$view->show();

/**
 * Handle request in the URL to display an entry automatically on page load
 */
$loadEntryJS = "";
if (isset($_GET["mhw"])) {
    $mpos = isset($_GET["mpos"]) ? $_GET["mpos"] : '';
    $msub = isset($_GET["msub"]) ? $_GET["msub"] : '';
	$loadEntryJS =  <<<JS
let mhw = '{$_GET["mhw"]}';
let mpos = '{$mpos}';
let msub = '{$msub}';
writeEntry(mhw, mpos, msub);
JS;
} 
//else if (isset($_GET["random"]) && $_GET["random"] == "yes") {
//	$loadEntryJS = <<<JS
//		writeEntry('', '', '');
//JS;
//}

echo <<<HTML
            <nav class="navbar navbar-dark bg-primary fixed-bottom navbar-expand-lg">
                <div class="container-fluid">
		            <a class="navbar-brand" href="index.php"><img src="./dluth.jpeg" alt="logo" style="width:20px; height:20px;" class="d-inline-block align-text-top"/>&nbsp;&nbsp;Am Briathradan</a>
		            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			            <span class="navbar-toggler-icon"></span>
		            </button>
		            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			            <div class="navbar-nav">
				            <a class="randomEntry nav-item nav-link" href="#" data-bs-toggle="tooltip" title="View random entry">tuaiream</a>
                            <a class="nav-item nav-link" href="https://twitter.com/briathradan" data-bs-toggle="tooltip" title="Twitter" target="_new">bìdeagan</a>
			            </div>
		            </div>
                 </div>
            </nav>
        </div>
	    <div class="modal fade" id="entryModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content"/>
            </div>
        </div>
        <script>
            $(function () {
                $('[data-bs-toggle="tooltip"]').tooltip();
                //$('.gaelic').hide(); // hide Gaelic search results for now
                {$loadEntryJS}
            })
        </script>
    </body>
</html>
HTML;
