<?php

//��ʾ����roll�����
function show_roll ()
{	
	// Edit Query
	$query = 'SELECT * FROM action ORDER BY time DESC LIMIT 20';
	
	// Perform Query
	$result = mysql_query($query);
	
	if (!$result) {
    		die('Query failed: ' . mysql_error());
	}
	echo '<ul>';
	while ($row = mysql_fetch_assoc($result)) {
    		echo '<li>'.$row['user'].'(IP:'.long2ip($row['ip']).') <font color=red>'.$row['roll'].'</font> '.$row['time'].'</li>';
	}
	echo '</ul>';
}

//��ȡ����roll�����
function getRoll ( )
{
	// Edit Query
	$query = 'SELECT * FROM action ORDER BY time DESC LIMIT 20';
	
	// Perform Query
	$result = mysql_query($query);
	
	if (!$result) {
    		die('Query failed: ' . mysql_error());
	}
	$list=array();
	while ($row = mysql_fetch_assoc($result)) {
		$list[]=array(
			'uid'=>$row['user'],
			'ip'=>long2ip($row['ip']),
			'roll'=>$row['roll'],
			'time'=>$row['time']
		);
	}
	return $list;
}


//����������uid��ȡroll�����
function getRollById ( $uid )
{
	// Edit Query
	$query = 'SELECT * FROM action WHERE user="'.$uid.'" ORDER BY time DESC LIMIT 20';
	
	// Perform Query
	$result = mysql_query($query);
	
	if (!$result) {
    		die('Query failed: ' . mysql_error());
	}
	$list=array();
	while ($row = mysql_fetch_assoc($result)) {
		$list[]=array(
			'uid'=>$row['user'],
			'ip'=>long2ip($row['ip']),
			'roll'=>$row['roll'],
			'time'=>$row['time']
		);
	}
	return $list;
}

//����������uid���飬��ȡroll�����
function getRollByIds ( $uids , $myid )
{
	// Edit Query
	$sqluids = 'user="'.$myid.'"';
	$count = count($uids);
	
	foreach ( $uids as $id )
		$sqluids .= 'OR user="'.$id.'"';
	
	$query = 'SELECT * FROM action WHERE '.$sqluids.' ORDER BY time DESC LIMIT 20';
	
	// Perform Query
	$result = mysql_query($query);
	
	if (!$result) {
    		die('Query failed: ' . mysql_error());
	}
	$list=array();
	while ($row = mysql_fetch_assoc($result)) {
		$list[]=array(
			'uid'=>$row['user'],
			'ip'=>long2ip($row['ip']),
			'roll'=>$row['roll'],
			'time'=>$row['time']
		);
	}
	return $list;
}

//����ROLL��¼
function addRollRecord( $user , $n )
{
	if ( $user == null ) 
		header("location:index.php");
		
	$ip=ip2long($_SERVER["REMOTE_ADDR"]);
	
	$user = trim($user);
	if ( $user== NULL ) $user = "����";
	$roll = $n;
	//Edit query
	
	$query = 'INSERT INTO action (user,roll,ip) VALUES ("'.$user.'",'.$roll.','.$ip.')';
	//echo $query;
	//Perform query
	mysql_query($query) or die("����ʧ��:".mysql_error());
}

?>

