<?php

namespace models;

class entry {

    private $_id;
    private $_hw;
    private $_pos;
    //private $_instances = array(); // an array of entry_instance models
    //private $_parts = array();
    //private $_compounds = array();
    //private $_slips = array();
    //private $_sense; // SENSE STRUCTURE, WITH CITATIONS
	//private $_senseId = null;
    private $_db;   // an instance of models\database

	public function __construct($id,$db) {
        if ($id!=null) {
            $this->_id = $id;
            if ($db) { // check the database?
                $this->_db = isset($this->_db) ? $this->_db : new database();
    		    $this->_load();
            }
        } 
        else { // random entry
            $this->_db = isset($this->_db) ? $this->_db : new database();
            $sql = "SELECT id FROM entry ORDER BY RAND() LIMIT 1";
            $results = $this->_db->fetch($sql);
            $this->_id = $results[0]["id"];
            $this->_load();
        }
	}

  private function _load() {
        $id = $this->_id;
		//$mhw = $this->_mhw;
		//$mpos = $this->_mpos;
		//$msub = $this->_msub;
    $sql = <<<SQL
    	SELECT hw, pos
    		FROM entry
    		WHERE id = :id
SQL;
    $results = $this->_db->fetch($sql, array(":id" => $id));
    $this->_hw = $results[0]["hw"];
    $this->_pos = $results[0]["pos"];
    
    //foreach ($results as $nextResult) {
      //$this->_instances[] = new entry_instance($nextResult["id"]);
    //}
    
    /*
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
    */
    
    
    /*
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
	  $sql = <<<SQL
			SELECT `senseid`
				FROM `senses`
				WHERE `mhw` = :mhw
				AND `mpos` = :mpos
				AND `msub` = :msub
SQL;
	  $result = $this->_db->fetch($sql, array(":mhw" => $mhw, ":mpos" => $mpos, ":msub" => $msub));
	  $this->_senseId = $result[0]["senseid"];
    */
 	}

  public function getHw() {
    return $this->_hw;
	}

  public function getPos() {
    return $this->_pos;
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
    //$slipInfo = [];
		foreach ($this->getSlips() as $slipId) {
			$url = "https://dasg.ac.uk/meanma/ajax.php?action=loadSlipData&groupId={$_SESSION["groupId"]}&id=" . $slipId;
			$data = file_get_contents($url);
			$slipInfo[$slipId] = json_decode($data);
		}
		return $slipInfo;
  }

	/*
 * Queries Meanma for sense info and returns an HTML list.
 */
	public function getSenseInfo() {
		if ($this->getSenseId() == null) {
			return "";
		}
		$url = "https://dasg.ac.uk/meanma/ajax.php?action=loadSenseData&id=" . $this->getSenseId();
		$html = file_get_contents($url);
		return $html;
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
      case "mm":
        return ['fir.', 'ainm fireann', 'masculine proper noun'];
        break;
      case "n":
        return ['ainm.', 'ainmear (fireann/boireann)', 'noun (masculine/feminine)'];
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
      default:
        return [$pos, $pos, $pos];
    }
  }

  public function getSenseId() {
		return $this->_senseId;
  }

}
