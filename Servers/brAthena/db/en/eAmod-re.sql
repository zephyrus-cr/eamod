/* item_db */

/*REPLACE INTO `item_db` VALUES(1824,'BF_Knuckle2','Punho de Batalha B',4,20,NULL,0,'30',NULL,1,0,0x00008100,7,2,2,3,80,1,12,'bonus bStr,2; bonus bInt,1; bonus2 bAddRace,RC_DemiHuman,95; bonus2 bVariableCastrate,"MO_EXTREMITYFIST",-25; autobonus "{ bonus2 bVariableCastrate,"MO_EXTREMITYFIST",-100; }",50,6000,BF_WEAPON,"{ specialeffect2 EF_SUFFRAGIUM; }"; bonus bUnbreakableWeapon,0;',NULL,NULL);*/
REPLACE INTO `item_db` VALUES(2161,'Geffenia_Tomb_of_Water','Geffenia Tomb of Water',5,56000,NULL,1000,NULL,30,NULL,0,0x00000200,7,2,32,NULL,100,1,5,'bonus bMdef,2; bonus bInt,1; if(readparam(bInt)>=120){ bonus bEquipmentMatk,10; bonus bMaxHP,800; }',NULL,NULL);
REPLACE INTO `item_db` VALUES(2576,'Adventurer\'s_Backpack','Mochila da Aventura',5,0,NULL,200,NULL,20,NULL,1,0xFFFFFFFF,7,2,4,NULL,0,1,2,'skill "BS_GREED",1; if(getrefine()>6) { if(readparam(bStr)>=90){ bonus bBaseAtk,20; } if(readparam(bInt)>=90){ bonus bEquipmentMatk,30; } if(readparam(bVit)>=90){ bonus2 bSubEle,Ele_Neutral,10; } if(readparam(bAgi)>=90){ bonus bAspdRate,8; } if(readparam(bDex)>=90){ bonus bLongAtkRate,5; } if(readparam(bLuk)>=90){ bonus bCritAtkRate,10; } } if(getrefine()>8) { if(readparam(bStr)>=90){ bonus bBaseAtk,10; } if(readparam(bInt)>=90){ bonus bEquipmentMatk,20; } if(readparam(bVit)>=90){ bonus2 bSubEle,Ele_Neutral,5; } if(readparam(bAgi)>=90){ bonus bAspd,1; } if(readparam(bDex)>=90){ bonus bLongAtkRate,5; } if(readparam(bLuk)>=90){ bonus bCritAtkRate,5; } }',NULL,NULL);
REPLACE INTO `item_db` VALUES(2788,'Bradium_Earing','Brinco de Bradium',5,20,NULL,200,NULL,0,NULL,1,0xFFFFFFFF,2,2,136,NULL,0,0,0,'bonus bInt,1; bonus bDex,1; bonus bEquipmentMatk,5;',NULL,NULL);
REPLACE INTO `item_db` VALUES(2887,'Nabeu\'s_Seal','Nabeu\'s Seal',5,20,NULL,100,NULL,0,NULL,0,0x00001000,7,2,136,NULL,100,0,0,'bonus bBaseAtk,10; bonus bEquipmentMatk,20;',NULL,NULL);
REPLACE INTO `item_db` VALUES(4450,'Banshee_Master_Card','Carta Banshee Master',6,20,NULL,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,16,NULL,NULL,NULL,NULL,'bonus bInt,1; bonus bIntMatk,10;',NULL,NULL);
REPLACE INTO `item_db` VALUES(4451,'Ant_Buyanne_Card','Carta Ant Buyanne',6,20,NULL,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,16,NULL,NULL,NULL,NULL,'bonus bIntMatk,100;',NULL,NULL);
REPLACE INTO `item_db` VALUES(4452,'Centipede_Larva_Card','Carta Larva de Centopéia',6,20,NULL,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,NULL,'bonus bInt,1; bonus bEquipmentMatk,3;',NULL,NULL);
REPLACE INTO `item_db` VALUES(4459,'Lata_Card','Rata Card',6,20,NULL,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,769,NULL,NULL,NULL,NULL,'bonus bEquipmentMatk,10; autobonus "{ bonus bFixedCastrate,-50; }",10,4000,BF_MAGIC,"{ specialeffect2 EF_SUFFRAGIUM; }";',NULL,NULL);
REPLACE INTO `item_db` VALUES(13062,'Ancient_Dagger','Adaga Ritualística',4,20,NULL,600,'107',NULL,0,0,0x028F5EEE,2,2,2,4,120,1,1,'bonus bEquipmentMatk,120; bonus bMaxSP,100; bonus bSPrecovRate,5; bonus2 bAddEff2,Eff_Curse,50;',NULL,NULL);
REPLACE INTO `item_db` VALUES(13068,'Pompano','Pompano',4,0,NULL,0,'160:100',NULL,3,0,0xFE9F7EEF,7,2,2,1,50,0,1,'bonus bUnbreakableWeapon,0; autobonus "{ bonus bBaseAtk,30; }",10,7000,BF_WEAPON,"{ specialeffect2 EF_ENHANCE; }"; autobonus "{ bonus bEquipmentMatk,20; }",10,7000,BF_MAGIC,"{ specialeffect2 EF_SUFFRAGIUM; }"; if(BaseLevel>99) { bonus bBaseAtk,10; bonus bEquipmentMatk,10; }',NULL,NULL);
REPLACE INTO `item_db` VALUES(13310,'P_Huuma_Suriken1','P.Huuma Suriken I',4,0,NULL,0,'170',NULL,1,0,0x02000000,7,2,34,3,60,0,22,'bonus bEquipmentMatk,50;',NULL,NULL);
REPLACE INTO `item_db` VALUES(13313,'Flower_Huuma_Shuriken','Flower Huuma Shuriken',4,100000,NULL,1500,'150',NULL,1,2,0x02000000,8,2,34,3,110,1,22,'bonus bEquipmentMatk,50; bonus bAtkEle,Ele_Fire;',NULL,NULL);
REPLACE INTO `item_db` VALUES(13314,'Wave_Huuma_Shuriken','Wave Huuma Shuriken',4,100000,NULL,1500,'200',NULL,1,0,0x02000000,8,2,34,4,110,1,22,'bonus bEquipmentMatk,50; bonus bAtkEle,Ele_Water;',NULL,NULL);
REPLACE INTO `item_db` VALUES(13315,'Thunderstorm_Huuma_Shuriken','Thunderstorm Huuma Shuriken',4,100000,NULL,1500,'200',NULL,1,0,0x02000000,8,2,34,4,110,1,22,'bonus bEquipmentMatk,50; bonus bAtkEle,Ele_Wind;',NULL,NULL);
REPLACE INTO `item_db` VALUES(13316,'Enhance_Huuma_Shuriken','Enhance Huuma Shuriken',4,20,NULL,1500,'55',NULL,1,1,0x02000000,7,2,34,3,1,1,22,'bonus bUnbreakableWeapon,0; bonus bBaseAtk,10*getrefine(); bonus bEquipmentMatk,5*getrefine(); bonus bLongAtkRate,getrefine(); if(BaseLevel>=70) { bonus bBaseAtk,5*((BaseLevel-60)/10); }',NULL,NULL);
/*REPLACE INTO `item_db` VALUES(18514,'Para_Team_Hat2','Eden Team Hat II',5,0,NULL,0,NULL,5,NULL,1,0xFFFFFFFF,7,2,256,NULL,60,1,682,'bonus bBaseAtk,10; }",50,5000,BF_WEAPON,"{ specialeffect2 EF_ENHANCE; }"; autobonus "{ bonus bEquipmentMatk,10; }",50,5000,BF_MAGIC,"{ specialeffect2 EF_MAGICALATTHIT; }";',NULL,NULL);*/
REPLACE INTO `item_db` VALUES(18570,'Ancient_Gold_Ornament','Ancient Gold Ornament',5,20,NULL,400,NULL,7,NULL,1,0xFFFFFFFE,7,2,256,NULL,100,1,739,'if(BaseLevel >= 150) { bonus bAllStats,2; } if(BaseClass==Job_Swordman||BaseClass==Job_Merchant||BaseClass==Job_Thief){ bonus2 bAddRace,RC_Boss,8; bonus2 bAddRace,RC_NonBoss,8; } if(BaseClass==Job_Mage||BaseClass==Job_Acolyte){ bonus bEquipmentMatk,8; } if(BaseClass==Job_Archer){ bonus bDex,3; bonus bLongAtkRate,10; }',NULL,NULL);

/* mob_db */

REPLACE INTO `mob_db` VALUES(1001,'SCORPION','Escorpião','Escorpião',16,153,1,108,81,1,33,40,16,5,12,15,10,5,19,5,10,12,0,4,23,0x3195,200,1564,864,576,0,0,0,0,0,0,0,990,70,904,5500,757,57,943,210,7041,100,508,200,625,20,0,0,0,0,4068,1);
REPLACE INTO `mob_db` VALUES(1004,'HORNET','Zangão','Zangão',11,90,1,81,60,1,13,16,7,1,12,24,4,5,6,5,10,12,0,4,24,0x1189,150,1292,792,216,0,0,0,0,0,0,0,992,80,939,9000,909,3500,1208,15,511,350,518,150,0,0,0,0,0,0,4019,1);
REPLACE INTO `mob_db` VALUES(1005,'FARMILIAR','Familiar','Familiar',24,427,1,144,162,1,68,77,26,5,15,19,20,5,20,1,10,12,0,2,27,0x3885,150,1276,576,384,0,0,0,0,0,0,0,913,5500,1105,20,2209,15,601,50,514,100,507,700,645,50,0,0,0,0,4020,1);
REPLACE INTO `mob_db` VALUES(1009,'CONDOR','Condor','Condor',12,114,1,81,60,1,14,20,7,5,14,7,6,0,13,5,10,12,1,2,24,0x1089,150,1148,648,480,0,0,0,0,0,0,0,917,9000,1702,150,715,80,1750,5500,517,400,916,2000,582,600,0,0,0,0,4015,1);
REPLACE INTO `mob_db` VALUES(1051,'THIEF_BUG','Besouro-Ladrão','Besouro-Ladrão',21,354,1,126,143,1,56,61,24,3,19,7,10,0,12,5,10,12,0,4,60,0x118B,150,1288,288,768,0,0,0,0,0,0,0,955,2500,2304,80,507,350,909,2000,2303,120,1002,250,0,0,0,0,0,0,4016,1);
REPLACE INTO `mob_db` VALUES(1078,'RED_PLANT','Planta Vermelha','Planta Vermelha',1,10,0,0,0,1,1,2,100,99,0,0,0,0,0,0,7,12,0,3,22,0x40,2000,1,1,1,0,0,0,0,0,0,0,507,5500,712,1000,711,1000,905,500,7933,300,914,500,708,50,0,0,0,0,2269,2);
REPLACE INTO `mob_db` VALUES(1080,'GREEN_PLANT','Planta Verde','Planta Verde',1,10,0,0,0,1,1,2,100,99,0,0,0,0,0,0,7,12,0,3,22,0x40,2000,1,1,1,0,0,0,0,0,0,0,511,7000,7934,300,621,20,905,3000,906,1500,704,50,521,50,0,0,0,0,2270,2);
REPLACE INTO `mob_db` VALUES(1081,'YELLOW_PLANT','Planta Amarela','Planta Amarela',1,10,0,0,0,1,1,2,100,99,0,0,0,0,0,0,7,12,0,3,22,0x40,2000,1,1,1,0,0,0,0,0,0,0,508,5500,712,1000,711,1000,905,500,7937,300,707,5,914,500,0,0,0,0,2269,2);
REPLACE INTO `mob_db` VALUES(1082,'WHITE_PLANT','Planta Branca','Planta Branca',1,10,0,0,0,1,1,2,100,99,0,0,0,0,0,0,7,12,0,3,22,0x40,2000,1,1,1,0,0,0,0,0,0,0,509,5500,712,1000,631,20,905,3000,7935,300,521,50,703,50,0,0,0,0,2269,2);
REPLACE INTO `mob_db` VALUES(1084,'BLACK_MUSHROOM','Cogumelo Negro','Cogumelo Negro',1,15,0,0,0,1,1,2,100,99,0,0,0,0,0,0,7,12,0,3,22,0x40,2000,1,1,1,0,0,0,0,0,0,0,970,50,971,50,630,20,949,2000,991,800,921,5500,921,5500,0,0,0,0,7033,5500);
REPLACE INTO `mob_db` VALUES(1085,'RED_MUSHROOM','Cogumelo Vermelho','Cogumelo Vermelho',1,15,0,0,0,1,1,2,100,99,0,0,0,0,0,0,7,12,0,3,22,0x40,2000,1,1,1,0,0,0,0,0,0,0,970,50,972,50,630,20,949,2000,990,1000,921,5500,921,5500,0,0,0,0,7033,5500);
REPLACE INTO `mob_db` VALUES(1095,'ANDRE','Andre','Andre',33,724,1,216,243,1,51,72,55,16,11,20,40,10,24,10,10,12,0,4,22,0x118B,300,1288,288,384,0,0,0,0,0,0,0,955,9000,910,1000,938,500,993,50,1001,4,1002,350,757,28,0,0,0,0,4043,1);
REPLACE INTO `mob_db` VALUES(1105,'DENIRO','Deniro','Deniro',31,671,1,207,233,1,45,61,52,16,15,16,30,10,23,15,10,12,0,4,22,0x118B,150,1288,288,576,0,0,0,0,0,0,0,955,9000,910,3000,938,1200,990,50,1001,8,1002,450,757,34,0,0,0,0,4043,1);
REPLACE INTO `mob_db` VALUES(1107,'DESERT_WOLF_B','Filhote de Lobo do Deserto','Filhote de Lobo do Deserto',14,140,1,90,68,1,33,41,13,0,10,12,8,5,17,7,10,12,0,2,23,0x1089,300,1600,900,240,0,0,0,0,0,0,0,1010,85,919,5500,2306,80,6252,200,2301,200,13011,5,582,1000,0,0,0,0,4023,1);
REPLACE INTO `mob_db` VALUES(1160,'PIERE','Piere','Piere',32,696,1,216,243,1,47,67,57,16,19,19,36,8,27,15,10,12,0,4,22,0x118B,200,1288,288,576,0,0,0,0,0,0,0,955,9000,910,1100,938,600,992,30,1001,5,1002,400,757,31,0,0,0,0,4043,1);
REPLACE INTO `mob_db` VALUES(1237,'META_ANDRE','Andre','Andre',17,688,1,98,64,1,60,71,16,0,1,17,24,20,26,20,10,12,0,4,22,0x118B,300,1288,288,576,0,0,0,0,0,0,0,955,6000,910,3000,938,1000,935,3000,1001,6,1002,350,757,28,0,0,0,0,4043,1);
REPLACE INTO `mob_db` VALUES(1238,'META_PIERE','Piere','Piere',18,733,1,110,70,1,64,75,24,0,1,18,26,20,27,15,10,12,0,4,22,0x118B,200,1288,288,576,0,0,0,0,0,0,0,955,5700,910,1100,938,600,992,15,1001,5,1002,400,757,31,0,0,0,0,4043,1);
REPLACE INTO `mob_db` VALUES(1239,'META_DENIRO','Deniro','Deniro',19,760,1,122,77,1,68,79,24,0,1,19,30,20,43,10,10,12,0,4,22,0x118B,150,1288,288,576,0,0,0,0,0,0,0,955,6000,910,3000,938,1200,990,45,1001,8,1002,450,757,34,0,0,0,0,4043,1);
REPLACE INTO `mob_db` VALUES(1242,'MARIN','Marin','Marin',37,987,1,282,317,1,69,83,32,8,24,5,10,5,30,15,10,12,1,3,41,0x81,400,1872,672,480,0,0,0,0,0,0,0,910,3200,938,1500,700,100,720,40,510,75,529,350,5035,1,0,0,0,0,4196,1);
REPLACE INTO `mob_db` VALUES(1419,'G_FARMILIAR','Familiar','Familiar',24,427,1,0,0,1,68,77,26,5,15,19,20,5,20,1,10,12,0,2,27,0x3885,150,1276,576,384,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
REPLACE INTO `mob_db` VALUES(1559,'G_SCORPION','Escorpião','Escorpião',16,153,1,0,0,1,39,46,16,5,14,15,10,5,33,5,10,12,0,4,23,0x3195,200,1564,864,576,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
REPLACE INTO `mob_db` VALUES(1595,'G_MARIN','Marin','Marin',37,987,1,0,0,1,69,83,32,8,24,5,10,5,30,15,10,12,1,3,41,0x81,400,1872,672,480,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
REPLACE INTO `mob_db` VALUES(1687,'GREEN_IGUANA','Grove','Grove',55,2090,1,486,548,9,139,174,96,18,58,42,22,5,45,17,10,12,1,2,42,0x83,200,1152,1152,480,0,0,0,0,0,0,0,521,1500,903,1000,520,1000,511,1000,528,2000,606,10,6264,500,0,0,0,0,4377,1);
REPLACE INTO `mob_db` VALUES(1857,'E_MARIN','Marin','Marin',15,742,0,59,40,1,39,43,0,10,1,10,10,5,35,15,10,12,1,3,41,0x81,400,1872,672,480,0,0,0,0,0,0,0,910,3200,938,1500,700,100,720,40,7745,75,529,350,5035,1,0,0,0,0,4196,1);
REPLACE INTO `mob_db` VALUES(1901,'E_CONDOR','Condor','Condor',10,15,0,90,90,1,13,20,10,15,1,1,1,50,100,100,10,12,0,2,26,0x1089,150,1148,648,480,0,0,0,0,0,0,0,7973,1000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
REPLACE INTO `mob_db` VALUES(2127,'M_HORNET','Hornet','Hornet',110,9000,1,0,0,1,350,450,0,0,40,70,40,40,90,40,10,12,0,4,24,0x1189,150,1292,792,216,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
REPLACE INTO `mob_db` VALUES(2128,'M_HORNET2','Hornet','Hornet',120,10000,1,0,0,1,400,500,0,0,40,70,40,40,100,40,10,12,0,4,24,0x1189,150,1292,792,216,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

/* mob_skill_db */

DELETE FROM `mob_skill_db` WHERE `MOB_ID`=1242 AND `INFO`='Marin@NPC_EMOTION';

/* job_db2 */

REPLACE INTO `job_db2` VALUES (4055,4,4,5,0,0,5,4,2,0,0,0,0,5,0,3,0,0,3,5,2,0,0,4,3,3,0,0,5,2,0,6,0,0,1,4,4,0,0,5,2,4,0,0,4,4,0,2,0,0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
REPLACE INTO `job_db2` VALUES (4061,4,4,5,0,0,5,4,2,0,0,0,0,5,0,3,0,0,3,5,2,0,0,4,3,3,0,0,5,2,0,6,0,0,1,4,4,0,0,5,2,4,0,0,4,4,0,2,0,0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
REPLACE INTO `job_db2` VALUES (4097,4,4,5,0,0,5,4,2,0,0,0,0,5,0,3,0,0,3,5,2,0,0,4,3,3,0,0,5,2,0,6,0,0,1,4,4,0,0,5,2,4,0,0,4,4,0,2,0,0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

/* skill_cast_db */

REPLACE INTO `skill_cast_db` VALUES(2205,'2500','1000','0','30000','0','0','500');
REPLACE INTO `skill_cast_db` VALUES(2216,'2000:3000:4000:5000:6000','1000','0','150','0','10000','2000');
