<?php

function setup_check_dbtables() {
   global $s_dbid, $s_dbname;

   $tb[0] = "sympoll_data";
   $tb_cols[0] = array("pid", "cid", "choice", "votes");
   $tb_type[0] = array("int", "int", "varchar(250)", "int");
   $tb_xtra[0] = array("", "", "", "");

   $tb[1] = "sympoll_list";
   $tb_cols[1] = array("pid", "nextcid", "question", "timeStamp", "cookieStamp", "status");
   $tb_type[1] = array("int", "int", "varchar(250)", "int", "int", "smallint");
   $tb_xtra[1] = array("auto_increment", "", "", "", "", "");

   $tb[2] = "sympoll_auth";
   $tb_cols[2] = array("uid", "user", "pass", "access", "secret");
   $tb_type[2] = array("int", "varchar(32)", "varchar(32)", "smallint", "varchar(32)");
   $tb_xtra[2] = array("auto_increment", "", "", "", "");

   $tb[3] = "sympoll_iplog";
   $tb_cols[3] = array("vid", "pid", "voted");
   $tb_type[3] = array("varchar(32)", "int", "int");
   $tb_xtra[3] = array("", "", "");

   while(list($k,$v) = each($tb)) {
      $q1 = "SHOW COLUMNS FROM $tb[$k]";
      $r1 = @mysql_query($q1, $s_dbid);
      if(!$r1 || mysql_num_rows($r1) <= 0) {
         $tbc[$k] = $v;
         continue;
      }

      for($dsr = 0; $a1 = mysql_fetch_array($r1); $dsr++) {
         if(   $dsr >= sizeof($tb_cols[$k]) ||
               $a1['Field'] != $tb_cols[$k][$dsr] ||
               !stristr($a1['Type'], $tb_type[$k][$dsr]) ||
               ($tb_xtra[$k][$dsr] != "" && !stristr($a1['Extra'], $tb_xtra[$k][$dsr])) ) {

            $tbu[$k] = $v;
         }
      }
   }

   if(isset($tbc) && is_array($tbc) && sizeof($tbc) > 0) {
      global $action, $tbc_str;
      if(isset($action) && $action == 'setup_p_dbtables') {
         setup_process_dbtables(unserialize(urldecode($tbc_str)));
      } else {
         setup_display_dbtables($tbc);
      }
   } else if(isset($tbu) && is_array($tbu) && sizeof($tbu) > 0) {
      global $action, $gen;
      if(isset($action) && $action == 'upgrade_p_dbtables') {
         upgrade_process_dbtables((int)$gen);
      } else {
         upgrade_display_dbtables($tbu);
      }
   }

   /* check if superadmin exists */
   $q2 = "SELECT uid FROM sympoll_auth WHERE(access='0')";
   $r2 = mysql_query($q2, $s_dbid);
   if(mysql_num_rows($r2) <= 0) {
      display_adduser(TRUE);
   }
}


function setup_display_config() {
   global $g_message, $SYMP_URL, $ext, $ndbhost, $ndbuser, $ndbname, $ndirurl;

   if(!isset($ndbhost) || $ndbhost == "") {
      $ndbhost = "localhost"; 
   }
   if(!isset($ndbname) || $ndbname == "") {
      $ndbname = "sympoll"; 
   }
   if(!isset($ndbuser)) {
      $ndbuser = "";
   }
   if(!isset($ndirurl) || $ndirurl == "") {
      if(isset($SYMP_URL) && $SYMP_URL != "") {
         $urlarr = parse_url($SYMP_URL);
         if(isset($urlarr['path']) && $urlarr['path'] != "") { 
            $foo = substr($urlarr['path'], 0, strrpos($urlarr['path'], "/")); 
            $foo = substr($foo, 0, strrpos($foo, "/") + 1); 
         } else  {
            $foo = "/"; 
         }
         $ndirurl = "$urlarr[scheme]"."://"."$urlarr[host]"."$foo"; 
      } else {
         $ndirurl = "http://";
      }
   }
   if(substr($ndirurl, -1) != "/") {
      $ndirurl .= "/";
   }

   $ndbhost = htmlspecialchars($ndbhost);
   $ndbuser = htmlspecialchars($ndbuser);
   $ndbname = htmlspecialchars($ndbname);
   $ndirurl = htmlspecialchars($ndirurl); 

   spit_header(FALSE); ?>
   <div align="center"><font size="5" face="Verdana, Geneva">
   <b>Sympoll Setup: Configuration</b></font></div><br /><br />
   <form action="index.<?php echo $ext; ?>" method="post">
   <input type="hidden" name="action" value="setup_p_config" />
   <table border="0" cellspacing="0" align="center" width="95%">
   <tr><td><font size="2" face="Verdana, Geneva">

   This information is required to continue and the database connection
   must currently be active.  Some default values are provided, although
   you may need to change them.<br /><br />

   <?php if(isset($g_message) && $g_message != "") { ?>
      <br /><font size="3" color="#ff0000">
      ** <?php echo $g_message; ?> **
      </font><br />
   <?php } ?>

   <br />Database Server:<br />&nbsp;&nbsp;
   <input type="text" maxlength="50" size="20" name="ndbhost" value="<?php echo $ndbhost; ?>" />
   <br />Database Username:<br />&nbsp;&nbsp;
   <input type="text" maxlength="50" size="20" name="ndbuser" value="<?php echo $ndbuser; ?>" />
   <br />Database Password:<br />&nbsp;&nbsp;
   <input type="password" maxlength="50" size="20" name="ndbpass1" />
   <br />Database Password Again:<br />&nbsp;&nbsp;
   <input type="password" maxlength="50" size="20" name="ndbpass2" />
   <br />Actual Database Name:<br />&nbsp;&nbsp;
   <input type="text" maxlength="50" size="20" name="ndbname" value="<?php echo $ndbname; ?>" />
   <br />Full URL to Sympoll directory:<br />&nbsp;&nbsp;
   <input type="text" maxlength="100" size="40" name="ndirurl" value="<?php echo $ndirurl; ?>" />
   <br /><br /><br /><input type="submit" value="Continue" /> &nbsp;
   <input type="reset" value="Undo Changes" /></font></td></tr></table></form>
   <?php spit_footer();
}


function setup_process_config() {
   global $ndbhost, $ndbuser, $ndbpass1, $ndbpass2, $ndbname, $ndirurl;
   global $s_dbhost, $s_dbuser, $s_dbpass, $s_dbname, $s_dirurl;
   global $s_tx, $s_bg, $s_bord, $s_iplog, $s_cookielog;
   global $s_qtx, $s_qbg, $s_optsize, $s_txtsize, $s_txtface;
   global $s_width, $s_barimg, $s_barhite, $s_maxopts;
   global $s_blength, $s_refer, $s_polllist, $s_resultnums, $s_showtotal;
   global $g_message, $ext;


   if(!ereg("^[^\\\"']+$", $ndbhost)) {
      $g_message = "setup failed: invalid database server";
      setup_display_config();
   } else if(!ereg("^[^\\\"']*$", $ndbuser)) {
      $g_message = "setup failed: invalid database username";
      setup_display_config();
   } else if(strcmp($ndbpass1, $ndbpass2) != 0) {
      $g_message = "setup failed: database passwords do not match";
      setup_display_config();
   } else if(!ereg("^[^\\\"']*$", $ndbpass1) != 0) {
      $g_message = "setup failed: invalid database password";
      setup_display_config();
   } else if(!ereg("^[^\\\"']+$", $ndbname)) {
      $g_message = "setup failed: invalid database";
      setup_display_config();
   } else if(!ereg("^[^\\\"']+$", $ndirurl)) {
      $g_message = "setup failed: invalid sympoll url";
      setup_display_config();
   }

   /* make sure database settings work */
   if($ndbuser == "" && $ndbpass1 == "") {
      $link = @mysql_connect($ndbhost);
   } else if($ndbpass1 == "") {
      $link = @mysql_connect($ndbhost, $ndbuser);
   } else {
      $link = @mysql_connect($ndbhost, $ndbuser, $ndbpass1);
   }

   if(!$link) {
      $g_message = "setup failed: unable to connect to specified server";
      setup_display_config();
   }
   if(!@mysql_select_db($ndbname, $link)) {
      @mysql_close($link);
      $g_message = "setup failed: connected, but unable to access $ndbname"; 
      setup_display_config();
   }
   @mysql_close($link);

   /* get ready to write config file */
   $s_dbhost = $ndbhost;
   $s_dbuser = $ndbuser;
   $s_dbpass = $ndbpass1;
   $s_dbname = $ndbname;
   $s_dirurl = $ndirurl;
   $s_tx = 'black';
   $s_bg = '#c0c0c0';
   $s_bord = 'black';
   $s_qtx = 'black';
   $s_qbg = 'orange';
   $s_optsize = '1';
   $s_txtsize = '2';
   $s_txtface = 'Verdana,Geneva,Georgia,Arial';
   $s_width = '150';
   $s_barimg = 'blue.jpg';
   $s_barhite = '9';
   $s_maxopts = '12';
   $s_blength = '180';
   $s_iplog = '0';
   $s_cookielog = '1';
   $s_polllist = '1';
   $s_resultnums = '1';
   $s_showtotal = '1';
   $s_lang = 'english';
   $s_refer = '1';

   if(config_write() == FALSE) {
      $g_message = "setup failed: $g_message";
      setup_display_config();
   }
   header("Location: index.$ext");
}


function setup_display_dbtables($tbc) { 
   global $ext;

   spit_header(FALSE); ?>
   <div align="center"><font size="5" face="Verdana, Geneva">
   <b>Sympoll Setup: Database Tables</b></font></div><br /><br />
   <form action="index.<?php echo $ext; ?>" method="post">
   <input type="hidden" name="action" value="setup_p_dbtables" />
   <table border="0" cellspacing="0" align="center" width="95%">
   <tr><td><font size="2" face="Verdana, Geneva">

   It appears that you need to install one or more MySQL tables that Sympoll 
   will use to store its data.  In order for Sympoll to install and 
   operate properly, your MySQL user must have at least these privileges:
   <font size="3"><tt>SELECT, INSERT, UPDATE, DELETE, ALTER, CREATE, DROP</tt></font>
   <br /><br /><br />
   The following table(s) will be created: </font><ul>
   <?php while(is_array($tbc) && list($k,$v) = each($tbc)) { ?>
      <li><font size="2" face="Verdana, Geneva"><?php echo $v; ?></font></li>
   <?php } reset($tbc); ?>
   </ul>
   <input type="hidden" name="tbc_str" value="<?php echo urlencode(serialize($tbc)); ?>" />
   <br /><input type="submit" value="Continue" /><br />
   </td></tr></table></form>
   <?php spit_footer();
}


function setup_process_dbtables($tbc) { 
   global $ext, $s_dbid; 

   $oops = FALSE;
   spit_header(FALSE); ?>
   <div align="center"><font size="5" face="Verdana, Geneva">
   <b>Sympoll Setup: Database Tables</b></font></div><br /><br />
   <table border="0" cellspacing="0" align="center" width="95%">
   <tr><td><font size="2" face="Verdana, Geneva">

   <?php 
   $q['sympoll_data']  = "CREATE TABLE sympoll_data (pid INT UNSIGNED NOT NULL, ";
   $q['sympoll_data'] .= "cid INT UNSIGNED NOT NULL, choice VARCHAR(250) NOT NULL, ";
   $q['sympoll_data'] .= "votes INT UNSIGNED DEFAULT '0' NOT NULL, INDEX(pid))";

   $q['sympoll_list']  = "CREATE TABLE sympoll_list (pid INT UNSIGNED NOT NULL AUTO_INCREMENT, ";
   $q['sympoll_list'] .= "nextcid INT UNSIGNED DEFAULT '0' NOT NULL, question ";
   $q['sympoll_list'] .= "VARCHAR(250) NOT NULL, timeStamp INT UNSIGNED NOT NULL, cookieStamp ";
   $q['sympoll_list'] .= "INT UNSIGNED NOT NULL, status SMALLINT UNSIGNED NOT NULL, ";
   $q['sympoll_list'] .= "PRIMARY KEY (pid))";

   $q['sympoll_auth']  = "CREATE TABLE sympoll_auth (uid INT NOT NULL AUTO_INCREMENT, ";
   $q['sympoll_auth'] .= "user VARCHAR(32) NOT NULL, pass VARCHAR(32) NOT NULL, access ";
   $q['sympoll_auth'] .= "SMALLINT UNSIGNED NOT NULL, secret VARCHAR(32), PRIMARY KEY (uid))";

   $q['sympoll_iplog']  = "CREATE TABLE sympoll_iplog (vid VARCHAR(32) NOT NULL, ";
   $q['sympoll_iplog'] .= "pid INT UNSIGNED NOT NULL, voted INT UNSIGNED NOT NULL, ";
   $q['sympoll_iplog'] .= "INDEX (vid), INDEX (pid))";

   while(is_array($tbc) && list($k,$v) = each($tbc)) {
      if(!$oops) {
         echo "Creating table: $v ...";
         $r = mysql_query($q[$v], $s_dbid);

         if(!$r) { 
            $oops = TRUE; ?>
            <b>FAILED!</b> (lacking create permissions?)<br /><br /><br />
            A database table creation has failed.  You may manually create the
            table(s) described below, or you may attempt to fix your MySQL
            privileges problem and try again. The problem may be due to your
            MySQL user lacking the CREATE privilege.<br /><br /><br />
         <?php } else { ?>
            <b>done!</b><br />
         <?php } 
      }
      if($oops) { ?>
         <tt><?php echo "$q[$v]"; ?>;</tt><br /><br />
      <?php } ?>
   <?php }

   if(!$oops) { ?>
      <br /><br />Database Installation Completed Successfully! 
      &nbsp;&nbsp;<a href="index.<?php echo $ext; ?>">Continue</a>.
   <?php } ?>

   </font></td></tr></table>
   <?php spit_footer();
}


function upgrade_display_dbtables($tbu) {
   global $ext;

   spit_header(FALSE); ?>
   <div align="center"><font size="5" face="Verdana, Geneva">
   <b>Sympoll Setup: Database Tables</b></font></div><br /><br />
   <form action="index.<?php echo $ext; ?>" method="post">
   <input type="hidden" name="action" value="upgrade_p_dbtables" />
   <table border="0" cellspacing="0" align="center" width="95%">
   <tr><td><font size="2" face="Verdana, Geneva">

   It appears that you have recently upgraded Sympoll.  This message
   appears because the description of your database tables does not
   match the description that this version of Sympoll uses.  Therefore,
   you must upgrade your database tables.  This should be easy and painless,
   and no data should be lost unless noted in the UPGRADE file.  A file
   named UPGRADE should have come with your Sympoll package.  Please read
   that file before proceeding.  In order for Sympoll to upgrade and operate
   properly, your MySQL user must have at least these privileges:
   <font size="3"><tt>SELECT, INSERT, UPDATE, DELETE, ALTER, CREATE, DROP</tt></font>
   <br /><br /><br />

   The following table(s) will be upgraded: </font><ul>
   <?php while(is_array($tbu) && list($k,$v) = each($tbu)) { ?>
      <li><font size="2" face="Verdana, Geneva"><?php echo $v; ?></font></li>
   <?php } ?>
   </ul>

   <font size="2" face="Verdana, Geneva"><br />
   Upgrading <b>From</b> Version: <select name="gen">
   <option value="4">0.4.x</option>
   <option value="3">0.3.x</option>
   <option value="2">0.2.2 - 0.2.3</option>
   <option value="1">0.2.0 - 0.2.1</option>
   </select>&nbsp;&nbsp;&nbsp;
   <input type="submit" value="Continue" /><br />
   </font></td></tr></table></form>
   <?php spit_footer();
}


function upgrade_process_dbtables($gen) {
   global $ext;

   spit_header(FALSE); ?>
   <div align="center"><font size="5" face="Verdana, Geneva">
   <b>Sympoll Setup: Database Tables</b></font></div><br /><br />
   <table border="0" cellspacing="0" align="center" width="95%">
   <tr><td><font size="2" face="Verdana, Geneva">

   <?php switch($gen) {
      case 1:
         echo "<br /><b>(generation 1)</b><br />";
         upgrade_rename_col("sympoll_list", "pollID", "pid", "INT NOT NULL AUTO_INCREMENT");
         upgrade_rename_col("sympoll_data", "pollID", "pid", "INT NOT NULL");
         upgrade_rename_col("sympoll_data", "choiceID", "cid", "INT NOT NULL");
         upgrade_rename_col("sympoll_auth", "id", "uid", "INT NOT NULL AUTO_INCREMENT");
         addc_nextcid_symplist();
      case 2:
         echo "<br /><b>(generation 2)</b><br />";
         upgrade_rename_col("sympoll_auth", "user", "user", "VARCHAR(32) NOT NULL");
         upgrade_rename_col("sympoll_auth", "pass", "pass", "VARCHAR(32) NOT NULL");
         upgrade_purge_table("sympoll_auth"); 
      case 3:
         echo "<br /><b>(generation 3)</b><br />";
         upgrade_add_index("sympoll_data", "pid");
      case 4:
         echo "<br /><b>(generation 4)</b><br />";
         upgrade_delete_col("sympoll_list", "identifier");
         upgrade_rename_col("sympoll_data", "pid", "pid", "INT UNSIGNED NOT NULL");
         upgrade_rename_col("sympoll_data", "cid", "cid", "INT UNSIGNED NOT NULL");
         upgrade_rename_col("sympoll_data", "votes","votes", "INT UNSIGNED DEFAULT '0' NOT NULL");
         upgrade_rename_col("sympoll_list", "pid", "pid", "INT UNSIGNED NOT NULL AUTO_INCREMENT");
         upgrade_rename_col("sympoll_list", "timeStamp", "timeStamp", "INT UNSIGNED NOT NULL");
         upgrade_rename_col("sympoll_auth", "access", "access", "SMALLINT UNSIGNED NOT NULL");
         upgrade_rename_col("sympoll_iplog", "pid", "pid", "INT UNSIGNED NOT NULL");
         upgrade_rename_col("sympoll_iplog", "voted", "voted", "INT UNSIGNED NOT NULL");
         addc_cookiestamp_symplist();
         fixc_ip_sympiplog();
         fixc_status_symplist();
   } ?>

   <br /><br />Database Upgrade Completed Successfully!
   &nbsp;&nbsp;<a href="index.<?php echo $ext; ?>">Continue</a>.
   </font></td></tr></table>
   <?php spit_footer();
}


function addc_nextcid_symplist() {
   global $s_dbid, $s_dbname;

   /* make sure col doesn't exist */
   $fields = mysql_list_fields($s_dbname, "sympoll_list", $s_dbid);
   for ($i = 0; $i < mysql_num_fields($fields); $i++) {
      if(mysql_field_name($fields, $i) == "nextcid") {
         return;
      }
   } ?>

   Altering sympoll_list in <?php echo $s_dbname; ?>: adding 'nextcid'...
   <?php $q1 = "ALTER TABLE sympoll_list ADD nextcid INT UNSIGNED DEFAULT '0' NOT NULL AFTER identifier";
   $q2 = "SELECT pid FROM sympoll_list";
   $r1 = mysql_query($q1, $s_dbid) or die("<b>FAILED!</b> (lacking alter permissions?)<br />");
   $r2 = mysql_query($q2, $s_dbid);
   for($dsr = 0; $dsr < mysql_num_rows($r2); $dsr++) {
      $a2 = mysql_fetch_array($r2);
      $q3 = "SELECT MAX(cid)+1 AS nextc FROM sympoll_data WHERE pid='$a2[pid]'";
      $r3 = mysql_query($q3, $s_dbid);
      /* if update fails revert back */
      if(!$r3) {
         $q4 = "ALTER TABLE sympoll_list DROP nextcid";
         $r4 = mysql_query($q4, $s_dbid);
         die("<b>FAILED!</b> (unable to calculate nextcid?)<br />");
      }
      $a3 = mysql_fetch_array($r3);
      $q5 = "UPDATE sympoll_list SET nextcid='$a3[nextc]' WHERE pid='$a2[pid]'";
      $r5 = mysql_query($q5, $s_dbid);
      /* if update fails revert back */
      if(!$r5) {
         $q6 = "ALTER TABLE sympoll_list DROP nextcid";
         $r6 = mysql_query($q6, $s_dbid);
         die("<b>FAILED!</b> (lacking update permissions?)<br />");
      }
   } ?>
   <b>done!</b><br />
<?php }


function addc_cookiestamp_symplist() {
   global $s_dbid, $s_dbname;

   /* make sure col doesn't exist */
   $fields = mysql_list_fields($s_dbname, "sympoll_list", $s_dbid);
   for ($i = 0; $i < mysql_num_fields($fields); $i++) {
      if(mysql_field_name($fields, $i) == "cookieStamp") {
         return;
      }
   } ?>

   Altering sympoll_list in <?php echo $s_dbname; ?>: adding 'cookieStamp'...
   <?php $q1 = "ALTER TABLE sympoll_list ADD cookieStamp INT UNSIGNED NOT NULL AFTER timeStamp";
   $r1 = mysql_query($q1, $s_dbid) or die("<b>FAILED!</b> (lacking alter permissions?)<br />");
   $q2 = "UPDATE sympoll_list SET cookieStamp=timeStamp";
   $r2 = mysql_query($q2, $s_dbid);

   /* if update fails revert back */
   if(!$r2) {
      $q3 = "ALTER TABLE sympoll_list DROP cookieStamp";
      $r3 = mysql_query($q3, $s_dbid);
      die("<b>FAILED!</b> (lacking update permissions?)<br />");
   } ?>
   <b>done!</b><br />
<?php }


function fixc_ip_sympiplog() {
   global $s_dbid, $s_dbname;

   $fields = mysql_list_fields($s_dbname, "sympoll_iplog", $s_dbid);
   $has_old = FALSE; $has_new = FALSE;
   for($dsr = 0; $dsr < mysql_num_fields($fields); $dsr++) {
      $current = mysql_field_name($fields, $dsr);
      if($current == "ip") {
         $has_old = TRUE;
      }
      if($current == "vid") {
         $has_new = TRUE;
      }
   }
   /* rename already done? */
   if(!$has_old && $has_new) {
      return;
   } ?>

   Altering sympoll_iplog in <?php echo $s_dbname; ?>: fixing 'ip'...
   <?php /* check for problems */
   if(!$has_old) {
      die("<b>FAILED!</b> (ip does not exist?)<br />");
   }
   /* do rename */
   $q1 = "ALTER TABLE sympoll_iplog CHANGE ip vid VARCHAR(32) NOT NULL";
   $r1 = mysql_query($q1, $s_dbid) or die("<b>FAILED!</b> (lacking alter permissions?)<br />");

   /* do fix */
   $q2 = "UPDATE sympoll_iplog SET vid=MD5(vid)";
   $r2 = mysql_query($q2, $s_dbid);

   /* if update fails revert back */
   if(!$r2) {
      $q3 = "ALTER TABLE sympoll_iplog CHANGE vid ip VARCHAR(32) NOT NULL";
      $r3 = mysql_query($q3, $s_dbid);
      die("<b>FAILED!</b> (lacking update permissions?)<br />");
   } ?>

   <b>done!</b><br />
<?php }


function fixc_status_symplist() {
   global $s_dbid, $s_dbname, $S_VIEW_HIDDEN, $S_VIEW_OPEN, $S_TYPE_RADIO;

   $has_old = FALSE; 
   $q1 = "SHOW COLUMNS FROM sympoll_list";
   $r1 = mysql_query($q1, $s_dbid) or die("<b>FAILED!</b> (lacking permissions?)<br />"); 
   while ($a1 = mysql_fetch_array($r1)) {
      if($a1['Field'] == "status") {
         $has_old = TRUE;
         if(stristr($a1['Type'], "smallint")) {
            return;
         }
         break;
      }
   } ?>

   Altering sympoll_list in <?php echo $s_dbname; ?>: fixing 'status'...
   <?php /* check for problems */
   if(!$has_old) {
      die("<b>FAILED!</b> (status does not exist?)<br />");
   }

   $q2 = "ALTER TABLE sympoll_list CHANGE status status SMALLINT UNSIGNED NOT NULL";
   $r2 = mysql_query($q2, $s_dbid) or die("<b>FAILED!</b> (lacking alter permissions?)<br />");
   $new = $S_VIEW_OPEN + $S_TYPE_RADIO;
   $q3 = "UPDATE sympoll_list SET status='$new' WHERE status='1'";
   $r3 = mysql_query($q3, $s_dbid);
   if(!$r3) {
      $q5 = "ALTER TABLE sympoll_list CHANGE status status INT NOT NULL";
      $r5 = mysql_query($q5, $s_dbid);
      die("<b>FAILED!</b> (lacking update permissions?)<br />");
   }
   $new = $S_VIEW_HIDDEN + $S_TYPE_RADIO;
   $q4 = "UPDATE sympoll_list SET status='$new' WHERE status='0'";
   $r4 = mysql_query($q4, $s_dbid);
   ?> <b>done!</b><br />
<?php }


function upgrade_delete_col($tbl, $col) {
   global $s_dbid, $s_dbname;

   /* make sure col exists */
   $yummy = 0;
   $fields = mysql_list_fields($s_dbname, $tbl, $s_dbid);
   for($i = 0; $i < mysql_num_fields($fields); $i++) {
      if(mysql_field_name($fields, $i) == $col) {
         $yummy = 1;
      }
   }
   if($yummy == 0) {
      return;
   } ?>

   Altering <? echo $tbl; ?> in <?php echo $s_dbname; ?>: deleting '<?php echo $col; ?>'...
   <?php $q1 = "ALTER TABLE $tbl DROP $col";
   $r1 = mysql_query($q1, $s_dbid) or die("<b>FAILED!</b> (lacking alter permissions?)<br />"); ?>
   <b>done!</b><br />
<?php }


function upgrade_rename_col($tbl, $old, $new, $desc) {
   global $s_dbid, $s_dbname;

   $fields = mysql_list_fields($s_dbname, $tbl, $s_dbid);
   $has_old = FALSE; $has_new = FALSE;
   for($dsr = 0; $dsr < mysql_num_fields($fields); $dsr++) {
      $current = mysql_field_name($fields, $dsr);
      if($current == $old) {
         $has_old = TRUE;
      }
      if($current == $new) {
         $has_new = TRUE; 
      }
   } 
   /* rename already done? */
   if(!$has_old && $has_new) {
      return; 
   } ?>

   Altering <?php echo $tbl; ?> in <?php echo $s_dbname; ?>: renaming '<?php echo $old; ?>'...
   <?php /* check for problems */
   if(!$has_old) {
      die("<b>FAILED!</b> ("."$old"." does not exist?)<br />");
   }
   /* do rename */
   $q1 = "ALTER TABLE $tbl CHANGE $old $new $desc";
   $r1 = mysql_query($q1, $s_dbid) or die("<b>FAILED!</b> (lacking alter permissions?)<br />"); ?>
   <b>done!</b><br />
<?php }


function upgrade_purge_table($tbl) {
   global $s_dbid, $s_dbname; ?>

   Deleting from <?php echo $tbl; ?> in <?php echo $s_dbname; ?>: purging table...
   <?php $q1 = "DELETE FROM $tbl";
   $r1 = mysql_query($q1, $s_dbid) or die("<b>FAILED!</b> (lacking delete permissions?)<br />"); ?>
   <b>done!</b><br />
<?php }


function upgrade_add_index($tbl, $col) {
   global $s_dbid, $s_dbname;

   $has_col = FALSE;
   $q1 = "SHOW COLUMNS FROM $tbl";
   $r1 = mysql_query($q1, $s_dbid) or die("<b>FAILED!</b> (lacking permissions?)<br />");
   while ($a1 = mysql_fetch_array($r1)) {
      if($a1['Field'] == $col) {
         $has_col = TRUE;
         if(stristr($a1['Key'], "MUL")) {
            return;
         }
         break;
      }
   } ?>

   Altering <?php echo $tbl; ?> in <?php echo $s_dbname; ?>: indexing '<?php echo $col; ?>'...
   <?php /* check for problems */
   if(!$has_col) {
      die("<b>FAILED!</b> ($col does not exist?)<br />");
   }
   $q1 = "ALTER TABLE $tbl ADD INDEX($col)";
   $r1 = mysql_query($q1, $s_dbid) or die("<b>FAILED!</b> (lacking alter permissions?)<br />"); ?>
   <b>done!</b><br />
<?php }

?>
