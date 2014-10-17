<?php 
/*************
 * SQL Table
 *
	CREATE TABLE `vote_point` (
	  `account_id` int(11) NOT NULL default '0',
	  `point` int(11) NOT NULL default '0',
	  `last_vote1` int(11) NOT NULL default '0',
	  `last_vote2` int(11) NOT NULL default '0',
	  `last_vote3` int(11) NOT NULL default '0',
	  `date` text NOT NULL,
	  PRIMARY KEY  (`account_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;
 *
 *
 *************/


session_start();

include('config.php');
include('functions.php');

$site = $_GET['site'];
$link = unserialize(VOTE_LINK);

if( !isset($site) || !isset($link[ $site ]) )
	header( 'Location: index.php' );
else if( !isset($_SESSION[$CONFIG_name.'account_id']) )
	votes();
else {
	$result = execute_query("SELECT `point`, `last_vote".$site."` FROM `vote_point` WHERE `account_id` = '".$_SESSION[$CONFIG_name.'account_id']."' LIMIT 0,1", "vote.php");
	if( $result->count() > 0 ) {
		$row = $result->fetch_row();

		if( ( time() - $row[ 1 ] ) > (60 * 60 * VOTE_TIME) )
			execute_query("UPDATE `vote_point` SET `point` = ".($row[0] + 1)." , `last_vote".$site."` = '".time()."', `date` = '".date("d.m.y H:i")."' WHERE `account_id` = '".$_SESSION[$CONFIG_name.'account_id']."'", "vote.php");
		votes();
	} else {
		execute_query("INSERT INTO `vote_point` ( `account_id` , `point` , `last_vote".$site."` , `date` ) VALUES ( '".$_SESSION[$CONFIG_name.'account_id']."' , 1 , '".time()."' , '".date("d.m.y H:i")."')", "vote.php");
		votes();
	}
}



function votes() {
	global $site, $link;

	if( isset($link[ $site ]) )
		header( 'Location: '.$link[ $site ] ); 
	else
		header( 'Location: index.php' );
	die();
}



?>
