<?php

namespace models;

class entry {

  private $_mhw;
  private $_mpos;
  private $_msub;
  private $_instances = array(); // an array of entry_instance models
  private $_parts = array();
  private $_compounds = array();
  private $_slips = array();
  private $_db;   // an instance of models\database

	public function __construct($mhw,$mpos,$msub,$db) {
    if ($mhw!=null) {
      $this->_mhw = $mhw;
      $this->_mpos = $mpos;
      $this->_msub = $msub;
      if ($db) { // check the database?
        $this->_db = isset($this->_db) ? $this->_db : new database();
    		$this->_load();
      }
    } else {
      $this->_db = isset($this->_db) ? $this->_db : new database();
      $sql = <<<SQL
      	SELECT `m-hw`, `m-pos`, `m-sub`
      		FROM `lexemes`
          ORDER BY RAND()
          LIMIT 1
SQL;
      $results = $this->_db->fetch($sql);
      $this->_mhw = $results[0]["m-hw"];
      $this->_mpos = $results[0]["m-pos"];
      $this->_msub = $results[0]["m-sub"];
      $this->_load();
    }

	}

  private function _load() {
		$mhw = $this->_mhw;
		$mpos = $this->_mpos;
		$msub = $this->_msub;
    $sql = <<<SQL
    	SELECT `id`
    		FROM `lexemes`
    		WHERE `m-hw` = :mhw
    		AND `m-pos` = :mpos
    		AND `m-sub` = :msub
        ORDER BY `source`
SQL;
    $results = $this->_db->fetch($sql, array(":mhw" => $mhw, ":mpos" => $mpos, ":msub" => $msub));
    foreach ($results as $nextResult) {
      $this->_instances[] = new entry_instance($nextResult["id"]);
    }
    $sql = <<<SQL
    	SELECT `m-p-hw`, `m-p-pos`, `m-p-sub`
    		FROM `parts`
    		WHERE `m-hw` = :mhw
    		AND `m-pos` =  :mpos
    		AND `m-sub` =  :msub
SQL;
    $results = $this->_db->fetch($sql, array(":mhw" => $mhw, ":mpos" => $mpos, ":msub" => $msub));
    foreach ($results as $nextResult) {
      $this->_parts[] = [$nextResult["m-p-hw"], $nextResult["m-p-pos"], $nextResult["m-p-sub"]];
    }
    $sql = <<<SQL
    	SELECT `m-hw`, `m-pos`, `m-sub`
    		FROM `parts`
    		WHERE `m-p-hw` = :mhw
    		AND `m-p-pos` = :mpos
    		AND `m-p-sub` = :msub
        ORDER BY LENGTH(`m-hw`)
SQL;
    $results = $this->_db->fetch($sql, array(":mhw" => $mhw, ":mpos" => $mpos, ":msub" => $msub));
    foreach ($results as $nextResult) {
    	$this->_compounds[] = [$nextResult["m-hw"], $nextResult["m-pos"], $nextResult["m-sub"]];
    }
    $sql = <<<SQL
			SELECT `id`, `slipref`
				FROM `slips`
				WHERE `mhw` = :mhw
				AND `mpos` = :mpos 
				AND `msub` = :msub
				ORDER BY slipref
SQL;
		$results = $this->_db->fetch($sql, array(":mhw" => $mhw, ":mpos" => $mpos, ":msub" => $msub));
		foreach ($results as $nextResult) {
			$this->_slips[$nextResult["id"]] = $nextResult["slipref"];
		}
 	}

  public function getMhw() {
    return $this->_mhw;
	}

  public function getMpos() {
    return $this->_mpos;
  }

  public function getMsub() {
    return $this->_msub;
  }

  public function getInstances() {
    return $this->_instances;
  }

  public function getParts() {
    return $this->_parts;
  }

  public function getSlips() {
		return $this->_slips;
  }

  /*
   * Queries Meanma for slip info and returns a StdClass object for each slipId and its info in key value pairs.
   */
  public function getSlipInfo() {
		foreach ($this->getSlips() as $slipId) {
			$url = "https://dasg.ac.uk/meanma/ajax.php?action=loadSlipData&groupId={$_SESSION["groupId"]}&id=" . $slipId;
			$data = file_get_contents($url);
			$slipInfo[$slipId] = json_decode($data);
		}
		return $slipInfo;
  }

  public function getCompounds() {
    return $this->_compounds;
  }

  public static function getPosInfo($pos) {
    switch ($pos) {
      case "m":
        return ['fir.', 'ainmear fireann', 'masculine noun'];
        break;
      case "f":
        return ['boir.', 'ainmear boireann', 'feminine noun'];
        break;
      case "ff":
        return ['boir.', 'ainm boireann', 'feminine proper noun'];
        break;
      case "n":
        return ['boir./fir.', 'ainmear (fireann/boireann)', 'noun (masculine/feminine)'];
        break;
      case "v":
        return ['gn.', 'gnìomhair', 'verb'];
        break;
      case "a":
        return ['bua.', 'buadhair', 'adjective'];
        break;
      case "p":
        return ['roi.', 'roimhear', 'preposition'];
        break;
      case "pl":
        return ['iol.', 'iolra', 'plural'];
        break;
      case "gen":
        return ['gin.', 'ginideach', 'genitive'];
        break;
      case "comp":
        return ['coim.', 'coimeasach', 'comparative'];
        break;
      case "vn":
        return ['ainm.', 'ainmear gnìomaireach', 'verbal noun'];
        break;
      case "x":
        return ['', '', ''];
        break;
      default:
        return [$pos, $pos, $pos];
    }
  }

}
