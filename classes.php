<?php

function portionContestants($_contestants,$portion_id) {
	
	$contestants = [];
	
	foreach ($_contestants as $i => $_contestant) {

		$portions = explode(",",$_contestant['portions']);
		
		foreach ($portions as $portion) {
		
			if ($portion == $portion_id) $contestants[] = $_contestant;
		
		}

	};
	
	return $contestants;
	
};

?>