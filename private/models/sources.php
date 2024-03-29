<?php

namespace models;

class sources {

  private $_sources = array(); // an array of source ids
  private $_db;   // an instance of models\database

	public function __construct() {
		$this->_db = isset($this->_db) ? $this->_db : new database();
		$this->_load();
	}

  private function _load() {
    $query = <<<SQL
    	SELECT DISTINCT `source`
    		FROM `lexemes`
    		ORDER BY `source`
SQL;
    $results = $this->_db->fetch($query);
		foreach ($results as $nextResult) {
			$this->_sources[] = $nextResult["source"];
		}
	}

  public function getSources() {
    return $this->_sources;
	}

  public static function getShortRef($id) {
    switch ($id) {
    	case "101":
    		return 'Eaglais na h-Alba';
    		break;
      case "102":
      	return 'Faclair Rianachd Phoblaich';
      	break;
      case "103":
      	return 'An Seotal';
      	break;
      case "104":
      	return 'Dualchas Nàdair na h-Alba';
      	break;
    	case "122":
    		return 'Dwelly';
    		break;
    	case "23":
    		return 'LEACAN supplement';
    		break;
    	default:
    		return '[unknown]';
    }
	}

  public static function getRef($id) {
    switch ($id) {
    	case "101":
    		return 'Eaglais na h-Alba – <em>Handbook of Biblical and Ecclesiastical Gaelic</em>';
    		break;
      case "102":
      	return 'Faclair Rianachd Phoblaich';
      	break;
      case "103":
      	return 'An Seotal';
      	break;
      case "104":
      	return 'Dualchas Nàdair na h-Alba – <em>Faclan Nàdair</em>';
      	break;
    	case "122":
    		return 'Dwelly – <em>Faclair Gàidhlig gu Beurla le Dealbhan</em>';
    		break;
    	case "23":
    		return 'LEACAN supplement to Dwelly';
    		break;
    	default:
    		return '[unknown]';
    }
	}

  public static function getEmoji($id) {
    switch ($id) {
      case "101":
        return '⛪️';
        break;
      case "102":
        return '📎';
        break;
      case "103":
        return '🎒';
        break;
      case "104":
        return '🦆';
        break;
      case "122":
        return '🧩';
        break;
      case "23":
        return '♒️';
        break;
      default:
        return '';
    }
  }

  public static function getExtLink($id) {
    switch ($id) {
    	case "101":
    		return 'https://www.churchofscotland.org.uk/__data/assets/pdf_file/0011/68708/ER-Gaelic-HANDBOOK-V5.pdf';
    		break;
      case "102":
    		return 'https://www.cne-siar.gov.uk/media/4714/gaelicenglish.pdf';
    		break;
    	default:
    		return '';
    }
	}

}
