- Copy the /Trunk/db/emblems/*.* files into your db folder in your server.
- Add the next 3 items into your item_db

8965,Blue_Skull,Blue Skull,3,,10,0,,,,,,,,,,,,,{},{},{}
8966,Red_Skull,Red Skull,3,,10,0,,,,,,,,,,,,,{},{},{}
8967,Green_Skull,Green Skull,3,,10,0,,,,,,,,,,,,,{},{},{}

- Add the next lines inside mob_db2.txt

// Tierra Bossnia
2100,RSX_0806,RSX 0806,RSX-0806,86,500000,0,0,0,1,2740,5620,39,41,85,51,30,25,93,84,10,12,2,0,60,0x37B5,300,128,1104,240,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
2101,GLOOMUNDERNIGHT,Gloom Under Night,Gloom Under Night,89,500000,0,0,0,3,5880,9516,10,20,100,115,98,78,111,50,10,12,2,0,68,0x37B5,300,1344,2880,576,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
2102,RANDGRIS,Valkyrie Randgris,Valkyrie Randgris,99,500000,0,0,0,3,5560,9980,25,42,100,120,30,120,220,210,10,12,2,8,86,0x37B5,300,576,576,480,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
2103,GARM,Garm,Garm,73,500000,0,0,0,3,1700,1900,40,45,85,126,82,65,95,60,10,12,2,2,81,0x37B5,400,608,408,336,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
2104,MOROCC,Satan Morroc,Satan Morroc,99,500000,0,0,0,2,32000,32001,29,65,140,160,30,250,180,50,10,12,2,6,87,0x37B5,300,76,540,432,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
// Conquest Battleground
2105,S_EMPEL_1,Guardian Stone,Guardian Stone,90,500,0,0,0,0,1,1,100,99,1,1,1,1,1,1,0,0,2,0,20,0x160,300,1288,288,384,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
2106,S_EMPEL_2,Guardian Stone,Guardian Stone,90,500,0,0,0,0,1,1,100,99,1,1,1,1,1,1,0,0,2,0,20,0x160,300,1288,288,384,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
2107,EMPELIUM,Emperium,Emperium,90,250,0,0,0,0,1,1,100,99,1,1,1,1,1,1,0,0,2,0,20,0x160,300,1288,288,384,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0

- Add the next lines to mob_avail.txt

2100,1623,0
2101,1768,0
2102,1751,0
2103,1252,0
2104,1916,0
2105,1907,0
2106,1908,0
2107,1288,0

- And add the next lines to quest_db.txt

8500,600,0,0,0,0,0,0,"Tierra Gorge Battle"
8501,600,0,0,0,0,0,0,"Tierra Eye of Storm Battle"
8502,600,0,0,0,0,0,0,"Tierra Bossnia Battle"
8503,600,0,0,0,0,0,0,"Flavius Battle"
8504,600,0,0,0,0,0,0,"Flavius Capture the Flag Battle"
8505,600,0,0,0,0,0,0,"Flavius Team DeathMatch Battle"
8506,60,0,0,0,0,0,0,"Battleground Deserter"
8507,600,0,0,0,0,0,0,"Flavius Stone Capture"
8508,600,0,0,0,0,0,0,"Tierra Triple Infierno"
8509,1800,0,0,0,0,0,0,"Castle Conquest"
8510,1800,0,0,0,0,0,0,"Castle Rush"

- The required maps for battleground are just duplicated maps of existing ones, add the next lines to map_index.txt
- Note: You will need to rebuild your mapcache, and this when your grf is ready first.

bat_a03
bat_a04
bat_a05
bat_b03
bat_b04
bat_b05
schg_cas06
schg_cas07
schg_cas08
arug_cas06
arug_cas07
arug_cas08
rush_cas01
rush_cas02
rush_cas03
rush_cas04
bat_c03
bat_c04
bat_c05
bat_c06
bat_c07
bat_c08
region_8
