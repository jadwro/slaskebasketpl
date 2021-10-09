<?php

$_SympAdmin = TRUE;
######################
# COOKIE VARIABLES: 
# $sympauth[0] = md5 
# $sympauth[1] = user 
######################

# try to prevent caching 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

# file extension
$ext = substr(__FILE__, strrpos(__FILE__, ".") + 1);

# detect sympoll directory
$symphome = dirname(str_replace("\\", "/", __FILE__));
if(substr($symphome, -1) == "/") {
   $symphome = substr($symphome, 0, strlen($symphome) - 1);
}
$symphome = dirname($symphome);
if(substr($symphome, -1) == "/") {
   $symphome = substr($symphome, 0, strlen($symphome) - 1);
}

# include stuff
require "$symphome/common.$ext";
require dirname(__FILE__)."/accounts.$ext";
require dirname(__FILE__)."/polls.$ext";
require dirname(__FILE__)."/globals.$ext";
require dirname(__FILE__)."/setup.$ext";


###################################################################
## DISPLAYS HTML HEADER & FOOTER
###################################################################
function spit_header($full=TRUE) { 
   global $ext, $s_version, $sympauth, $title; ?>
   <html><head><title>Sympoll Administration</title>
   <meta http-equiv="robots" content="noindex,nofollow"></head>
   <body bgcolor="#dddddd" text="#000000" link="#0000aa" vlink="#0000aa" alink="#000055">

   <?php if(!$full) {
      return;
   } ?>

   <table border="0" cellpadding="0" cellspacing="0" align="center" width="95%">
   <tr><td align="left" valign="top">
   <font size="2" face="Verdana, Geneva"><b>
   <a href="index.<?php echo $ext; ?>">main menu</a> .
   <a href="index.<?php echo $ext; ?>?action=acc_p_logout">logout</a>
   </b></font></td><td align="right" valign="top">
   <font size="3" face="Verdana, Geneva"><b>
   <?php if(isset($title) && $title != "") {  
      echo "sympoll admin: $title";
   } else {
      echo "$sympauth[1] @ sympoll admin $s_version";
   } ?>
   </b></font></td></tr></table>
   <hr size="1" width="100%" align="center" /><br />
<?php }

function spit_footer() { 
   symp_disconnect(TRUE); ?>
   </body></html>
   <?php exit();
}


###################################################################
## DISPLAYS MAIN ADMIN PAGE
###################################################################
function display_opening() {
   global $s_dbid, $ext, $g_message, $s_cookielog, $s_iplog, $S_VIEW_HIDDEN,
          $S_VIEW_OPEN, $S_VIEW_CLOSED;

   /* get list of polls */
   symp_connect();
   $q1 = "SELECT pid,question,status,timeStamp from sympoll_list ORDER BY timeStamp DESC";
   $r1 = mysql_query($q1, $s_dbid);
   symp_disconnect();
   while($a1 = mysql_fetch_array($r1)) {
      $pl_pid = $a1['pid'];
      $pl_question[$pl_pid] = htmlspecialchars(stripslashes($a1['question']));
      $pl_status[$pl_pid] = $a1['status'];
      $pl_timestamp[$pl_pid] = $a1['timeStamp'];
   }

   /* keep track of some stuff and go */
   $verf = FALSE;
   if(verify_access(0)) {
      $verf = TRUE;
   }
   $colorrow = FALSE;
   spit_header(); ?>

   <!-- poll independant -->
   <table border="0" cellpadding="2" cellspacing="0" align="center" width="95%">
   <tr><td valign="middle" align="center">
   <font size="2" face="Verdana, Geneva">
   <a href="index.<?php echo $ext; ?>?action=polls_d_create">create new poll</a> . 
   <?php if($verf) { ?>
      <a href="index.<?php echo $ext; ?>?action=acc_d_adduser">create admin</a> . 
      <a href="index.<?php echo $ext; ?>?action=acc_d_rmuser">remove admin</a> .
   <?php } ?>
   <a href="index.<?php echo $ext; ?>?action=acc_d_chgpass">change password</a>
   </font></td></tr>
   <?php if($verf) { ?>
      <tr><td valign="middle" align="center">
      <font size="2" face="Verdana, Geneva">
      <a href="index.<?php echo $ext; ?>?action=config_d_db">configure database</a> . 
      <a href="index.<?php echo $ext; ?>?action=config_d_disp">configure display</a> . 
      <a href="index.<?php echo $ext; ?>?action=config_d_misc">configure miscellany</a>
      </font></td></tr>
   <?php } ?>
   </table><br />

   <?php if(isset($g_message) && $g_message != "") { ?>
      <div align="center"><font size="2" face="Verdana, Geneva" color="#ff0000">
      ** <?php echo $g_message; ?> **
      </font></div>
   <?php } ?>
   <br />
  
   <!-- poll dependant -->
   <?php if(isset($pl_question)) { ?>
      <table border="0" cellpadding="3" cellspacing="0" align="center" width="95%">
      <tr><td valign="top" align="left" nowrap="nowrap">
      <font size="1" face="Verdana, Geneva"><b>#</b>&nbsp;</font></td>

      <td valign="top" align="left" nowrap="nowrap">
      <font size="1" face="Verdana, Geneva"><b>status</b>&nbsp;&nbsp;</font></td>

      <td valign="top" align="left" width="100%">
      <font size="1" face="Verdana, Geneva"><b>question</b>&nbsp;&nbsp;</font></td>

      <td valign="top" align="left" nowrap="nowrap">
      <font size="1" face="Verdana, Geneva"><b>created</b>&nbsp;&nbsp;</font></td>

      <td valign="top" align="left" nowrap="nowrap">
      <font size="1" face="Verdana, Geneva"><b>tools</b></font></td></tr>

      <?php while(is_array($pl_question) && list($k,$v) = each($pl_question)) {
         $alink = "index."."$ext"."?pid="."$k"."&amp;action=";
         $tdbg = " bgcolor=\"#00bbbb\"";
         if($colorrow) {
            $tdbg = " bgcolor=\"#00cccc\"";
         } ?>

         <tr><td<?php echo $tdbg; ?> valign="top" align="left" nowrap="nowrap">
         <font size="1" face="Verdana, Geneva"><?php echo $k; ?>&nbsp;</font></td>

         <td<?php echo $tdbg; ?> valign="top" align="left" nowrap="nowrap">
         <font size="1" face="Verdana, Geneva">
         <?php if($pl_status[$k] & $S_VIEW_HIDDEN) { echo "hidden"; }
         else if($pl_status[$k] & $S_VIEW_OPEN)    { echo "open"; }
         else if($pl_status[$k] & $S_VIEW_CLOSED)  { echo "closed"; }
         else { echo "<b>error!</b>"; } ?>
         &nbsp;&nbsp;</font></td>

         <td<?php echo $tdbg; ?> valign="top" align="left" width="100%">
         <font size="2" face="Verdana, Geneva">
         <a href="<?php echo $alink; ?>polls_d_view"><?php echo $v; ?></a>
         &nbsp;&nbsp;</font></td>

         <td<?php echo $tdbg; ?> valign="top" align="left" nowrap="nowrap">
         <font size="1" face="Verdana, Geneva">
         <?php echo date("Y-M-d H:i", $pl_timestamp[$k]); ?>
         &nbsp;&nbsp;</font></td>
         
         <td<?php echo $tdbg; ?> valign="top" align="left" nowrap="nowrap">
         <font size="1" face="Verdana, Geneva">
         <a href="<?php echo $alink; ?>polls_d_edit">edit</a> <b>.</b>
         <a href="<?php echo $alink; ?>polls_d_reset">reset</a> <b>.</b>
         <a href="<?php echo $alink; ?>polls_d_delete">delete</a>
         <?php if( ($s_cookielog != "0" || $s_iplog != "0") && $verf) { ?>
            <b>.</b> <a href="<?php echo $alink; ?>polls_d_log">logging</a>
         <?php } ?>
         </font></td></tr>

         <?php $colorrow = !$colorrow;
      } ?>
      </table><br /><br />
   <?php } 
   spit_footer();
}


#########################################################################
## CODE EXECUTION
#########################################################################

# WE NEED A CONFIG FILE
if(!isset($action) && isset($_GET['action'])) {
   $action = $_GET['action'];
}
if(!file_exists("${symphome}/config.$ext") ||
      filesize("${symphome}/config.$ext") <= 0) {
   if(isset($action) && $action == 'setup_p_config') {
      setup_process_config();
   } else {
      setup_display_config();
   }
}
# WE'RE SET, LETS GO
symp_connect();


# ACTIONS THAT REQUIRE NO COOKIE
if(isset($action) && $action == 'acc_p_auth') {
   auth_user($user, $pass);
} else if(isset($action) && $action == 'acc_p_addsuper') {
   if(process_adduser($user, $pass1, $pass2, TRUE) == -1) {
      auth_display();         /* hack attempt, dump at login */
   } else {
      display_adduser(TRUE);  /* loop if adduser failed */
   }
}


# CHECK FOR ACCESS
if(isset($sympauth) && is_array($sympauth) && sizeof($sympauth) == 2) {
   while(list($k,$v) = each($sympauth)) {
      $sympauth[$k] = addslashes($v);
   }
   if(!auth_cookie()) {
      setup_check_dbtables();
      auth_display();
   }
} else {
   setup_check_dbtables();
   auth_display();
}


if(!isset($action) || $action == "") {
   display_opening();
}
# POLL DISPLAYS
else if($action == 'polls_d_create') { 
   display_create();
} else if($action == 'polls_d_view') { 
   display_view($_GET['pid']);
} else if($action == 'polls_d_edit') { 
   display_edit($_GET['pid']);
} else if($action == 'polls_d_delete' || $action == 'polls_d_reset') { 
   display_del_rs($_GET['pid'], $action);
} else if($action == 'polls_d_log') { 
   display_log($_GET['pid']);
} 
# ACCOUNT DISPLAYS
else if($action == 'acc_d_chgpass') { 
   display_pass();
} else if($action == 'acc_d_adduser') { 
   display_adduser(FALSE);
} else if($action == 'acc_d_rmuser') { 
   display_rmuser();
}
# CONFIG DISPLAYS
else if($action == 'config_d_db') {
   display_config_db();
} else if($action == 'config_d_disp') {
   display_config_disp();
} else if($action == 'config_d_misc') {
   display_config_misc();
}

# POLL PROCESSING
else if($action == 'polls_p_create') {
   process_create($question, $view, $type, $newo);
} else if($action == 'polls_p_edit') {
   if(!isset($deleteo)) { $deleteo = array(); }
   process_edit($pid, $question, $view, $type, $newo, $updateo, $deleteo);
} else if($action == 'polls_p_delete' || $action == 'polls_p_reset') {
   process_del_rs($pid, $confirmation); 
} else if($action == 'polls_p_log') {
   if(!isset($purgecookie)) { $purgecookie = ""; }
   if(!isset($purgeip)) { $purgeip = ""; }
   process_log($pid, $purgecookie, $purgeip);
}
# ACCOUNT PROCESSING
else if($action == 'acc_p_chgpass') { 
   process_pass($oldpass, $newpass1, $newpass2);
} else if($action == 'acc_p_adduser') {
   process_adduser($user, $pass1, $pass2, FALSE);
} else if($action == 'acc_p_rmuser'){
   process_rmuser($uid);
} else if($action == 'acc_p_logout') {
   $data = serialize(array());
   setcookie("sympauth", "$data");
   auth_display();
}
# CONFIG PROCESSING
else if($action == 'config_p_db') {
   process_config_db($ndbhost, $ndbuser, $ndbpass1, $ndbpass2, $ndbname);
} else if($action == 'config_p_disp') {
   process_config_disp($ntx, $nbg, $nbord, $nqtx, $nqbg, $noptsize, $ntxtsize,
         $ntxtface, $nwidth, $nbarimg, $nbarhite);
} else if($action == 'config_p_misc') {
   process_config_misc($ndirurl, $nmaxopts, $nblen, $nlang, $nrefer, $nplist,
         $nrnums, $nstotal, $niplog, $ncookielog);
}

display_opening();

# we should never get here, but..
symp_disconnect(TRUE);

?>
