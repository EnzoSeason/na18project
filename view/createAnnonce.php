<?php
$today = getdate();
$dateToday = $today['year'].'-'.$today['mon'].'-'.$today['mday'].' '.$today['hours'].':'.$today['minutes'].":".$today['seconds'];
echo $dateToday;
?>