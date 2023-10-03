<?php

require_once 'includes/include.php';

switch ($_REQUEST["action"]) {
	case "getEntry":
		$entry = new models\entry($_GET["id"],true); // what does true mean here?
		$view = new views\entry($entry);
		echo json_encode(array("msg"=>"success", "html"=>$view->show('show')));
		break;
	default:
		echo "no action defined";
}
