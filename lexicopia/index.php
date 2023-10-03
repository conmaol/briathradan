<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	    <title>Lexicopia/GD</title>
    </head>
    <body style="padding-top: 20px; padding-bottom: 100px;">
        <div class="container-fluid">
<?php
require_once 'includes/include.php';
$model = new models\search();
$view = new views\search($model);
$view->show();
?>
            <nav class="navbar navbar-dark bg-primary fixed-bottom navbar-expand-lg">
                <div class="container-fluid">
		            <a class="navbar-brand" href="index.php">&nbsp;&nbsp;Lexicopia/GD</a>
		            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			            <span class="navbar-toggler-icon"></span>
		            </button>
		            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			            <div class="navbar-nav">
				            <a class="randomEntry nav-item nav-link" href="#" data-bs-toggle="tooltip" title="View random entry">random</a>
                            <!-- <a class="nav-item nav-link" href="https://twitter.com/briathradan" data-bs-toggle="tooltip" title="Twitter" target="_new">bìdeagan</a> -->
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
    $('#gdSwitch').on('click', function () {
        $('.entryRow').toggle();
    });
    $(document).on('click', '.entryRow', function () {
        let id = $(this).attr('data-id');
        writeEntry(id);
    });
    $('.randomEntry').on('click', function() {
        writeEntry('');
    });         
})
function writeEntry(id) {
    let modal = $('#entryModal');
    $.getJSON('ajax.php?action=getEntry&id='+id, function () {
    })
    .done(function (data) {
        modal.find('.modal-content').html(data.html);
        modal.modal('show');
    });
}
        </script>
    </body>
</html>

