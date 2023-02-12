### config file in /asstes
# Config

## WSL_VERSION
Site version.

## WSL_SITENAME
Site name/title

## WSL_PATH_/
Path and filename to CSV files
- RANKINGS
- GAMES
- TCORPS

## WSL_DELIMITER
CSV delimiter set to comma.

## WSL_MENU
Menu settings
- u : html file
- n : link name
- i : image for index
- a : alt for image
- c : content for index

```
	[ 'u'=>'index.html','n'=>'Home', 'i'=>'', 'a'=>'', 'c'=>'' ],
    ...
	[ 'u'=>'full-rankings.html','n'=>'Full Rankings', 'i'=>'leaderboard-star.svg', 'a'=>'leaderboard', 'c'=>'Rankings of all corporations.' ],
    ...
```

# Autoload config
Autoload function which loads all from **/assets/php** also set main folders.

## WSL_ROOT
Set root folder which points to where autoload is. This is full server path.

## WSL_ASSETS
Set folder for assets (all css, js, php and so).

## WSL_DATA
Set folder for data where holding CSV files.