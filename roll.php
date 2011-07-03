<?php
session_start();
if ( !isset($_SESSION['login']) || $_SESSION['login']!=true ) header("location:index.php");
include 'config.php';
include 'lib.php';
include_once( 'saet.ex.class.php' );


$c = new SaeTClient( WB_AKEY , WB_SKEY , $_SESSION['last_key']['oauth_token'] , $_SESSION['last_key']['oauth_token_secret']  );
if ($c==null) header("location:index.php");

//�������ݿ�
$link=mysql_connect(DB_URL,DB_USER,DB_PASSWORD) or die('Could not connect: ' . mysql_error());
mysql_select_db(DB_NAME,$link);

//����POST 
//��ֹ�ظ�ˢ��
 
if ( isset($_POST['action']) && $_POST['action'] == 'submitted' )
{
	$n = rand(0,100);
	if ( $_POST['share'] )
		$c->update('Ϊ�˾���˭ȥ���������������"˭ȥ������"���Ӧ����������'.$n.'�㡣��������?http://roll.sinaapp.com');
	//echo $_POST['uid'];
	if ( $_POST['uid']!=null )
		addRollRecord($_POST['uid'],$n);
	else
	{
		session_destroy();
		header("location:index.php");
	}
	unset($_POST['action']);
	header("location:index.php");
}

include 'header.php';
?>
<?php
$me = $c->verify_credentials();
//�û�ID

?>
<div class="notice">
<p><b>������ʾ</b><br>
�����ϣ����ROLL�ĵ�����������������΢���У�����ѡ���ұ�����
<img src="http://roll.sinaapp.com/img/share_button_s.gif" />ǰ��Ĺ���
</p>
</div>
<div id="sidebar-a">
<div class="padding">
<div class="self-info">
<div class="self-info-a">
	<div class="self-info-image"> 
		<img src="<?=$me['profile_image_url'];?>" alt="<?=$me['screen_name'];?>" > 
	</div>


	<div class="self-info-name"><?=$me['name']?></div>
</div>
<div class="self-info-b">
	<div class="self-info-text">
	<span>��ע<?=$me['friends_count'];?></span>
	<span>��˿<?=$me['followers_count'];?></span>
	<span>΢��<?=$me['statuses_count'];?></span>
	</div>
</div>
</div>
<div class = "roll-form" align="center">
<form method="POST" action="roll.php">
<input type="hidden" name="action" value="submitted" />
<input type="hidden" name="uid" value="<?=$me['id'];?>" />
<input type="submit" value="ROLL!!!" />

<input type="button" value="ˢ��" onclick="refresh();" />
<span class= "roll-form-share" ><input type="checkbox" name="share" /><img src="http://roll.sinaapp.com/img/share_button_s.gif" />
</span>
</form>
</div>
<div class = "self-board">
<iframe id="sina_widget_<?=$me['id'];?>" style="width:100%; height:500px;" frameborder="0" scrolling="no" src="http://v.t.sina.com.cn/widget/widget_blog.php?uid=<?=$me['id'];?>&height=500&skin=wd_01&showpic=1"></iframe>
</div>
</div><!--padding-->
</div><!--sidebar-a-->
<!--
<div class="feedback" >

</div>
-->
<div id="content">
<div class="padding">
<?php 

$selected = 'all';

if ( isset($_GET['friends']) )
{ 
	$selected = 'friends';
	$ids = $c->friends_ids(); 
	
	//echo count($ids['ids']);
	
	//echo $me['friends_count'];
	//$list = getRoll();
	
	$list = getRollByIds($ids['ids'],$me['id'] );
	
}
else if ( isset($_GET['me']) )
{
	$selected = 'me';
	$list = getRollById($me['id']);	
}
if ( $selected == 'all' )
	$list = getRoll();

?>
	
	<div class="stream-navi">
	<span class="stream-navi-item<?php if ( $selected == 'all' ) echo "-selected"; ?>"><a href="roll.php"><b>ȫ��</b></a></span>
	<span class="stream-navi-item<?php if ( $selected == 'friends' ) echo "-selected"; ?>"><a href="roll.php?friends"><b>�ҹ�ע��</b></a></span>
	<span class="stream-navi-item<?php if ( $selected == 'me' ) echo "-selected"; ?>"><a href="roll.php?me"><b>�ҵ�</b></a></span>
	</div> <!--stream-navi-->
	<div class="stream-items">
<?php
if ( count($list)>0 )
{
	foreach ( $list as $rec )
	{
		$user = $c->show_user($rec['uid']); 
		?>
<div class="stream-item" > 
  <div class="stream-item-content"> 
  	<div class="roll-image"> 
      		<img src="<?=$user['profile_image_url'];?>" alt="<?=$user['screen_name'];?>" data-user-id="<?=$user['id'];?>"> 
  	</div> 
  	<div class="roll-content"> 
    		<div class="roll-row"> 
      			<span class="roll-user-name"> 
  				<a class="roll-screen-name user-profile-link" data-user-id="<?=$user['id'];?>" href="<?="http://t.sina.com.cn/".$user['id'];?>" title="<?=$user['screen_name'];?>" target="_blank" ><?=$user['screen_name'];?></a> 
  				<!--<span class="roll-full-name"><?=$user['name'];?></span>-->
			</span> 
    		</div> 
    		<div class="roll-row"> 
      			<div class="roll-text">������<?=$rec['roll'];?>��</div> 
    		</div> 
    		<div class="roll-row"> 
      			<a class="roll-timestamp"><span class="_timestamp"><?=$rec['time'];?></span></a> 
    		</div> 
    	</div>
  </div> 
</div> 
		
		
<?php
	}
}
	?>
	
	</div>

</div><!--padding-->
</div><!--content-->
<?php 
include 'footer.php';
?>
<script language="javascript">
function refresh( )
{
	//self.location= "index.php";
	location=location;
}
</script>
<?php
mysql_close($link);
?>

