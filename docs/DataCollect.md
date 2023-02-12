### data/*.csv
# DATA
Collect data from **/data** folder from CSV files.

# Get data
Usage
```new TableMaker($file, $overide)```
- $file -> path and filename to CSV, with delimiter set in WSL_DELIMITER
- $overide -> replace name from header, exp. ```["delta"=>"Δ"]```

## RANKINGS
CSV file -> WSL_PATH_RANKINGS
```
rank,corporation,rating,delta
  1,Legion            ,1661,17
  ...
```
Prepare data from **/site/rankings.php**

## GAMES
CSV file -> WSL_PATH_GAMES
```
team1,score1,score2,team2,players,date
Wintercomes,67,45,Stammtisch,5,2023/01/21
  ...
```
Prepare data from **/site/games.php**

## TOTAL CORPS
CSV file -> WSL_PATH_TCORPS
```
Version,Date,Corporations
V7.0,17-Sep-2021,319
  ...
```
Prepare data from **new StatsMaker()**
