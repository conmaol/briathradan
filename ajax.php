<?php

require_once 'includes/include.php';

switch ($_REQUEST["action"]) {
	case "setLang":
		$_SESSION["gd"] = $_GET["gdSelect"];
		break;
	case "getEntry":
		$entry = new models\entry($_GET["mhw"],$_GET["mpos"],$_GET["msub"],true);
		$view = new views\entry($entry);
		echo json_encode(array("msg"=>"success", "html"=>$view->show('show')));
		break;
	default:
		echo "no action defined";
}