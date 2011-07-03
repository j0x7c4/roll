<?php
session_start();
if( isset($_SESSION['last_key']) && isset($_SESSION['login']) && $_SESSION['login']==true ) header("Location: roll.php");
include_once( 'config.php' );
include_once( 'lib.php' );
include_once( 'saet.ex.class.php' );
$o = new SaeTOAuth( WB_AKEY , WB_SKEY  );

$keys = $o->getRequestToken();
$aurl = $o->getAuthorizeURL( $keys['oauth_token'] ,false , 'http://' . $_SERVER['HTTP_APPNAME'] . '.sinaapp.com/callback.php');

$_SESSION['keys'] = $keys;


include 'header.php';
?>
为了ROLL的公平公正，需要新浪微博帐号才能登录！
</br>
<a href="<?=$aurl?>"><img src="http://open.sinaimg.cn/wikipic/button/48.png" /></a>



<?php 
include 'footer.php';
?>

