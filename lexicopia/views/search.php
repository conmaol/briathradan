<?php

namespace views;
use models;

class search {

    private $_model;   // an instance of models\search

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
			echo '</form><hr/><p>Blah.</p></div>';
        }
        else {
            $entriesEN = $this->_model->getEntriesEN();
            $entriesGD = $this->_model->getEntriesGD();
            if (!(count($entriesEN)+count($entriesGD))) { // no results
	            echo '</form><p>No results – try again.</p></div>';
	            return;
            }
	        else if (count($entriesEN) && count($entriesGD)) { // both languages
                echo <<<HTML
<div class="mb-3">
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="gdSwitch" data-bs-toggle="tooltip" title="Switch language"/>
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
<a href="#" class="entryRow list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#entryModal" data-id="{$nextEntry[0]}" title="{$nextEntry[0]}">
	<strong>{$nextEntry[1]}</strong>
	<em><span class="text-muted">
HTML;
	                echo models\entry::getPosInfo($nextEntry[2])[0];
	                echo '</span></em> <span class="text-muted">' . search::_hi($nextEntry[3],$search) . '</span></a>';
                }
				foreach ($entriesGD as $nextEntry) {
	                echo <<<HTML
<a href="#" class="entryRow list-group-item list-group-item-action" style="display:none;" data-bs-toggle="modal" data-bs-target="#entryModal" data-id="{$nextEntry[0]}" title="{$nextEntry[0]}">
	<strong>
HTML;
                    echo search::_hi($nextEntry[1],$search);
	                echo '</strong> <em>' . models\entry::getPosInfo($nextEntry[2])[0] . '</em>';
	                if (count($nextEntry)>3) { echo ' <span class="text-muted">' . search::_hi($nextEntry[3],$search) . '</span></a>'; }
	                echo '</a>';
                }
			}
			else { // no English results
				foreach ($entriesGD as $nextEntry) {
	                echo <<<HTML
<a href="#" class="entryRow list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#entryModal"
		    data-id="{$nextEntry[0]}" title="{$nextEntry[0]}">
	<strong>
HTML;
                    echo search::_hi($nextEntry[1],$search);
	                echo '</strong> <em>' . models\entry::getPosInfo($nextEntry[2])[0] . '</em>';
	                if (count($nextEntry)>3) { echo ' <span class="text-muted">' . search::_hi($nextEntry[3],$search) . '</span></a>'; }
	                echo '</a>';
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
