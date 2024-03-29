<?php

namespace models;

class search {

  private $_search = ""; // the search term
  private $_entriesEN = array(); // an array of hw-pos-sub-en 4-tuples
  private $_entriesGD = array(); // an array of hw-pos-sub-althw+form 4-tuples
  private $_db;   // an instance of models\database

  public function __construct() {
    if (isset($_GET["search"])) {
      $this->_search = $_GET["search"];
      $this->_db = isset($this->_db) ? $this->_db : new database();
      $this->_load();
    }
  }

  private function _load() {
    $results = [];
    $results = $this->_englishExactSearch();
    $results = array_merge($results,$this->_englishPrefixSpaceSearch());
    $results = array_merge($results,$this->_englishSuffixSpaceSearch());
    $results = array_merge($results,$this->_englishInfixSpaceBothSearch());
    if (count($results)<100) {
      $results = array_merge($results,$this->_englishPrefixNoSpaceSearch());
    }
    if (count($results)<100) {
      $results = array_merge($results,$this->_englishSuffixNoSpaceSearch());
    }
    if (count($results)<100) {
      $results = array_merge($results,$this->_englishInfixSpaceLeftSearch());
    }
    if (count($results)<100) {
      $results = array_merge($results,$this->_englishInfixSpaceRightSearch());
    }
    foreach ($results as $nextResult) {
  	$this->_entriesEN[] = explode('|',$nextResult);
    }
    $results = [];
    $results = $this->_gaelicExactHwSearch();
    $results = array_merge($results,$this->_gaelicExactFormSearch());
    $results = array_merge($results,$this->_gaelicPrefixHwSpaceSearch());
    $results = array_merge($results,$this->_gaelicSuffixHwSpaceSearch());
    $results = array_merge($results,$this->_gaelicInfixHwSpaceBothSearch());
    if (count($results)<100) {
      $results = array_merge($results,$this->_gaelicPrefixHwNoSpaceSearch());
    }
    if (count($results)<100) {
      $results = array_merge($results,$this->_gaelicSuffixHwNoSpaceSearch());
    }
    if (count($results)<100) {
      $results = array_merge($results,$this->_gaelicInfixHwSpaceLeftSearch());
    }
    if (count($results)<100) {
      $results = array_merge($results,$this->_gaelicInfixHwSpaceRightSearch());
    }
    // GD forms as infixes etc??
    // GD lenition on suffixes and infixes??
    foreach ($results as $nextResult) {
      $this->_entriesGD[] = explode('|',$nextResult);
    }
	}

  private function _englishExactSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, e.`en`
      FROM `lexemes` l
      JOIN `english` e ON l.`id` = e.`lexeme_id`
      WHERE e.`en` = :en
      ORDER BY `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":en" => $this->_search));
    $oot = [];
    foreach ($results as $nextResult) {
      $oot[] = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|' . $nextResult["en"];
    }
    return $oot;
  }

  private function _englishPrefixSpaceSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, e.`en`
      FROM `lexemes` l
      JOIN `english` e ON l.`id` = e.`lexeme_id`
      WHERE e.`en` REGEXP :en
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":en" => '^' . $this->_search . '[ -].*'));
    $oot = [];
    foreach ($results as $nextResult) {
      $oot[] = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|' . $nextResult["en"];
    }
    return $oot;
  }

  private function _englishSuffixSpaceSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, e.`en`
      FROM `lexemes` l
      JOIN `english` e ON l.`id` = e.`lexeme_id`
      WHERE e.`en` REGEXP :en
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":en" => '.*[ -]' . $this->_search . '$'));
    $oot = [];
    foreach ($results as $nextResult) {
      $oot[] = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|' . $nextResult["en"];
    }
    return $oot;
  }

  private function _englishInfixSpaceBothSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, e.`en`
      FROM `lexemes` l
      JOIN `english` e ON l.`id` = e.`lexeme_id`
      WHERE e.`en` REGEXP :en
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":en" => '.*[ -]' . $this->_search . '[ -].*'));
    $oot = [];
    foreach ($results as $nextResult) {
      $oot[] = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|' . $nextResult["en"];
    }
    return $oot;
  }

  private function _englishPrefixNoSpaceSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, e.`en`
      FROM `lexemes` l
      JOIN `english` e ON l.`id` = e.`lexeme_id`
      WHERE e.`en` REGEXP :en
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":en" => '^' . $this->_search . '[^ -].*'));
    $oot = [];
    foreach ($results as $nextResult) {
      $oot[] = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|' . $nextResult["en"];
    }
    return $oot;
  }

  private function _englishSuffixNoSpaceSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, e.`en`
      FROM `lexemes` l
      JOIN `english` e ON l.`id` = e.`lexeme_id`
      WHERE e.`en` REGEXP :en
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":en" => '.*[^ -]' . $this->_search . '$'));
    $oot = [];
    foreach ($results as $nextResult) {
      $oot[] = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|' . $nextResult["en"];
    }
    return $oot;
  }

  private function _englishInfixSpaceLeftSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, e.`en`
      FROM `lexemes` l
      JOIN `english` e ON l.`id` = e.`lexeme_id`
      WHERE e.`en` REGEXP :en
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":en" => '.*[ -]' . $this->_search . '[^ -].*'));
    $oot = [];
    foreach ($results as $nextResult) {
      $oot[] = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|' . $nextResult["en"];
    }
    return $oot;
  }

  private function _englishInfixSpaceRightSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, e.`en`
      FROM `lexemes` l
      JOIN `english` e ON l.`id` = e.`lexeme_id`
      WHERE e.`en` REGEXP :en
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":en" => '.*[^ -]' . $this->_search . '[ -].*'));
    $oot = [];
    foreach ($results as $nextResult) {
      $oot[] = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|' . $nextResult["en"];
    }
    return $oot;
  }

  private function _gaelicExactHwSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, `hw`
      FROM `lexemes`
      WHERE `hw` = :gd
      ORDER BY `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":gd" => $this->_search));
    $oot = [];
    foreach ($results as $nextResult) {
      $str = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|';
      if ($nextResult["hw"]!=$nextResult["m-hw"]) { $str .= $nextResult["hw"]; }
      $oot[] = $str;
    }
    return $oot;
  }

  private function _gaelicExactFormSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, f.`form`, f.`morph`
      FROM `lexemes` l
      JOIN `forms` f ON l.`id` = f.`lexeme_id`
      WHERE f.`form` = :gd
      ORDER BY `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":gd" => $this->_search));
    $oot = [];
    foreach ($results as $nextResult) {
      $oot[] = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|' . $nextResult["form"] . ' <em>' . $nextResult["morph"] . '</em>';
    }
    return $oot;
  }

  private function _gaelicPrefixHwSpaceSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, `hw`
      FROM `lexemes`
      WHERE `hw` LIKE :gd1 OR `hw` LIKE :gd2
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":gd1" => $this->_search . ' %', ":gd2" => $this->_search . '-%'));
    $oot = [];
    foreach ($results as $nextResult) {
      $str = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|';
      if ($nextResult["hw"]!=$nextResult["m-hw"]) { $str .= $nextResult["hw"]; }
      $oot[] = $str;
    }
    return $oot;
  }

  private function _gaelicSuffixHwSpaceSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, `hw`
      FROM `lexemes`
      WHERE `hw` LIKE :gd1 OR `hw` LIKE :gd2
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":gd1" => '% ' . $this->_search, ":gd2" => '%-' . $this->_search));
    $oot = [];
    foreach ($results as $nextResult) {
      $str = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|';
      if ($nextResult["hw"]!=$nextResult["m-hw"]) { $str .= $nextResult["hw"]; }
      $oot[] = $str;
    }
    return $oot;
  }

  private function _gaelicInfixHwSpaceBothSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, `hw`
      FROM `lexemes`
      WHERE `hw` LIKE :gd1 OR `hw` LIKE :gd2 OR `hw` LIKE :gd3 OR `hw` LIKE :gd4
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql,
      array(":gd1" => '% ' . $this->_search . ' %',
            ":gd2" => '%-' . $this->_search . ' %',
            ":gd3" => '% ' . $this->_search . '-%',
            ":gd4" => '%-' . $this->_search . '-%'
          ));
    $oot = [];
    foreach ($results as $nextResult) {
      $str = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|';
      if ($nextResult["hw"]!=$nextResult["m-hw"]) { $str .= $nextResult["hw"]; }
      $oot[] = $str;
    }
    return $oot;
  }

  private function _gaelicPrefixHwNoSpaceSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, `hw`
      FROM `lexemes`
      WHERE `hw` LIKE :gd1 AND `hw` NOT LIKE :gd2 AND `hw` NOT LIKE :gd3 AND `hw` != :gd4
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":gd1" => $this->_search . '%',
                                             ":gd2" => $this->_search . ' %',
                                             ":gd3" => $this->_search . '-%',
                                             ":gd4" => $this->_search));
    $oot = [];
    foreach ($results as $nextResult) {
      $str = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|';
      if ($nextResult["hw"]!=$nextResult["m-hw"]) { $str .= $nextResult["hw"]; }
      $oot[] = $str;
    }
    return $oot;
  }

  private function _gaelicSuffixHwNoSpaceSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, `hw`
      FROM `lexemes`
      WHERE `hw` LIKE :gd1 AND `hw` NOT LIKE :gd2 AND `hw` NOT LIKE :gd3 AND `hw` != :gd4
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":gd1" => '%' . $this->_search,
                                             ":gd2" => '% ' . $this->_search,
                                             ":gd3" => '%-' . $this->_search,
                                             ":gd4" => $this->_search));
    $oot = [];
    foreach ($results as $nextResult) {
      $str = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|';
      if ($nextResult["hw"]!=$nextResult["m-hw"]) { $str .= $nextResult["hw"]; }
      $oot[] = $str;
    }
    return $oot;
  }

  private function _gaelicInfixHwSpaceLeftSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, `hw`
      FROM `lexemes`
      WHERE (`hw` LIKE :gd1 OR `hw` LIKE :gd2) AND `hw` NOT LIKE :gd3 AND `hw` NOT LIKE :gd4 AND `hw` NOT LIKE :gd5 AND `hw` NOT LIKE :gd6 AND `hw` NOT LIKE :gd7
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":gd1" => '% ' . $this->_search . '%',
                                             ":gd2" => '%-' . $this->_search . '%',
                                             ":gd3" => '% ' . $this->_search . ' %',
                                             ":gd4" => '% ' . $this->_search . '-%',
                                             ":gd5" => '%-' . $this->_search . ' %',
                                             ":gd6" => '%-' . $this->_search . '-%',
                                             ":gd7" => '%' . $this->_search
                                           ));
    $oot = [];
    foreach ($results as $nextResult) {
      $str = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|';
      if ($nextResult["hw"]!=$nextResult["m-hw"]) { $str .= $nextResult["hw"]; }
      $oot[] = $str;
    }
    return $oot;
  }

  private function _gaelicInfixHwSpaceRightSearch() {
    $sql = <<<SQL
    SELECT DISTINCT `m-hw`, `m-pos`, `m-sub`, `hw`
      FROM `lexemes`
      WHERE (`hw` LIKE :gd1 OR `hw` LIKE :gd2) AND `hw` NOT LIKE :gd3 AND `hw` NOT LIKE :gd4 AND `hw` NOT LIKE :gd5 AND `hw` NOT LIKE :gd6 AND `hw` NOT LIKE :gd7
      ORDER BY LENGTH(`m-hw`), `m-hw`
SQL;
    $results = $this->_db->fetch($sql, array(":gd1" => '%' . $this->_search . ' %',
                                             ":gd2" => '%' . $this->_search . '-%',
                                             ":gd3" => '% ' . $this->_search . ' %',
                                             ":gd4" => '% ' . $this->_search . '-%',
                                             ":gd5" => '%-' . $this->_search . ' %',
                                             ":gd6" => '%-' . $this->_search . '-%',
                                             ":gd7" => $this->_search . '%'
                                           ));
    $oot = [];
    foreach ($results as $nextResult) {
      $str = $nextResult["m-hw"] . '|' . $nextResult["m-pos"] . '|'. $nextResult["m-sub"] . '|';
      if ($nextResult["hw"]!=$nextResult["m-hw"]) { $str .= $nextResult["hw"]; }
      $oot[] = $str;
    }
    return $oot;
  }

  // GETTERS

  public function getSearch() {
    return $this->_search;
  }

  public function getEntriesEN() {
    return $this->_entriesEN;
	}

  public function getEntriesGD() {
    return $this->_entriesGD;
	}

}
