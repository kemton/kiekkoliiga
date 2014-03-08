Kiekkoliiga
===========

Kiekkoliiga is ice-hockey league which based on kiekko.tk multiplayer ice-hockey game

## Deploy

Database structure and some test data still missing! So note that deploy introduction is not yet totally ready.

Clone repository:

	$ git clone https://github.com/kiuru/kiekkoliiga.git

#### Config file
Create Config.php file in to cloned repository root:

	<?php
	// /Config.php

	// Database config 
	define('HOST', 'localhost');
	define('DBNAME', 'database_name');
	define('DSN', 'mysql:host='.HOST.';dbname='.DBNAME);
	define('USERNAME', 'user_name');
	define('PASSWORD', 'user_password');

	// PandaBot auth-system
	define('PANDABOTPASS', 'hiddened_password');

	// Kiekko API url
	define('KIEKKOAPI', 'http://beta.kiekko.tk/API/');

	define('DEBUG_MODE', TRUE);

	define('path', '/'); // Kiekkoliiga sites root directory
	define('srcdir', dirname(__FILE__) . '/');
	define('viewDir', srcdir . 'views/');
	define('incDir', srcdir . 'views/includes/');

	// How many points winning team take?
	define('winPoints', 3);
	?>

#### Forum
Create forum directory in repository root:

	$ mkdir forum && cd forum

Download latest smf forum and extract it.

	$ curl -L http://www.simplemachines.org/download/index.php/latest/install/ -o smf_latest.tar.gz
	$ tar xvf smf_latest.tar.gz
	$ rm smf_latest.tar.gz

Open /forum/index.php via web browser and setup your forum.