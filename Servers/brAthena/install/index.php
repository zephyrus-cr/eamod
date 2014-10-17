<?php
/**
 * brAthena Installation Module
 * A dynamic module for easy and quick installation.
 *
 * @File: index.php - Responsible for reading and booting the installer.
 * @Author: Protimus                                                        
 * @Date: 01/05/2013              
 *
 */	
 
include('./installer.template.php'); // Reading template.
require_once( 'installer.requirements.php' ); // Requiriments to pass the steps.
include('./installer.execute.managers.php'); // Reading managers.

brAInstaller::run();

exit();

?>