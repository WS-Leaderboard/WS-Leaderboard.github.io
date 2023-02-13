<?php

define('WSL_SITENAME','WS Community Leaderboard');

define('WSL_DELIMITER',',');
define('WSL_PATH_RANKINGS', WSL_DATA . 'full_rankings.csv');
define('WSL_PATH_GAMES', WSL_DATA . 'full_archive.csv');
define('WSL_PATH_TCORPS', WSL_DATA . 'total_corporations.csv');

/*
	MENU settings

		u : html file
		n : link name
		i : image for index
		a : alt for image
		c : content for index

*/
define('WSL_MENU',[
	[ 'u'=>'index.html','n'=>'Home', 'i'=>'', 'a'=>'', 'c'=>'' ],
	[ 'u'=>'full-rankings.html','n'=>'Full Rankings', 'i'=>'leaderboard-star.svg', 'a'=>'leaderboard', 'c'=>'Rankings of all corporations.' ],
	[ 'u'=>'game_archive.html','n'=>'Game Archives', 'i'=>'archive.svg', 'a'=>'archive', 'c'=>'All historical processed games.' ],
	[ 'u'=>'statistics.html','n'=>'Statistics', 'i'=>'stats-square-up.svg', 'a'=>'stats-square', 'c'=>'Database Stats' ],
	[ 'u'=>'interviews.html','n'=>'Interviews', 'i'=>'mic-speaking.svg', 'a'=>'mic', 'c'=>'Thoughts and advice from the best.' ],
	[ 'u'=>'support.html','n'=>'Support', 'i'=>'discord.svg', 'a'=>'discord', 'c'=>'Join our discord.' ],
	[ 'u'=>'future-features.html','n'=>'Future Features', 'i'=>'grid-add.svg', 'a'=>'grid-add', 'c'=>'Upcoming website functionality.' ]
]);

?>