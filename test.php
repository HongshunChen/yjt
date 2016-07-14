<?php

	$fp = fopen('a.txt', 'w');
	mkdir('test111', 0777);
	fwrite($fp, 'hell');
	fclose($fp);