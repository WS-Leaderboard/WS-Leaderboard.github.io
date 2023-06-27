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

define('WSL_HTML',[
	// COMMENT
	'comment' => '<!-- Phantom by HTML5 UP : html5up.net | @ajlkn :: Free for personal and commercial use under the CCA 3.0 license (html5up.net/license) -->',
	// HEAD
	'head' => '<meta http-equiv="content-type" content="text/html; charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="color-scheme" content="dark light">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;700;900&display=swap" rel="stylesheet">
	<link rel="icon" type="image/png" href="/images/favicon.png">',
	// HEAD links
	'headlinks' => ['<script>if (localStorage.theme === "dark" || (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)) { document.documentElement.classList.add("darkmode") } else { document.documentElement.classList.remove("darkmode") }</script>','main.css','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css','<noscript><link rel="stylesheet" href="/assets/css/noscript.min.css" type="text/css" media="all" /></noscript>'],
	// BODY start
	'body' => '<header id="header">
				<div class="inner">
						<a href="/index.html" class="logo">
							<span class="symbol"><img src="/images/logo.svg" alt="logo" /></span><span class="title">Home</span>
						</a>
						<nav>
							<ul>
								<li><a href="#menu">Menu</a></li>
							</ul>
						</nav>
				</div>
			</header>',
	// FOOTER as end
	'footer' => '<footer id="footer">
			<div class="inner">
				<section>
					<h2>Get In Touch</h2>
					<ul class="icons">
						<li><a href="https://discord.gg/p588eHaFqh" aria-label="Discord" class="icon brands style2 fa-discord"><span class="label">Discord</span></a></li>
					</ul>
				</section>
				<ul class="copyright">
					<li>Created by Timmeh</li>
					<li>Website by KypDuron</li>
					<li>Backend by NandGates</li>
					<li>Phantom site template by <a href="http://html5up.net" target="_blank">HTML5 UP</a></li>
					<li>Banner artwork by <a href="https://gabrielbjorkstiernstrom.artstation.com" target="_blank">Gabriel Bjorkstiernstrom</a></li>
				</ul>
			</div>
		</footer>',
	// FOOTER links
	'footerlinks' => ['https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js','browser.min.js','breakpoints.min.js','util.js','main.js']
]);

?>