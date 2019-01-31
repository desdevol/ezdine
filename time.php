<?php
date_default_timezone_set("Asia/Singapore");
$today=getdate(date("U"));
$currentDate = date('Y-m-d');
$currentMonth = date('Y/m');
$minusOneDay = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($currentDate) ) ));
$yesterdayMonth = substr($minusOneDay, 0, 7);

$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');


//echo "$today[weekday], $today[month] $today[mday] $today[year]";
?>
