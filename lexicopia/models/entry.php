<?php

namespace models;

class entry {

    private $_id;
    private $_hw;
    private $_pos;
    private $_reg;
    //private $_instances = array(); // an array of entry_instance models
    //private $_parts = array();
    //private $_compounds = array();
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
        $sql = <<<SQL
SELECT hw, pos, reg
FROM entry
WHERE id = :id
SQL;
        $results = $this->_db->fetch($sql, array(":id" => $id));
        $this->_hw = $results[0]["hw"];
        $this->_pos = $results[0]["pos"];
        $this->_reg = $results[0]["reg"];
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

    // GETTERS
  
    public function getHw() {
        return $this->_hw;
	}

    public function getPos() {
        return $this->_pos;
    }
  
    public function getReg() {
        return $this->_reg;
    }


  public function getInstances() {
    return $this->_instances;
  }

  public function getParts() {
    return $this->_parts;
  }

  public function getCompounds() {
    return $this->_compounds;
  }

  public static function getPosInfo($pos) {
    switch ($pos) {
      case "m":
        return ['masc.', 'ainmear fireann', 'masculine noun'];
        break;
      case "f":
        return ['fem.', 'ainmear boireann', 'feminine noun'];
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
        return ['vb.', 'gnìomhair', 'verb'];
        break;
      case "a":
        return ['adj.', 'buadhair', 'adjective'];
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

}
