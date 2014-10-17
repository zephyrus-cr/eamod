<?php
/*
Ceres Control Panel

This is a control pannel program for Athena and Freya
Copyright (C) 2005 by Beowulf and Nightroad

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

To contact any of the authors about special permissions send
an e-mail to cerescp@gmail.com
*/

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

DEFINE('CARDMVP1',  "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4121' OR `card0` = '4121') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4121' OR `card0` = '4121') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4121' OR `card0` = '4121') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4121' OR `card0` = '4121') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4121' OR `card0` = '4121') AS `CLANALMACEN`");
DEFINE('CARDMVP2',  "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4123' OR `card0` = '4123') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4123' OR `card0` = '4123') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4123' OR `card0` = '4123') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4123' OR `card0` = '4123') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4123' OR `card0` = '4123') AS `CLANALMACEN`");
DEFINE('CARDMVP3',  "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4128' OR `card0` = '4128') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4128' OR `card0` = '4128') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4128' OR `card0` = '4128') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4128' OR `card0` = '4128') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4128' OR `card0` = '4128') AS `CLANALMACEN`");
DEFINE('CARDMVP4',  "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4131' OR `card0` = '4131') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4131' OR `card0` = '4131') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4131' OR `card0` = '4131') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4131' OR `card0` = '4131') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4131' OR `card0` = '4131') AS `CLANALMACEN`");
DEFINE('CARDMVP5',  "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4132' OR `card0` = '4132') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4132' OR `card0` = '4132') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4132' OR `card0` = '4132') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4132' OR `card0` = '4132') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4132' OR `card0` = '4132') AS `CLANALMACEN`");
DEFINE('CARDMVP6',  "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4134' OR `card0` = '4134') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4134' OR `card0` = '4134') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4134' OR `card0` = '4134') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4134' OR `card0` = '4134') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4134' OR `card0` = '4134') AS `CLANALMACEN`");
DEFINE('CARDMVP7',  "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4135' OR `card0` = '4135') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4135' OR `card0` = '4135') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4135' OR `card0` = '4135') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4135' OR `card0` = '4135') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4135' OR `card0` = '4135') AS `CLANALMACEN`");
DEFINE('CARDMVP8',  "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4137' OR `card0` = '4137') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4137' OR `card0` = '4137') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4137' OR `card0` = '4137') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4137' OR `card0` = '4137') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4137' OR `card0` = '4137') AS `CLANALMACEN`");
DEFINE('CARDMVP9',  "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4142' OR `card0` = '4142') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4142' OR `card0` = '4142') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4142' OR `card0` = '4142') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4142' OR `card0` = '4142') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4142' OR `card0` = '4142') AS `CLANALMACEN`");
DEFINE('CARDMVP10', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4143' OR `card0` = '4143') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4143' OR `card0` = '4143') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4143' OR `card0` = '4143') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4143' OR `card0` = '4143') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4143' OR `card0` = '4143') AS `CLANALMACEN`");
DEFINE('CARDMVP11', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4144' OR `card0` = '4144') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4144' OR `card0` = '4144') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4144' OR `card0` = '4144') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4144' OR `card0` = '4144') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4144' OR `card0` = '4144') AS `CLANALMACEN`");
DEFINE('CARDMVP12', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4146' OR `card0` = '4146') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4146' OR `card0` = '4146') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4146' OR `card0` = '4146') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4146' OR `card0` = '4146') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4146' OR `card0` = '4146') AS `CLANALMACEN`");
DEFINE('CARDMVP13', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4147' OR `card0` = '4147') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4147' OR `card0` = '4147') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4147' OR `card0` = '4147') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4147' OR `card0` = '4147') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4147' OR `card0` = '4147') AS `CLANALMACEN`");
DEFINE('CARDMVP14', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4148' OR `card0` = '4148') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4148' OR `card0` = '4148') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4148' OR `card0` = '4148') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4148' OR `card0` = '4148') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4148' OR `card0` = '4148') AS `CLANALMACEN`");
DEFINE('CARDMVP15', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4168' OR `card0` = '4168') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4168' OR `card0` = '4168') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4168' OR `card0` = '4168') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4168' OR `card0` = '4168') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4168' OR `card0` = '4168') AS `CLANALMACEN`");
DEFINE('CARDMVP16', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4236' OR `card0` = '4236') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4236' OR `card0` = '4236') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4236' OR `card0` = '4236') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4236' OR `card0` = '4236') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4236' OR `card0` = '4236') AS `CLANALMACEN`");
DEFINE('CARDMVP17', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4263' OR `card0` = '4263') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4263' OR `card0` = '4263') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4263' OR `card0` = '4263') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4263' OR `card0` = '4263') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4263' OR `card0` = '4263') AS `CLANALMACEN`");
DEFINE('CARDMVP18', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4276' OR `card0` = '4276') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4276' OR `card0` = '4276') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4276' OR `card0` = '4276') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4276' OR `card0` = '4276') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4276' OR `card0` = '4276') AS `CLANALMACEN`");
DEFINE('CARDMVP19', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4302' OR `card0` = '4302') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4302' OR `card0` = '4302') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4302' OR `card0` = '4302') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4302' OR `card0` = '4302') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4302' OR `card0` = '4302') AS `CLANALMACEN`");
DEFINE('CARDMVP20', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4305' OR `card0` = '4305') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4305' OR `card0` = '4305') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4305' OR `card0` = '4305') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4305' OR `card0` = '4305') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4305' OR `card0` = '4305') AS `CLANALMACEN`");
DEFINE('CARDMVP21', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4318' OR `card0` = '4318') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4318' OR `card0` = '4318') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4318' OR `card0` = '4318') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4318' OR `card0` = '4318') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4318' OR `card0` = '4318') AS `CLANALMACEN`");
DEFINE('CARDMVP22', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4324' OR `card0` = '4324') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4324' OR `card0` = '4324') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4324' OR `card0` = '4324') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4324' OR `card0` = '4324') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4324' OR `card0` = '4324') AS `CLANALMACEN`");
DEFINE('CARDMVP23', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4330' OR `card0` = '4330') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4330' OR `card0` = '4330') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4330' OR `card0` = '4330') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4330' OR `card0` = '4330') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4330' OR `card0` = '4330') AS `CLANALMACEN`");
DEFINE('CARDMVP24', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4342' OR `card0` = '4342') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4342' OR `card0` = '4342') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4342' OR `card0` = '4342') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4342' OR `card0` = '4342') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4342' OR `card0` = '4342') AS `CLANALMACEN`");
DEFINE('CARDMVP25', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4352' OR `card0` = '4352') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4352' OR `card0` = '4352') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4352' OR `card0` = '4352') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4352' OR `card0` = '4352') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4352' OR `card0` = '4352') AS `CLANALMACEN`");
DEFINE('CARDMVP26', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4357' OR `card0` = '4357') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4357' OR `card0` = '4357') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4357' OR `card0` = '4357') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4357' OR `card0` = '4357') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4357' OR `card0` = '4357') AS `CLANALMACEN`");
DEFINE('CARDMVP27', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4359' OR `card0` = '4359') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4359' OR `card0` = '4359') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4359' OR `card0` = '4359') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4359' OR `card0` = '4359') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4359' OR `card0` = '4359') AS `CLANALMACEN`");
DEFINE('CARDMVP28', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4361' OR `card0` = '4361') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4361' OR `card0` = '4361') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4361' OR `card0` = '4361') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4361' OR `card0` = '4361') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4361' OR `card0` = '4361') AS `CLANALMACEN`");
DEFINE('CARDMVP29', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4363' OR `card0` = '4363') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4363' OR `card0` = '4363') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4363' OR `card0` = '4363') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4363' OR `card0` = '4363') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4363' OR `card0` = '4363') AS `CLANALMACEN`");
DEFINE('CARDMVP30', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4365' OR `card0` = '4365') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4365' OR `card0` = '4365') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4365' OR `card0` = '4365') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4365' OR `card0` = '4365') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4365' OR `card0` = '4365') AS `CLANALMACEN`");
DEFINE('CARDMVP31', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4367' OR `card0` = '4367') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4367' OR `card0` = '4367') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4367' OR `card0` = '4367') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4367' OR `card0` = '4367') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4367' OR `card0` = '4367') AS `CLANALMACEN`");
DEFINE('CARDMVP32', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4372' OR `card0` = '4372') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4372' OR `card0` = '4372') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4372' OR `card0` = '4372') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4372' OR `card0` = '4372') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4372' OR `card0` = '4372') AS `CLANALMACEN`");
DEFINE('CARDMVP33', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4374' OR `card0` = '4374') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4374' OR `card0` = '4374') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4374' OR `card0` = '4374') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4374' OR `card0` = '4374') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4374' OR `card0` = '4374') AS `CLANALMACEN`");
DEFINE('CARDMVP34', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4376' OR `card0` = '4376') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4376' OR `card0` = '4376') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4376' OR `card0` = '4376') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4376' OR `card0` = '4376') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4376' OR `card0` = '4276') AS `CLANALMACEN`");
DEFINE('CARDMVP35', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4386' OR `card0` = '4386') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4386' OR `card0` = '4386') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4386' OR `card0` = '4386') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4386' OR `card0` = '4386') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4386' OR `card0` = '4386') AS `CLANALMACEN`");
DEFINE('CARDMVP36', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4399' OR `card0` = '4399') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4399' OR `card0` = '4399') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4399' OR `card0` = '4399') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4399' OR `card0` = '4399') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4399' OR `card0` = '4399') AS `CLANALMACEN`");
DEFINE('CARDMVP37', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4403' OR `card0` = '4403') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4403' OR `card0` = '4403') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4403' OR `card0` = '4403') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4403' OR `card0` = '4403') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4403' OR `card0` = '4403') AS `CLANALMACEN`");
DEFINE('CARDMVP38', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4407' OR `card0` = '4407') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4407' OR `card0` = '4407') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4407' OR `card0` = '4407') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4407' OR `card0` = '4407') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4407' OR `card0` = '4407') AS `CLANALMACEN`");
DEFINE('CARDMVP39', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4419' OR `card0` = '4419') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4419' OR `card0` = '4419') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4419' OR `card0` = '4419') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4419' OR `card0` = '4419') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4419' OR `card0` = '4419') AS `CLANALMACEN`");
DEFINE('CARDMVP40', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4425' OR `card0` = '4425') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4425' OR `card0` = '4425') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4425' OR `card0` = '4425') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4425' OR `card0` = '4425') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4425' OR `card0` = '4425') AS `CLANALMACEN`");
DEFINE('CARDMVP41', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4430' OR `card0` = '4430') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4430' OR `card0` = '4430') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4430' OR `card0` = '4430') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4430' OR `card0` = '4430') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4430' OR `card0` = '4430') AS `CLANALMACEN`");
DEFINE('CARDMVP42', "SELECT (SELECT IFNULL(SUM(`amount`),0) FROM `inventory` WHERE `nameid` = '4441' OR `card0` = '4441') AS `INVENTARIO`, (SELECT IFNULL(SUM(`amount`),0) FROM `cart_inventory` WHERE `nameid` = '4441' OR `card0` = '4441') AS `CARRO`, (SELECT IFNULL(SUM(`amount`),0) FROM `storage` WHERE `nameid` = '4441' OR `card0` = '4441') AS `ALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `rentstorage` WHERE `nameid` = '4441' OR `card0` = '4441') AS `RENTAALMACEN`, (SELECT IFNULL(SUM(`amount`),0) FROM `guild_storage` WHERE `nameid` = '4441' OR `card0` = '4441') AS `CLANALMACEN`");

$querymvp1 = sprintf(CARDMVP1);
$resultmvp1 = execute_query($querymvp1, "topmvpcard.php");
$muestra1 = $resultmvp1->fetch_row();
$sumamvp1 = $muestra1[0]+$muestra1[1]+$muestra1[2]+$muestra1[3]+$muestra1[4];
$querymvp2 = sprintf(CARDMVP2);
$resultmvp2 = execute_query($querymvp2, "topmvpcard.php");
$muestra2 = $resultmvp2->fetch_row();
$sumamvp2 = $muestra2[0]+$muestra2[1]+$muestra2[2]+$muestra2[3]+$muestra2[4];
$querymvp3 = sprintf(CARDMVP3);
$resultmvp3 = execute_query($querymvp3, "topmvpcard.php");
$muestra3 = $resultmvp3->fetch_row();
$sumamvp3 = $muestra3[0]+$muestra3[1]+$muestra3[2]+$muestra3[3]+$muestra3[4];
$querymvp4 = sprintf(CARDMVP4);
$resultmvp4 = execute_query($querymvp4, "topmvpcard.php");
$muestra4 = $resultmvp4->fetch_row();
$sumamvp4 = $muestra4[0]+$muestra4[1]+$muestra4[2]+$muestra4[3]+$muestra4[4];
$querymvp5 = sprintf(CARDMVP5);
$resultmvp5 = execute_query($querymvp5, "topmvpcard.php");
$muestra5 = $resultmvp5->fetch_row();
$sumamvp5 = $muestra5[0]+$muestra5[1]+$muestra5[2]+$muestra5[3]+$muestra5[4];
$querymvp6 = sprintf(CARDMVP6);
$resultmvp6 = execute_query($querymvp6, "topmvpcard.php");
$muestra6 = $resultmvp6->fetch_row();
$sumamvp6 = $muestra6[0]+$muestra6[1]+$muestra6[2]+$muestra6[3]+$muestra6[4];
$querymvp7 = sprintf(CARDMVP7);
$resultmvp7 = execute_query($querymvp7, "topmvpcard.php");
$muestra7 = $resultmvp7->fetch_row();
$sumamvp7 = $muestra7[0]+$muestra7[1]+$muestra7[2]+$muestra7[3]+$muestra7[4];
$querymvp8 = sprintf(CARDMVP8);
$resultmvp8 = execute_query($querymvp8, "topmvpcard.php");
$muestra8 = $resultmvp8->fetch_row();
$sumamvp8 = $muestra8[0]+$muestra8[1]+$muestra8[2]+$muestra8[3]+$muestra8[4];
$querymvp9 = sprintf(CARDMVP9);
$resultmvp9 = execute_query($querymvp9, "topmvpcard.php");
$muestra9 = $resultmvp9->fetch_row();
$sumamvp9 = $muestra9[0]+$muestra9[1]+$muestra9[2]+$muestra9[3]+$muestra9[4];
$querymvp10 = sprintf(CARDMVP10);
$resultmvp10 = execute_query($querymvp10, "topmvpcard.php");
$muestra10 = $resultmvp10->fetch_row();
$sumamvp10 = $muestra10[0]+$muestra10[1]+$muestra10[2]+$muestra10[3]+$muestra10[4];
$querymvp11 = sprintf(CARDMVP11);
$resultmvp11 = execute_query($querymvp11, "topmvpcard.php");
$muestra11 = $resultmvp11->fetch_row();
$sumamvp11 = $muestra11[0]+$muestra11[1]+$muestra11[2]+$muestra11[3]+$muestra11[4];
$querymvp12 = sprintf(CARDMVP12);
$resultmvp12 = execute_query($querymvp12, "topmvpcard.php");
$muestra12 = $resultmvp12->fetch_row();
$sumamvp12 = $muestra12[0]+$muestra12[1]+$muestra12[2]+$muestra12[3]+$muestra12[4];
$querymvp13 = sprintf(CARDMVP13);
$resultmvp13 = execute_query($querymvp13, "topmvpcard.php");
$muestra13 = $resultmvp13->fetch_row();
$sumamvp13 = $muestra13[0]+$muestra13[1]+$muestra13[2]+$muestra13[3]+$muestra13[4];
$querymvp14 = sprintf(CARDMVP14);
$resultmvp14 = execute_query($querymvp14, "topmvpcard.php");
$muestra14 = $resultmvp14->fetch_row();
$sumamvp14 = $muestra14[0]+$muestra14[1]+$muestra14[2]+$muestra14[3]+$muestra14[4];
$querymvp15 = sprintf(CARDMVP15);
$resultmvp15 = execute_query($querymvp15, "topmvpcard.php");
$muestra15 = $resultmvp15->fetch_row();
$sumamvp15 = $muestra15[0]+$muestra15[1]+$muestra15[2]+$muestra15[3]+$muestra15[4];
$querymvp16 = sprintf(CARDMVP16);
$resultmvp16 = execute_query($querymvp16, "topmvpcard.php");
$muestra16 = $resultmvp16->fetch_row();
$sumamvp16 = $muestra16[0]+$muestra16[1]+$muestra16[2]+$muestra16[3]+$muestra16[4];
$querymvp17 = sprintf(CARDMVP17);
$resultmvp17 = execute_query($querymvp17, "topmvpcard.php");
$muestra17 = $resultmvp17->fetch_row();
$sumamvp17 = $muestra17[0]+$muestra17[1]+$muestra17[2]+$muestra17[3]+$muestra17[4];
$querymvp18 = sprintf(CARDMVP18);
$resultmvp18 = execute_query($querymvp18, "topmvpcard.php");
$muestra18 = $resultmvp18->fetch_row();
$sumamvp18 = $muestra18[0]+$muestra18[1]+$muestra18[2]+$muestra18[3]+$muestra18[4];
$querymvp19 = sprintf(CARDMVP19);
$resultmvp19 = execute_query($querymvp19, "topmvpcard.php");
$muestra19 = $resultmvp19->fetch_row();
$sumamvp19 = $muestra19[0]+$muestra19[1]+$muestra19[2]+$muestra19[3]+$muestra19[4];
$querymvp20 = sprintf(CARDMVP20);
$resultmvp20 = execute_query($querymvp20, "topmvpcard.php");
$muestra20 = $resultmvp20->fetch_row();
$sumamvp20 = $muestra20[0]+$muestra20[1]+$muestra20[2]+$muestra20[3]+$muestra20[4];
$querymvp21 = sprintf(CARDMVP21);
$resultmvp21 = execute_query($querymvp21, "topmvpcard.php");
$muestra21 = $resultmvp21->fetch_row();
$sumamvp21 = $muestra21[0]+$muestra21[1]+$muestra21[2]+$muestra21[3]+$muestra21[4];
$querymvp22 = sprintf(CARDMVP22);
$resultmvp22 = execute_query($querymvp22, "topmvpcard.php");
$muestra22 = $resultmvp22->fetch_row();
$sumamvp22 = $muestra22[0]+$muestra22[1]+$muestra22[2]+$muestra22[3]+$muestra22[4];
$querymvp23 = sprintf(CARDMVP23);
$resultmvp23 = execute_query($querymvp23, "topmvpcard.php");
$muestra23 = $resultmvp23->fetch_row();
$sumamvp23 = $muestra23[0]+$muestra23[1]+$muestra23[2]+$muestra23[3]+$muestra23[4];
$querymvp24 = sprintf(CARDMVP24);
$resultmvp24 = execute_query($querymvp24, "topmvpcard.php");
$muestra24 = $resultmvp24->fetch_row();
$sumamvp24 = $muestra24[0]+$muestra24[1]+$muestra24[2]+$muestra24[3]+$muestra24[4];
$querymvp25 = sprintf(CARDMVP25);
$resultmvp25 = execute_query($querymvp25, "topmvpcard.php");
$muestra25 = $resultmvp25->fetch_row();
$sumamvp25 = $muestra25[0]+$muestra25[1]+$muestra25[2]+$muestra25[3]+$muestra25[4];
$querymvp26 = sprintf(CARDMVP26);
$resultmvp26 = execute_query($querymvp26, "topmvpcard.php");
$muestra26 = $resultmvp26->fetch_row();
$sumamvp26 = $muestra26[0]+$muestra26[1]+$muestra26[2]+$muestra26[3]+$muestra26[4];
$querymvp27 = sprintf(CARDMVP27);
$resultmvp27 = execute_query($querymvp27, "topmvpcard.php");
$muestra27 = $resultmvp27->fetch_row();
$sumamvp27 = $muestra27[0]+$muestra27[1]+$muestra27[2]+$muestra27[3]+$muestra27[4];
$querymvp28 = sprintf(CARDMVP28);
$resultmvp28 = execute_query($querymvp28, "topmvpcard.php");
$muestra28 = $resultmvp28->fetch_row();
$sumamvp28 = $muestra28[0]+$muestra28[1]+$muestra28[2]+$muestra28[3]+$muestra28[4];
$querymvp29 = sprintf(CARDMVP29);
$resultmvp29 = execute_query($querymvp29, "topmvpcard.php");
$muestra29 = $resultmvp29->fetch_row();
$sumamvp29 = $muestra29[0]+$muestra29[1]+$muestra29[2]+$muestra29[3]+$muestra29[4];
$querymvp30 = sprintf(CARDMVP30);
$resultmvp30 = execute_query($querymvp30, "topmvpcard.php");
$muestra30 = $resultmvp30->fetch_row();
$sumamvp30 = $muestra30[0]+$muestra30[1]+$muestra30[2]+$muestra30[3]+$muestra30[4];
$querymvp31 = sprintf(CARDMVP31);
$resultmvp31 = execute_query($querymvp31, "topmvpcard.php");
$muestra31 = $resultmvp31->fetch_row();
$sumamvp31 = $muestra31[0]+$muestra31[1]+$muestra31[2]+$muestra31[3]+$muestra31[4];
$querymvp32 = sprintf(CARDMVP32);
$resultmvp32 = execute_query($querymvp32, "topmvpcard.php");
$muestra32 = $resultmvp32->fetch_row();
$sumamvp32 = $muestra32[0]+$muestra32[1]+$muestra32[2]+$muestra32[3]+$muestra32[4];
$querymvp33 = sprintf(CARDMVP33);
$resultmvp33 = execute_query($querymvp33, "topmvpcard.php");
$muestra33 = $resultmvp33->fetch_row();
$sumamvp33 = $muestra33[0]+$muestra33[1]+$muestra33[2]+$muestra33[3]+$muestra33[4];
$querymvp34 = sprintf(CARDMVP34);
$resultmvp34 = execute_query($querymvp34, "topmvpcard.php");
$muestra34 = $resultmvp34->fetch_row();
$sumamvp34 = $muestra34[0]+$muestra34[1]+$muestra34[2]+$muestra34[3]+$muestra34[4];
$querymvp35 = sprintf(CARDMVP35);
$resultmvp35 = execute_query($querymvp35, "topmvpcard.php");
$muestra35 = $resultmvp35->fetch_row();
$sumamvp35 = $muestra35[0]+$muestra35[1]+$muestra35[2]+$muestra35[3]+$muestra35[4];
$querymvp36 = sprintf(CARDMVP36);
$resultmvp36 = execute_query($querymvp36, "topmvpcard.php");
$muestra36 = $resultmvp36->fetch_row();
$sumamvp36 = $muestra36[0]+$muestra36[1]+$muestra36[2]+$muestra36[3]+$muestra36[4];
$querymvp37 = sprintf(CARDMVP37);
$resultmvp37 = execute_query($querymvp37, "topmvpcard.php");
$muestra37 = $resultmvp37->fetch_row();
$sumamvp37 = $muestra37[0]+$muestra37[1]+$muestra37[2]+$muestra37[3]+$muestra37[4];
$querymvp38 = sprintf(CARDMVP38);
$resultmvp38 = execute_query($querymvp38, "topmvpcard.php");
$muestra38 = $resultmvp38->fetch_row();
$sumamvp38 = $muestra38[0]+$muestra38[1]+$muestra38[2]+$muestra38[3]+$muestra38[4];
$querymvp39 = sprintf(CARDMVP39);
$resultmvp39 = execute_query($querymvp39, "topmvpcard.php");
$muestra39 = $resultmvp39->fetch_row();
$sumamvp39 = $muestra39[0]+$muestra39[1]+$muestra39[2]+$muestra39[3]+$muestra39[4];
$querymvp40 = sprintf(CARDMVP40);
$resultmvp40 = execute_query($querymvp40, "topmvpcard.php");
$muestra40 = $resultmvp40->fetch_row();
$sumamvp40 = $muestra40[0]+$muestra40[1]+$muestra40[2]+$muestra40[3]+$muestra40[4];
$querymvp41 = sprintf(CARDMVP41);
$resultmvp41 = execute_query($querymvp41, "topmvpcard.php");
$muestra41 = $resultmvp41->fetch_row();
$sumamvp41 = $muestra41[0]+$muestra41[1]+$muestra41[2]+$muestra41[3]+$muestra41[4];
$querymvp42 = sprintf(CARDMVP42);
$resultmvp42 = execute_query($querymvp42, "topmvpcard.php");
$muestra42 = $resultmvp42->fetch_row();
$sumamvp42 = $muestra42[0]+$muestra42[1]+$muestra42[2]+$muestra42[3]+$muestra42[4];

opentable("Cantidad de Cards MVPs en el Server");
echo "
<hr>
<center><table width=\"600\" align=\"center\">
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4121.jpg\"><br><b><font size=1>Phreeoni Card: </font><font size=1 color=\"red\">".$sumamvp1."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4123.jpg\"><br><b><font size=1>Eddga Card: </font><font size=1 color=\"red\">".$sumamvp2."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4128.jpg\"><br><b><font size=1>Golden Thief Bug Card: </font><font size=1 color=\"red\">".$sumamvp3."</font></b><br><br></td>
</tr>
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4131.jpg\"><br><b><font size=1>Moonlight Flower Card: </font><font size=1 color=\"red\">".$sumamvp4."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4132.jpg\"><br><b><font size=1>Mistress Card: </font><font size=1 color=\"red\">".$sumamvp5."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4134.jpg\"><br><b><font size=1>Dracula Card: </font><font size=1 color=\"red\">".$sumamvp6."</font></b><br><br></td>
</tr>
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4135.jpg\"><br><b><font size=1>Orc Lord Card: </font><font size=1 color=\"red\">".$sumamvp7."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4137.jpg\"><br><b><font size=1>Drake Card: </font><font size=1 color=\"red\">".$sumamvp8."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4142.jpg\"><br><b><font size=1>Doppelganger Card: </font><font size=1 color=\"red\">".$sumamvp9."</font></b><br><br></td>
</tr>
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4143.jpg\"><br><b><font size=1>Orc Hero Card: </font><font size=1 color=\"red\">".$sumamvp10."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4144.jpg\"><br><b><font size=1>Osiris Card: </font><font size=1 color=\"red\">".$sumamvp11."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4146.jpg\"><br><b><font size=1>Maya Card: </font><font size=1 color=\"red\">".$sumamvp12."</font></b><br><br></td>
</tr>
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4147.jpg\"><br><b><font size=1>Baphomet Card: </font><font size=1 color=\"red\">".$sumamvp13."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4148.jpg\"><br><b><font size=1>Pharaoh Card: </font><font size=1 color=\"red\">".$sumamvp14."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4168.jpg\"><br><b><font size=1>Dark Lord Card: </font><font size=1 color=\"red\">".$sumamvp15."</font></b><br><br></td>
</tr>
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4236.jpg\"><br><b><font size=1>Amon Ra Card: </font><font size=1 color=\"red\">".$sumamvp16."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4263.jpg\"><br><b><font size=1>Samurai Specter Card: </font><font size=1 color=\"red\">".$sumamvp17."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4276.jpg\"><br><b><font size=1>Lord of Death Card: </font><font size=1 color=\"red\">".$sumamvp18."</font></b><br><br></td>
</tr>
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4302.jpg\"><br><b><font size=1>Tao Gunka Card: </font><font size=1 color=\"red\">".$sumamvp19."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4305.jpg\"><br><b><font size=1>Turtle General Card: </font><font size=1 color=\"red\">".$sumamvp20."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4318.jpg\"><br><b><font size=1>Stormy Knight Card: </font><font size=1 color=\"red\">".$sumamvp21."</font></b><br><br></td>
</tr>
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4324.jpg\"><br><b><font size=1>Garm Card: </font><font size=1 color=\"red\">".$sumamvp22."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4330.jpg\"><br><b><font size=1>Evil Snake Lord Card: </font><font size=1 color=\"red\">".$sumamvp23."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4342.jpg\"><br><b><font size=1>RSX-0806 Card: </font><font size=1 color=\"red\">".$sumamvp24."</font></b><br><br></td>
</tr>
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4352.jpg\"><br><b><font size=1>Egnigem Cenia Card: </font><font size=1 color=\"red\">".$sumamvp25."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4357.jpg\"><br><b><font size=1>Lord Knight Card: </font><font size=1 color=\"red\">".$sumamvp26."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4359.jpg\"><br><b><font size=1>Assassin Cross Card: </font><font size=1 color=\"red\">".$sumamvp27."</font></b><br><br></td>
</tr>
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4361.jpg\"><br><b><font size=1>Whitesmith Card: </font><font size=1 color=\"red\">".$sumamvp28."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4363.jpg\"><br><b><font size=1>High Priest Card: </font><font size=1 color=\"red\">".$sumamvp29."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4365.jpg\"><br><b><font size=1>High Wizard Card: </font><font size=1 color=\"red\">".$sumamvp30."</font></b><br><br></td>
</tr>
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4367.jpg\"><br><b><font size=1>Sniper Shecil Card: </font><font size=1 color=\"red\">".$sumamvp31."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4372.jpg\"><br><b><font size=1>Bacsojin Card: </font><font size=1 color=\"red\">".$sumamvp32."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4374.jpg\"><br><b><font size=1>Vesper Card: </font><font size=1 color=\"red\">".$sumamvp33."</font></b><br><br></td>
</tr>
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4376.jpg\"><br><b><font size=1>Lady Tanee Card: </font><font size=1 color=\"red\">".$sumamvp34."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4386.jpg\"><br><b><font size=1>Detale Card: </font><font size=1 color=\"red\">".$sumamvp35."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4399.jpg\"><br><b><font size=1>Thanatos Card: </font><font size=1 color=\"red\">".$sumamvp36."</font></b><br><br></td>
</tr>
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4403.jpg\"><br><b><font size=1>Kiel D-01 Card: </font><font size=1 color=\"red\">".$sumamvp37."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4407.jpg\"><br><b><font size=1>Valkyrie Randgris Card: </font><font size=1 color=\"red\">".$sumamvp38."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4419.jpg\"><br><b><font size=1>Ktullanux Card: </font><font size=1 color=\"red\">".$sumamvp39."</font></b><br><br></td>
</tr>
<tr>
	<td align=\"center\"><img src=\"./images/mvpcards/4425.jpg\"><br><b><font size=1>Atroce Card: </font><font size=1 color=\"red\">".$sumamvp40."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4430.jpg\"><br><b><font size=1>Ifrit Card: </font><font size=1 color=\"red\">".$sumamvp41."</font></b><br><br></td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td align=\"center\"><img src=\"./images/mvpcards/4441.jpg\"><br><b><font size=1>Fallen Bishop Card: </font><font size=1 color=\"red\">".$sumamvp42."</font></b><br><br></td>
</tr></table></center>";
closetable();
fim();
?>
