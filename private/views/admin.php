<?php

namespace views;

class admin {

	public function show() {
    $html = <<<HTML
      <div class-"list-group list-group-flush">
        <a class="list-group-item list-group-item-action" href="?m=entries">faclan</a>
				<a class="list-group-item list-group-item-action" href="?m=sources">faclairean</a>
				<a class="list-group-item list-group-item-action" href="?m=englishes">beurla</a>
			</div>
HTML;
		echo $html;
	}

}
