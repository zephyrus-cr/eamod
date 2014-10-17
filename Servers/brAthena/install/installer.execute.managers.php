<?php
/**
 * brAthena Installation Module
 * A dynamic module for easy and quick installation.
 *
 * @File: installer.execute.managers.php - Responsible for reading and start the shell scripts interactors, for to do a linux commands.
 * @Author: Protimus                                                        
 * @Date: 01/05/2013              
 *
 */	
 
/* Classes to do installer steps and run */
class brAInstaller {
public function run::Ssh();
}

/* Classes to connect and authenticate an session */
class Ssh {
	private $ssh_connect;
	public function __construct($host, $port = 22) // Default port is 22, change it if you can.
	{
		$this->ssh_connect = ssh2_connect($host,$port);
	}

	public function Auth( $username, $password )
	{
		return ssh2_auth_password($this->ssh_connect,$username,$password);
	}

	public function Exec( $ssh_command )
	{
		return ssh2_exec( $this->ssh_connect, $ssh_command );
	}
}

$ssh_connect = new Ssh('host','port'); // Connecting a section
if ($ssh_connect->Auth('user','pass')) { // Authenticating session 
	if ($ssh_connect == false) { // Wrong host IP or password
		die("Failed to connect");
	} else {
	stream_set_blocking($ssh_connect, true); // Return a correct execution
	break;
	}
}
 
/* Downloading library packages for emulator. */
if (rhel) { // RedHat Based OS
$ssh_command = ssh2_exec($ssh_connect, '/usr/bin/yum install packages?'); // Get the packages by command
	if ($ssh_command === false) { // If ssh doesn't is installed or doesn't have the package selected in command
		die("Failed to execute command");
	}
	stream_set_blocking($ssh_command, true); // Return a correct execution
	break;
} else { // Debian Based OS
$ssh_command = ssh2_exec($ssh_connect, '/usr/bin/yum install packages?'); // Get the packages by command
	if ($ssh_command === false) { // If ssh doesn't is installed or doesn't have the package selected in command
		die("Failed to execute command"); 
	}
	stream_set_blocking($ssh_command, true); // Return a correct execution
	break;
}

/* Downloading the emulator. */
$ssh_command = ssh2_exec($ssh_connect, '/usr/bin/svn co http://svn.brathena.org/brAthena/');
	if ($ssh_command == false) { // If ssh or subversion doesn't is installed
		die("Failed to execute command");
	}
	stream_set_blocking($ssh_command, true); // Return a correct execution
	break;
	
/* Creating MySQL database and user. */
$ssh_command = ssh2_exec($ssh_connect, '/../brathena/install/managers/mysql.sh');
	if ($ssh_command == false) { // If ssh or subversion doesn't is installed
		die("Failed to execute command");
	}
	stream_set_blocking($ssh_command, true); // Return a correct execution
	break;

/* Change packetver. */


/* Compiling. */
$ssh_command = ssh2_exec($ssh_connect, '/../brathena/install/managers/brainstall.sh'); 
	if ($ssh_command == false) { // If ssh doesn't is installed or have a problem in shell script
		die("Failed to execute command");
	}
	stream_set_blocking($ssh_command, true); // Return a correct execution
	break;

exit();

?>