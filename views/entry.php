<?php

namespace views;
use models;

class entry {

	private $_model;   // an instance of models\entries

	public function __construct($model) {
		$this->_model = $model;
	}

	public function show($action) {
		return $this->_writeInfo();
	}

  private function _writeInfo() {
		$html = '<div class="modal-header">';
		$html .= '<h2>' . $this->_model->getMhw() . '</h2>';
		$html .= '<em class="text-muted" data-toggle="tooltip" title="' . models\entry::getPosInfo($this->_model->getMpos())[2] . '">' . models\entry::getPosInfo($this->_model->getMpos())[1] . '</em>';
		$html .= '</div>';
		$html .= '<div class="modal-body">';
		$ps = $this->_model->getParts();
    if ($ps) {
		  $html .= '<p>↗️ ';
		  foreach ($ps as $nextPart) {
		  	$html .= <<<HTML
			  <a href="#" class="entryRow"
					data-mhw="{$nextPart[0]}" data-mpos="{$nextPart[1]}" data-msub="{$nextPart[2]}">
					{$nextPart[0]}
				</a>
HTML;
			  $html .= '<em>' . models\entry::getPosInfo($nextPart[1])[0] . '</em> ';
			  if ($nextPart!=end($ps)) { $html .= ' | '; }
		  }
	    $html .= '</p>';
    }
		$html .= '<div class="list-group">';
		foreach ($this->_model->getInstances() as $nextInstance) {
			$view = new entry_instance($nextInstance);
			$html .= $view->show();
		}
		$html .= '</div>';
		$html .= '<p> </p>';
		$cs = $this->_model->getCompounds();
		if ($cs) {
			$html .= '<p>↘️ ';
			foreach ($cs as $nextCompound) {
				$html .= <<<HTML
			  <a href="#" class="entryRow"
					data-mhw="{$nextCompound[0]}" data-mpos="{$nextCompound[1]}" data-msub="{$nextCompound[2]}">
					{$nextCompound[0]}
				</a>
HTML;
				$html .= '<em>' . models\entry::getPosInfo($nextCompound[1])[0] . '</em>';
        if ($nextCompound!=end($cs)) { $html .= ' <span class="text-muted">|</span> '; }
			}
			$html .= '</p>';

		}
	  if ($slips = $this->_model->getSlipInfo()) {
	  	foreach ($slips as $slip) {
	  		$context = $slip->context->pre->output . "<mark>" . $slip->context->word . "</mark>" . $slip->context->post->output;
	  		$html .= <<<HTML
					<div class="slip">
						<div>{$context}</div>
						<div><small><em>{$slip->translation}</em></small></div>
						<div style="margin:-15px 0 20px 0;">#{$slip->tid}, p{$slip->page}</div>
					</div>
HTML;
		  }
	  }
		$html .= '</div>';
    $html .= <<<HTML
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">dùin</button>
		</div>
HTML;
		return $html;
	}
}
