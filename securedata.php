<?php 
function msec($securedata)
{
//return trim(stripslashes(filter_var($securedata, FILTER_SANITIZE_STRING)));
return trim(stripslashes(htmlspecialchars($securedata)));
}
?>