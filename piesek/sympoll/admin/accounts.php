<?php

###################################################################
## DISPLAY LOGIN SCREEN
###################################################################
function auth_display() {
   global $g_message, $ext;

   spit_header(FALSE); ?>
   <div align="center"><font size="5" face="Verdana, Geneva">
   <br />
   <b>Sympoll Administration</b></font></div>
   <br /><br /><br />

   <div align="center">
   <?php if(isset($g_message) && $g_message != "") { ?>
      <font size="3" face="Verdana, Geneva" color="#ff0000">
      <?php echo $g_message; ?>
      </font><br /><br />
   <?php } ?>
   </div>

   <form action="index.<?php echo $ext; ?>" method="post">
   <table border="0" align="center">
   <tr><td><font size="2" face="Verdana, Geneva"><b>
   username:
   </b></font></td><td>
   <input name="user" type="text" size="16" maxlength="16" />
   </td></tr><tr><td><font size="2" face="Verdana, Geneva"><b>
   password:
   </b></font></td><td>
   <input name="pass" type="password" size="16" maxlength="16" />
   </td></tr><tr><td colspan="2"><br />
   <input type="submit" value="Authenticate" />
   </td></tr></table>
   <input type="hidden" name="action" value="acc_p_auth" /></form>
   <?php spit_footer();
}


###################################################################
## ADMIN COOKIE DETECTED, CHECK MD5
###################################################################
function auth_cookie() {
   global $sympauth, $s_dbid;

   $q1  = "SELECT uid FROM sympoll_auth ";
   $q1 .= "WHERE(user='$sympauth[1]' AND secret='$sympauth[0]')";
   $r1 = mysql_query($q1, $s_dbid);
   if($r1 && mysql_num_rows($r1) == 1) {
      return TRUE;
   }
   return FALSE;
}


###################################################################
## NO ADMIN COOKIE DETECTED, VERIFY LOGIN INFO
###################################################################
function auth_user($user, $pass) {
   global $sympauth, $g_message, $s_dbid;

   $user = addslashes($user);
   $pass = md5($pass);
   $md5 = md5(time());

   $q1  = "UPDATE sympoll_auth SET secret='$md5' ";
   $q1 .= "WHERE(user='$user' AND pass='$pass')";
   $r1 = mysql_query($q1, $s_dbid);
   if(mysql_affected_rows($s_dbid) <= 0) {
      $g_message = "Invalid Login";
      auth_display();
   }

   # admin auth cookies last for 3 hours (10800 seconds)
   $sympauth[0] = $md5;
   $sympauth[1] = $user;
   $data = serialize($sympauth);
   setcookie("sympauth", "$data");
}


###################################################################
## VERIFY THAT USER HAS APPROPRIATE ACCESS
###################################################################
function verify_access($access) {
   global $sympauth, $s_dbid;

   $q1  = "SELECT uid FROM sympoll_auth WHERE(user='$sympauth[1]' "; 
   $q1 .= "AND secret='$sympauth[0]' AND access='$access')";
   $r1  = mysql_query($q1, $s_dbid);
   if($r1 && mysql_num_rows($r1) == 1) {
      return TRUE;
   }
   return FALSE;
}


###################################################################
## DISPLAYS FORM USED TO ADD ADMIN USER
###################################################################
function display_adduser($first) {
   global $ext, $g_message, $title;

   if(!$first && !verify_access(0)) {
      $g_message = "error: you are not the super user!";
      return;
   }

   if($first == TRUE) { 
      spit_header(FALSE); ?>
      <div align="center"><font size="5" face="Verdana, Geneva">
      <b>Sympoll: Create Super User</b></font></div>
      <br /><br /><br />
      <form action="index.<?php echo $ext; ?>" method="post">
      <input type="hidden" name="action" value="acc_p_addsuper" />
      <table border="0" cellspacing="0" align="center" width="95%">
      <tr><td><font size="2" face="Verdana, Geneva">
      You do not have a super administrator created.  This administrator will
      have the same access as regular administrators, plus it will have the
      added abilities to add/remove admins and to change additional
      sympoll configuration settings.
      <?php if(isset($g_message) && $g_message != "") { ?>
         <br /><br />
         <font color="#ff0000"><?php echo $g_message; ?></font>
      <?php } ?>
      <br /><br />
   <?php } else {
      $title = "create admin";
      spit_header(); ?>
      <form action="index.<?php echo $ext; ?>" method="post">
      <input type="hidden" name="action" value="acc_p_adduser" />
      <table border="0" cellspacing="0" align="center" width="95%">
      <tr><td><font size="2" face="Verdana, Geneva">
   <?php } ?>

   Username:<br />
   &nbsp;&nbsp;<input name="user" type="text" size="16" maxlength="16" />
   <br />Password:<br />
   &nbsp;&nbsp;<input name="pass1" type="password" size="16" maxlength="16" />
   <br />Password Again:<br />
   &nbsp;&nbsp;<input name="pass2" type="password" size="16" maxlength="16" />
   <br /><br /><br /><input type="submit" value="Create User" /> &nbsp;
   <input type="reset" value="Clear Values" /></font></td></tr></table></form>
   <?php spit_footer();
}


###################################################################
## DISPLAYS FORM USED TO REMOVE ADMIN USER
###################################################################
function display_rmuser() {
   global $ext, $g_message, $title, $s_dbid;

   if(!verify_access(0)) {
      $g_message = "error: you are not the super user!";
      return;
   }

   /* fetch all of the non-super users */
   $q1 = "SELECT uid,user FROM sympoll_auth WHERE(access != 0) ORDER BY uid";
   $r1 = mysql_query($q1, $s_dbid);
   while($a1 = mysql_fetch_array($r1)) {
      $uid = $a1['uid'];
      $users[$uid] = htmlspecialchars(stripslashes($a1['user']));
   }

   /* start display */
   $title = "remove admin";
   spit_header(); ?>
   <form action="index.<?php echo $ext; ?>" method="post">
   <input type="hidden" name="action" value="acc_p_rmuser" />
   <table border="0" cellspacing="0" align="center" width="95%">
   <tr><td><font size="2" face="Verdana, Geneva">

   <b>WARNING:  This Cannot Be Undone</b><br /><br />
   <?php if(!isset($users)) { ?>
      There are no users to remove.<br />
      (note: the super user may not be removed)<br />
      </font></td></tr></table></form> 
      <?php spit_footer();
   }
   $size = min(4, sizeof($users)); ?>
   <select name="uid" size="<?php echo $size; ?>">
   <?php while(list($k,$v) = each($users)) {
      if(!isset($firstadmin)) {
         $firstadmin = TRUE; ?>
         <option value="<?php echo $k; ?>" selected="selected"><?php echo $v; ?></option>
      <?php } else { ?>
         <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
      <?php }
   } ?>
   </select><br /><br /><br />
   <input type="submit" value="Remove User" />
   </font></td></tr></table></form> 
   <?php spit_footer();
}


###################################################################
## DISPLAY CHANGE PASSWORD SCREEN
###################################################################
function display_pass() {
   global $sympauth, $ext, $title;
   $title = "change password";
   spit_header(); ?>

   <form action="index.<?php echo $ext; ?>" method="post">
   <input type="hidden" name="action" value="acc_p_chgpass" />
   <table border="0" cellspacing="0" align="center" width="95%">
   <tr><td><font size="2" face="Verdana, Geneva">

   Username:<br />
   &nbsp;&nbsp;<b><?php echo $sympauth[1]; ?></b>
   <br />Old Password:<br />
   &nbsp;&nbsp;<input name="oldpass" type="password" size="16" maxlength="16" />
   <br />New Password:<br />
   &nbsp;&nbsp;<input name="newpass1" type="password" size="16" maxlength="16" />
   <br />New Password Again:<br />
   &nbsp;&nbsp;<input name="newpass2" type="password" size="16" maxlength="16" />
   <br /><br /><br /><input type="submit" value="Process Change" /> &nbsp;
   <input type="reset" value="Clear Values" /></font></td></tr></table></form>
   <?php spit_footer();
}


###################################################################
## PROCESSES CREATION OF ADMIN
###################################################################
function process_adduser($user, $pass1, $pass2, $first) {
   global $g_message, $s_dbid;

   if(!$first && !verify_access(0)) {
      $g_message = "error: you are not the super user!";
      return 0;
   }

   if($first) {
      $q3 = "SELECT uid FROM sympoll_auth WHERE(access='0')";
      $r3 = mysql_query($q3, $s_dbid);
      if(mysql_num_rows($r3) > 0) {
         $g_message = "error: super user already exists!";
         return -1;
      }
   }



   if(!ereg("^[^\\\"']+$", $user)) {
      $g_message = "user creation <b>failed</b>: invalid username";
      return 0;
   } else if(strcmp($pass1, $pass2) != 0) {
      $g_message = "user creation <b>failed</b>: passwords do not match";
      return 0;
   } else if(!ereg("^[^\\\"']+$", $pass1)) {
      $g_message = "user creation <b>failed</b>: invalid password";
      return 0;
   }

   $pass = md5($pass1);
   $access = 1;
   if($first) {
      $access = 0;
   }

   $q1 = "SELECT user FROM sympoll_auth WHERE(user='$user')";
   $r1 = mysql_query($q1, $s_dbid);
   if(mysql_num_rows($r1) != 0) {
      $g_message = "user creation <b>failed</b>: <i>$user</i> already exists";
      return 0;
   }

   $q2  = "INSERT INTO sympoll_auth (uid, user, pass, access) ";
   $q2 .= "VALUES(NULL, '$user','$pass','$access')";
   $r2 = mysql_query($q2, $s_dbid);
   if(mysql_affected_rows($s_dbid) <= 0) {
      $g_message = "user creation <b>failed</b>: database error occurred";
      return 0;
   }

   $g_message = "<i>$user</i> has been created";
   if($first) {
      auth_display();
   }
}


###################################################################
## PROCESSES REMOVAL OF ADMIN
###################################################################
function process_rmuser($uid) {
   global $g_message, $s_dbid;

   if(!verify_access(0)) {
      $g_message = "error: you are not the super user!";
      return;
   }

   $q1 = "SELECT user,access FROM sympoll_auth WHERE(uid='$uid')";
   $r1 = mysql_query($q1, $s_dbid);
   $a1 = mysql_fetch_array($r1);
   if($a1['access'] == 0 ) {
      $g_message = "user removal <b>failed</b>: super user may not be removed";
      return;
   }

   $q2 = "DELETE FROM sympoll_auth WHERE(uid='$uid')";
   $r2 = mysql_query($q2, $s_dbid);
   if(mysql_affected_rows($s_dbid) <= 0) {
      $g_message = "user removal <b>failed</b>: database error occurred";
      return;
   }

   $g_message = "<i>$a1[user]</i> has been removed";
}


###################################################################
## PROCESSES PASSWORD CHANGE
###################################################################
function process_pass($oldpass, $newpass1, $newpass2) {
   global $sympauth, $g_message, $s_dbid;

   if(strcmp($newpass1, $newpass2) != 0) {
      $g_message = "pass change <b>failed</b>: passwords do not match";
      return;
   } else if(!ereg("^[^\\\"']+$", $newpass1)) {
      $g_message = "pass change <b>failed</b>: invalid new password";
      return;
   }

   $opass = md5($oldpass);
   $npass = md5($newpass1);
   $q1  = "UPDATE sympoll_auth SET pass='$npass' WHERE";
   $q1 .= "(user='$sympauth[1]' AND secret='$sympauth[0]' AND pass='$opass')";
   $r1 = mysql_query($q1, $s_dbid);
   if(mysql_affected_rows($s_dbid) <= 0) {
      $g_message = "pass change <b>failed</b>: incorrect old pass";
      return;
   }

   $g_message = "pass for <i>$sympauth[1]</i> has been changed";
}

?>
