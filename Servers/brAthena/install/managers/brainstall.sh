#!/bin/bash                                                                 
# @Author: Protimus                                                        
# @Date: 01/05/2013                                                           
# @File: brainstall.sh - Script to compile emulator with brAthena Installer interaction                                                                      
#####################################################################################

$dir = cd brathena
$configure = sh ./configure
$make = make sql

# Change to emulator directory
cd brathena
if ($dir == false)
	echo "Error to change directory or directory doesn't exist";
	break;
else 
	return 0;
	
# Clean the directory for prevent any errors.
make clean

# Configuring for compile.
sh ./configure
if ($configure == false)
	echo "Error in configure file, please open configure log in your folder emulator";
	break;
else
	return 0;

# Compiling the emulator	
make sql
if ($make == false)
	echo "Error to do a compiling, aborting...";
	break;
else
	return 0;