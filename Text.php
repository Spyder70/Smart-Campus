<?php

 if(isset($_SERVER['HTTP_USER_AGENT']))
 { $agent=$_SERVER['HTTP_USER_AGENT'];}
 if((strpos($agent,"firefox")!=FALSE) or (strpos($agent,"Firefox")!=FALSE)){$Frfx=1;}
 
?>
