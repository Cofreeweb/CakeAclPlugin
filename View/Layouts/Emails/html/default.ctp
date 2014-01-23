<?php
$content = $this->fetch('content');
$content = explode("\n", trim( $content));

foreach ($content as $line):
	echo '<p> ' . $line . "</p>\n";
endforeach;
?>