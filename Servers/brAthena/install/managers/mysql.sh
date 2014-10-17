#!/bin/bash                                                                 
# @Author: Protimus                                                        
# @Date: 01/05/2013                                                           
# @File: mysql.sh - Script to create mysql database and user with brAthena Installer interaction                                                                      
#################################################################################################

$password =  
$emulator_user = 
$emulator_pass = 
$lang = 
$version =

# Starting MySQL
service mysql start

# Installing MySQL
sh ./mysql_secure_installation

# Creating MySQL user for emulator
mysqladmin -u root -p $password
mysql> CREATE USER $emulator_user@localhost IDENTIFIED BY $emulator_pass;

# Creating MySQL databases
mysql> CREATE DATABASE ''ragnarok''; 
mysql> CREATE DATABASE ''db''; 
mysql> CREATE DATABASE ''log''; 

# Import databases of emulator to MySQL
cd brathena/db/$lang
mysqldump -h localhost -u $emulator_user -p ragnarok >  brathena.sql
mysqldump -h localhost -u $emulator_user -p db >  $version
mysqldump -h localhost -u $emulator_user -p log > logs.sql  
	
# Grant permissions to MySQL databases
mysql> GRANT ALL PRIVILEGES ON ''ragnarok''.* TO $emulator_user@localhost IDENTIFIED BY $emulator_pass;
mysql> GRANT ALL PRIVILEGES ON ''db''.* TO $emulator_user@localhost IDENTIFIED BY $emulator_pass;
mysql> GRANT ALL PRIVILEGES ON ''log''.* TO $emulator_user@localhost IDENTIFIED BY $emulator_pass;
mysql> FLUSH PRIVILEGES;
mysql> EXIT
