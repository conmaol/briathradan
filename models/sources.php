<?php

namespace models;

class sources {

  public static function getShortRef($id) {
    switch ($id) {
    	case "101":
    		return 'Eaglais &amp; Bìoball';
    		break;
      case "102":
      	return 'Rianachd Phoblach';
      	break;
      case "103":
      	return 'Foghlam Sgoile';
      	break;
      case "104":
      	return 'Glèidteachas nàdair';
      	break;
    	case "122":
    		return 'Dwelly';
    		break;
    	case "23":
    		return 'LXCP';
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
    		return 'Briathran eaglaiseil (Eaglais na h-Alba, <em>Am Bìoball</em>)';
    		break;
      case "102":
      	return 'Briathran airson rianachd poblaich (<em>Faclair na Pàrlamaid</em>, <em>Faclair Rianachd Phoblaich</em>)';
      	break;
      case "103":
      	return 'Briathran airson sgoiltean (Stòrlann, Foghlam Alba)';
      	break;
      case "104":
      	return 'Briathran à Buidhinn Nàdair na h-Alba';
      	break;
    	case "122":
    		return 'Briathran à Dwelly – <em>Faclair Gàidhlig gu Beurla le Dealbhan</em>';
    		break;
    	case "23":
    		return 'Briathran à stòr <em>Lexicopia</em>';
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
        return '🎒';
        break;
      case "104":
        return '🌿';
        break;
      case "122":
        return '🗝';
        break;
      case "23":
        return '♒️';
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
