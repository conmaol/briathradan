<?php

namespace views;
use models;

class search {

	private $_model;   // an instance of models\entries

	public function __construct($model) {
		$this->_model = $model;
	}

	public function show() {
		$search = $this->_model->getSearch();
        echo <<<HTML
<div class="ms-3 me-3">
    <form action="#" method="get" autocomplete="off" id="searchForm">
        <div class="mb-3">
		    <div class="input-group">
			    <input id="searchBox" type="text" class="form-control active" name="search"
					autofocus="autofocus" value="{$search}"/>
			    <div class="input-group-append">
				    <button id="searchButton" class="btn btn-primary" type="submit">Siuthad</button>
			    </div>
		    </div>
        </div>
HTML;
        if ($search=='') { // default homepage
			echo <<<HTML
    </form>
    <hr/>
    <p>
    Stòr fhaclan agus abairtean, le pailteas thar-iomraidhean agus eisimpleirean.
	Le taic bho <a href="https://dasg.ac.uk" target="_new">DhASG</a>, 
	bho <a href="http://www.soillse.ac.uk" target="_new">Shoillse</a>, agus
	bho <a href="https://www.gaidhlig.scot" target="_new">Bhòrd na Gàidhlig</a>.
	Beachd thugainn – <code>Mark.McConville@glasgow.ac.uk</code>
    </p>
</div>
HTML;
        }
		else {
            $entriesEN = $this->_model->getEntriesEN();
			$entriesGD = $this->_model->getEntriesGD();
		    if (!(count($entriesEN)+count($entriesGD))) {
			    echo '</form><p>Feuch a-rithist!</p></div>';
				return;
		    }
		    else if (count($entriesEN) && count($entriesGD)) {
                echo <<<HTML
        <div class="mb-3">
	        <div class="form-check form-switch">
		        <input class="form-check-input" type="checkbox" role="switch" id="gdSwitch" data-bs-toggle="tooltip" title="Switch language"/>
				<!-- <label class="form-check-label" for="inlineCheckbox1gdSwitch"><small>Gàidhlig</small></label> -->
	        </div>
        </div>
HTML;
			}
echo <<<HTML
	</form>
</div>
<div class="list-group list-group-flush">
HTML;
            if (count($entriesEN)) {
				foreach ($entriesEN as $nextEntry) {
	                echo <<<HTML
<a href="#" class="entryRow list-group-item list-group-item-action"
		data-bs-toggle="modal" data-bs-target="#entryModal"
		data-mhw="{$nextEntry[0]}" data-mpos="{$nextEntry[1]}" data-msub="{$nextEntry[2]}">
	<strong>{$nextEntry[0]}</strong>
	<em>
HTML;
	                echo models\entry::getPosInfo($nextEntry[1])[0];
	                echo '</em> <span class="text-muted">' . search::_hi($nextEntry[3],$search) . '</span></a>';
                }
				foreach ($entriesGD as $nextEntry) {
	                echo <<<HTML
<a href="#" class="entryRow list-group-item list-group-item-action" style="display:none;"
		    data-bs-toggle="modal" data-bs-target="#entryModal"
		    data-mhw="{$nextEntry[0]}" data-mpos="{$nextEntry[1]}" data-msub="{$nextEntry[2]}">
	<strong>
HTML;
                    echo search::_hi($nextEntry[0],$search);
	                echo '</strong> <em>' . models\entry::getPosInfo($nextEntry[1])[0] . '</em>';
	                echo ' <span class="text-muted">' . search::_hi($nextEntry[3],$search) . '</span></a>';
                }
			}
			else {
				foreach ($entriesGD as $nextEntry) {
	                echo <<<HTML
<a href="#" class="entryRow list-group-item list-group-item-action"
		    data-bs-toggle="modal" data-bs-target="#entryModal"
		    data-mhw="{$nextEntry[0]}" data-mpos="{$nextEntry[1]}" data-msub="{$nextEntry[2]}">
	<strong>
HTML;
                    echo search::_hi($nextEntry[0],$search);
	                echo '</strong> <em>' . models\entry::getPosInfo($nextEntry[1])[0] . '</em>';
	                echo ' <span class="text-muted">' . search::_hi($nextEntry[3],$search) . '</span></a>';
                }
			}	
            echo '</div>';
	    }
	}

	private static function _hi($string,$search) { // highlights all instances of a search term in a string
		if (strpos($string,$search)>-1) {
			return str_replace($search,'<span style="text-decoration:underline;text-decoration-color:red;">'.$search.'</span>',$string);
		}
        else {
            $search = ucfirst($search);
			if (strpos($string,$search)>-1) {
				return str_replace($search,'<span style="text-decoration:underline;text-decoration-color:red;">'.$search.'</span>',$string);
			}
		    else {
			    return $string;
		    }
		}
	}
}
