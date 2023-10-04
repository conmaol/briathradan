<?php

namespace models;

class sources {

  public static function getShortRef($id) {
    switch ($id) {
    	case "101":
    		return 'Eaglais';
    		break;
      case "102":
      	return 'Rianachd Phoblach';
      	break;
      case "103":
      	return 'Sgoil';
      	break;
      case "104":
      	return 'Nàdar';
      	break;
      case "105":
      	return 'SMO';
      	break;
      case "122":
    	return 'Dwelly';
    	break;
      case "23":
    	return '';
    	break;
      case "223":
      	return 'ALT-LXCP';
      	break;
      case "323":
      	return 'EX-LXCP';
      	break;
      default:
    		return '[unknown]';
    }
	}

  public static function getRef($id) {
    switch ($id) {
    	case "101":
    		return 'Eaglais na h-Alba';
    		break;
      case "102":
      	return 'Rianachd poblaich (Faclair na Pàrlamaid, Faclair Rianachd Phoblaich)';
      	break;
      case "103":
      	return 'Sgoiltean (Stòrlann, Foghlam Alba)';
      	break;
      case "104":
      	return 'Buidheann Nàdair na h-Alba';
      	break;
      case "105":
      	return 'An Stòr-Dàta';
      	break;
      case "122":
    		return 'Dwelly – Faclair Gàidhlig gu Beurla le Dealbhan';
    		break;
      case "23":
    		return 'Stòr DASG';
    		break;
      case "223":
      	return 'Roghainnean eile';
      	break;
      case "323":
      	return 'Eisimpleirean';
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
        return '🗳';
        break;
      case "103":
        return '🧒🏻';
        break;
      case "104":
        return '🌿';
        break;
      case "105":
        return '🏫';
        break;
      case "122":
        return '🐲';
        break;
      case "23":
        //return '♒️';
		return '🏵️';
        break;
      case "223":
        return '✳️';
        break;
      case "323":
        return 'ℹ️';
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
