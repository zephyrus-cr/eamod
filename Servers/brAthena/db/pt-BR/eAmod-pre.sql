/* item_db */

REPLACE INTO `item_db` VALUES(1643,'Dead_Tree_Cane','Dead Tree Cane',4,20,NULL,100,100,NULL,1,0,0x00818314,7,2,2,4,70,1,10,'bonus bIntMatk,15; bonus bInt,4; if(getrefine()>5) { bonus bInt,getrefine()-5; bonus bMaxHP,-200; bonus bMaxSP,-100; }',NULL,NULL);
REPLACE INTO `item_db` VALUES(1824,'BF_Knuckle2','Brave Battle Fist',4,20,NULL,0,30,NULL,1,0,0x00008100,7,2,2,3,80,1,12,'bonus bStr,2; bonus bInt,1; bonus2 bAddRace,RC_DemiHuman,95; bonus2 bCastrate,"MO_EXTREMITYFIST",-25; autobonus "{ bonus2 bCastrate,'MO_EXTREMITYFIST',-100; }",50,6000,BF_WEAPON,"{ specialeffect2 EF_SUFFRAGIUM; }"; bonus bUnbreakableWeapon,0;',NULL,NULL);
REPLACE INTO `item_db` VALUES(2006,'G_Staff_Of_Light','Staff Of Light',4,20,NULL,1900,80,NULL,1,0,0x00810204,7,2,34,4,60,1,23,'/* bonus bIntMatk,150; */ bonus bAtkEle,Ele_Holy; bonus bInt,6;',NULL,NULL);
REPLACE INTO `item_db` VALUES(4450,'Banshee_Master_Card','Banshee Master Card','6',20,NULL,'10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,16,NULL,NULL,NULL,NULL,'bonus bInt,1; /*bonus bMatk,10;*/',NULL,NULL);
REPLACE INTO `item_db` VALUES(4451,'Entweihen_Card','Carta Ant Buyanne','6',20,NULL,'10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,16,NULL,NULL,NULL,NULL,'/* bonus bIntMatk,100; */',NULL,NULL);
REPLACE INTO `item_db` VALUES(4452,'Centipede_Larva_Card','Centipede Larva Card','6',20,NULL,'10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,NULL,'bonus bInt,1; /* bonus bIntMatk,3; */',NULL,NULL);

/* job_db2 */

REPLACE INTO `job_db2` VALUES (4055,4,4,5,0,0,5,4,2,0,0,0,0,5,0,3,0,0,3,5,2,0,0,4,3,3,0,0,5,2,0,6,0,0,1,4,4,0,0,5,2,4,0,0,4,4,0,2,0,0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
REPLACE INTO `job_db2` VALUES (4061,4,4,5,0,0,5,4,2,0,0,0,0,5,0,3,0,0,3,5,2,0,0,4,3,3,0,0,5,2,0,6,0,0,1,4,4,0,0,5,2,4,0,0,4,4,0,2,0,0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
REPLACE INTO `job_db2` VALUES (4097,4,4,5,0,0,5,4,2,0,0,0,0,5,0,3,0,0,3,5,2,0,0,4,3,3,0,0,5,2,0,6,0,0,1,4,4,0,0,5,2,4,0,0,4,4,0,2,0,0,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);