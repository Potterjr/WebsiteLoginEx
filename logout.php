<?php
session_start();
session_destroy();
echo "2 second";
header("Refresh: 2; url=index.html");
?>
