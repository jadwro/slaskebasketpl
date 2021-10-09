<?php

###################################################################
## DISPLAYS POLL INFORMATION
###################################################################
function display_view($pid) {
   global $ext, $title, $symphome;

   $p = symp_poll_fetch($pid);
   $boothlocale = "${symphome}/booth.$ext";

   $title = "view poll";
   spit_header(); ?>

   <table border="0" cellspacing="0" align="center" width="95%">
   <tr><td><font size="2" face="Verdana, Geneva">

   <br /><br /><b>Question:</b><br />&nbsp;&nbsp;<?php echo "$p[question]"; ?>

   <br /><br /><b>Choices:</b>
   <?php $dsr = 1;
   while(is_array($p['options']) && list($k,$v) = each($p['options'])) { ?>
      <br />&nbsp;&nbsp;Option <?php printf("%02d", $dsr++); ?>:
      <?php echo $v; ?>
      <font size="1">[<?php echo $p['votes'][$k]; ?> votes]</font>
   <?php } ?>

   <br /><br />
   <b>To embed this poll into a webpage, use this code:</b><br />
   <font size="3"><code>
   &nbsp;&nbsp;&lt;?php require '<?php echo $boothlocale; ?>';<br />
   &nbsp;&nbsp;display_booth(<?php echo $pid; ?>); ?&gt;</code>
   <?php if(!is_file($boothlocale)) { ?>
      <br /><br />
      <b>WARNING:</b> above path seems incorrect!<br />
   <?php } ?>
   </font></font></td></tr></table>
   <?php spit_footer();
}


###################################################################
## DISPLAYS FORM USED TO CREATE POLLS
###################################################################
function display_create() {
   global $ext, $s_maxopts, $title, $S_VIEW_HIDDEN, $S_VIEW_OPEN, $S_VIEW_CLOSED,
   $S_TYPE_RADIO, $S_TYPE_CHECK;

   $title = "create poll";
   spit_header(); ?>

   <form action="index.<?php echo $ext; ?>" method="post">
   <input type="hidden" name="action" value="polls_p_create" />
   <table border="0" cellspacing="0" align="center" width="95%">

   <tr><td colspan="2"><font size="2" face="Verdana, Geneva">
   <b>Status</b>: <select name="view">
   <option value="<?php echo $S_VIEW_HIDDEN; ?>" selected="selected">hidden</option>
   <option value="<?php echo $S_VIEW_OPEN; ?>">open</option>
   <option value="<?php echo $S_VIEW_CLOSED; ?>">closed</option>
   </select>;&nbsp;&nbsp;&nbsp;&nbsp;<b>Type</b>: allow <select name="type">
   <option value="<?php echo $S_TYPE_RADIO; ?>" selected="selected">one option</option>
   <option value="<?php echo $S_TYPE_CHECK; ?>">numerous options</option>
   </select> per vote</font><br /><br /></td></tr>

   <tr><td width="80"><font size="2" face="Verdana, Geneva">
   Question:</font></td><td>
   <input type="text" maxlength="150" size="63" name="question" />
   </td></tr>

   <tr><td colspan="2">&nbsp;</td></tr>

   <?php for($dsr=1; $dsr <= $s_maxopts; $dsr++) {
      $n = "newo[$dsr]"; ?>
      <tr><td width="80"><font size="2" face="Verdana, Geneva">
      Option <?php printf("%02d", $dsr); ?>:</font></td><td>
      <input type="text" name="<?php echo $n; ?>" maxlength="100" size="50" />
      </td></tr>
   <?php } ?>

   <tr><td colspan="2"><font size="2" face="Verdana, Geneva">
   <br /><br /><input type="submit" value="Create Poll" /> &nbsp;
   <input type="reset" value="Clear Values" />
   </font></td></tr></table></form>
   <?php spit_footer();
}


###################################################################
## DISPLAYS FORM USED TO EDIT POLLS
###################################################################
function display_edit($pid) {
   global $s_maxopts, $ext, $title, $S_VIEW_HIDDEN, $S_VIEW_OPEN, $S_VIEW_CLOSED,
   $S_TYPE_RADIO, $S_TYPE_CHECK;

   $p = symp_poll_fetch($pid);
   $title = "edit poll";
   spit_header(); ?>

   <form action="index.<?php echo $ext; ?>" method="post">
   <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
   <input type="hidden" name="action" value="polls_p_edit" />
   <table border="0" cellspacing="0" align="center" width="95%">

   <tr><td colspan="2"><font size="2" face="Verdana, Geneva">
   <b>Status</b>: <select name="view">
   <?php if($p['status'] & $S_VIEW_OPEN) { ?>
      <option value="<?php echo $S_VIEW_HIDDEN; ?>">hidden</option>
      <option value="<?php echo $S_VIEW_OPEN; ?>" selected="selected">open</option>
      <option value="<?php echo $S_VIEW_CLOSED; ?>">closed</option>
   <?php } else if($p['status'] & $S_VIEW_CLOSED) { ?>
      <option value="<?php echo $S_VIEW_HIDDEN; ?>">hidden</option>
      <option value="<?php echo $S_VIEW_OPEN; ?>">open</option>
      <option value="<?php echo $S_VIEW_CLOSED; ?>" selected="selected">closed</option>
   <?php } else { ?>
      <option value="<?php echo $S_VIEW_HIDDEN; ?>" selected="selected">hidden</option>
      <option value="<?php echo $S_VIEW_OPEN; ?>">open</option>
      <option value="<?php echo $S_VIEW_CLOSED; ?>">closed</option>
   <?php } ?>
   </select>;&nbsp;&nbsp;&nbsp;&nbsp;<b>Type</b>: allow <select name="type">
   <?php if($p['status'] & $S_TYPE_CHECK) { ?>
      <option value="<?php echo $S_TYPE_RADIO; ?>">one option</option>
      <option value="<?php echo $S_TYPE_CHECK; ?>" selected="selected">numerous options</option>
   <?php } else { ?>
      <option value="<?php echo $S_TYPE_RADIO; ?>" selected="selected">one option</option>
      <option value="<?php echo $S_TYPE_CHECK; ?>">numerous options</option>
   <?php } ?>
   </select> per vote</font><br /><br /></td></tr>

   <tr><td width="80"><font size="2" face="Verdana, Geneva">
   Question:</font></td><td>
   <input type="text" maxlength="150" size="63" name="question" value="<?php echo "$p[question]"; ?>" />
   </td></tr>

   <?php $dsr = 1;
   while(is_array($p['options']) && list($k,$v) = each($p['options'])) { ?>
      <tr><td width="80"><font size="2" face="Verdana, Geneva">
      Option <?php printf("%02d", $dsr++); ?>:</font></td><td>
      <input type="text" name="updateo[<?php echo $k; ?>]" maxlength="100" size="50" value="<?php echo $v; ?>" />
      &nbsp;&nbsp;
      <input type="checkbox" name="deleteo[<?php echo $k; ?>]" value="poof" />delete
      </td></tr>
   <?php } ?>

   <tr><td colspan="2"><font size="2" face="Verdana, Geneva">
   <br /><b>Add These Options:</b></font></td></tr>
   <?php $left = ($s_maxopts - $dsr) + $p['nextcid'];
   for($x=$p['nextcid']; $x <= $left; $x++) { ?>
      <tr><td width="80"><font size="2" face="Verdana, Geneva">
      Option <?php printf("%02d", $dsr++); ?>:</font></td><td>
      <input type="text" name="newo[<?php echo $x; ?>]" maxlength="100" size="50" />
      </td></tr>
   <?php } ?>


   <tr><td colspan="2"><font size="2" face="Verdana, Geneva">
   <br /><br /><input type="submit" value="Process Changes" /> &nbsp;
   <input type="reset" value="Undo Changes" />
   </font></td></tr></table></form>
   <?php spit_footer();
}


###################################################################
## DISPLAYS FORM USED FOR DELETE/RESET CONFIRMATION
###################################################################
function display_del_rs($pid, $action) {
   global $ext, $title;

   if($action == 'polls_d_reset') { 
      $act = 'reset'; 
   } else {
      $act = 'delete';
   }
   $p = symp_poll_fetch($pid);
   $title = "$act"." poll";
   spit_header(); ?>

   <form action="index.<?php echo $ext; ?>" method="post">
   <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
   <input type="hidden" name="action" value="polls_p_<?php echo $act; ?>" />
   <table border="0" cellspacing="0" align="center" width="95%">
   <tr><td><font size="2" face="Verdana, Geneva">

   <b>WARNING:  This Cannot Be Undone</b><br /><br />
   Poll # <?php echo "$p[pid]".": $p[question]"; ?><br /><br />

   Are you sure that you want to <b><?php echo $act; ?></b> this poll?<br /><br />
   <input type="radio" name="confirmation" value="no" checked="checked" />no!
   &nbsp;&nbsp;&nbsp;
   <input type="radio" name="confirmation" value="<?php echo $act; ?>" />yes

   <br /><br /><input type="submit" value="Continue" />
   </font></td></tr></table></form>
   <?php spit_footer();
}


###################################################################
## DISPLAYS LOGGING INFORMATION
###################################################################
function display_log($pid) {
   global $ext, $s_dbid, $g_message, $title, $s_iplog, $s_cookielog;

   if(!verify_access(0)) {
      $g_message = "error: you are not the super user!";
      return;
   }

   /* get ip log stuff for this poll */
   if($s_iplog != "0") {
      $q1 = "SELECT vid,voted FROM sympoll_iplog WHERE(pid='$pid') ORDER BY voted DESC";
      $r1 = mysql_query($q1, $s_dbid);
      $q2 = "SELECT vid,COUNT(pid) AS count FROM sympoll_iplog GROUP BY vid";
      $r2 = mysql_query($q2, $s_dbid);
      while($a2 = mysql_fetch_array($r2)) {
         $vid = $a2['vid'];
         $votecount[$vid] = $a2['count'];
      }
      $avgtop = 0;
      $prev = 0;
      $entries = mysql_num_rows($r1);
      for($dsr = 0; $a1 = mysql_fetch_array($r1); $dsr++) {
         $vid = $a1['vid'];
         $data[$dsr]['vid'] = $vid;
         $data[$dsr]['date'] = strftime("%d-%b-%Y %H:%M", $a1['voted']);
         $data[$dsr]['count'] = $votecount[$vid];
         if($prev > 0) {
            $avgtop += $prev - $a1['voted'];
         }
         $prev = $a1['voted'];
      }
      if($entries > 1) {
         $timebase = round($avgtop / ($entries - 1));
         $timeavg[0] = floor($timebase / 3600);
         $timeavg[1] = floor( ($timebase - ($timeavg[0] * 3600)) / 60);
         $timeavg[2] = $timebase - ($timeavg[0] * 3600) - ($timeavg[1] * 60);
      }
   }

   $colorrow = FALSE;
   $p = symp_poll_fetch($pid);
   $title = "poll logging";
   spit_header(); ?>

   <form action="index.<?php echo $ext; ?>" method="post">
   <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
   <input type="hidden" name="action" value="polls_p_log" />
   <table border="0" cellspacing="0" cellpadding="1" align="center" width="95%">

   <tr><td colspan="3"><font size="2" face="Verdana, Geneva">
   <b>WARNING:  This Cannot Be Undone</b><br /><br />
   Poll # <?php echo "$p[pid]".": $p[question]"; ?><br /><br />

   <input type="checkbox" name="purgecookie" value="poof" />
   Reset cookie log for this poll <b>without</b> altering number of votes
   <?php if($s_cookielog == "0") { ?>
      <font size="1">(cookie logging currently <b>disabled</b>)</font>
   <?php } else { ?>
      <font size="1">(cookie logging currently <b>enabled</b>)</font>
   <?php } ?>
   <br />
   
   <input type="checkbox" name="purgeip" value="poof" />
   Reset IP address log for this poll <b>without</b> altering number of votes
   <?php if($s_iplog == "0") { ?>
      <font size="1">(ip address logging currently <b>disabled</b>)</font>
   <?php } else { ?>
      <font size="1">(ip address logging currently <b>enabled</b>)</font>
   <?php } ?>
   <br /><br /><input type="submit" value="Continue" style="font-size: 10px"  />
   
   </font></td></tr>
   <?php if($s_iplog != "0") { ?>
      <tr><td colspan="3" valign="top" align="left">
      <hr size="1" width="100%" />
      <font size="2" face="Verdana, Geneva">
      <?php if($entries > 0) {
         echo "$entries"; ?>
         vote(s) occured in this poll while IP address logging is enabled.
      <?php }
      if(isset($timeavg)) { ?>
         The average time that elapsed between each vote for this poll is
         <?php printf("%02d:%02d:%02d.", $timeavg[0], $timeavg[1], $timeavg[2]); ?>
      <?php } ?>
      <br /></font></td></tr><tr><td valign="top" align="left" nowrap="nowrap">
      <font size="1" face="Verdana, Geneva"><b>date</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      </font></td><td valign="top" align="left" nowrap="nowrap">
      <font size="1" face="Verdana, Geneva"><b>voter id</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      </font></td><td valign="top" align="left" width="100%">
      <font size="1" face="Verdana, Geneva"><b>notes</b></font></td></tr>
   
      <?php if(!isset($data)) { ?>
         <tr><td bgcolor="#00bbbb" valign="top" align="left" colspan="3"> 
         <font size="1" face="Verdana, Geneva">
         there are currently no logged votes for this poll
         <br /></font></td></tr>
      <?php } else while(list($k,$v) = each($data)) {
         $tdbg = " bgcolor=\"#00bbbb\"";
         if($colorrow) {
            $tdbg = " bgcolor=\"#00cccc\"";
         } ?>
         <tr><td<?php echo $tdbg; ?> valign="top" align="left" nowrap="nowrap">
         <font size="1" face="Verdana, Geneva">
         <?php echo $v['date']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         </font></td><td<?php echo $tdbg; ?> valign="top" align="left" nowrap="nowrap">
         <font size="1" face="Verdana, Geneva">
         <?php echo $v['vid']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         </font></td><td<?php echo $tdbg; ?> valign="top" align="left" width="100%">
         <font size="1" face="Verdana, Geneva">
         This person has voted in <?php echo $v['count']; ?> poll(s).
         </font></td></tr>
         <?php $colorrow = !$colorrow;
      }
   } ?>

   </table></form>
   <?php spit_footer();
}


###################################################################
## PROCESSES CREATE ACTION
###################################################################
function process_create($question, $view, $type, $newo) {
   global $g_message, $s_dbid;

   if($question == "") {
      $g_message = "poll creation <b>failed</b>: invalid question";
      return;
   }
   $question = addslashes($question);
   $status = $view + $type;

   /* insert poll info */
   $time = time();
   $q1 = "INSERT INTO sympoll_list VALUES(NULL, 0, '$question', '$time', '$time', '$status')";
   $r1 = mysql_query($q1, $s_dbid);
   $q2 = "SELECT pid FROM sympoll_list WHERE(timeStamp='$time')";
   $r2 = mysql_query($q2, $s_dbid);
   $a2 = mysql_fetch_array($r2);

   /* insert and count options */
   $maxcid = -1;
   while(isset($newo) && list($k,$v) = each($newo)) {
      if(trim($v) != "") {
         $v = addslashes($v);
         $q3 = "INSERT INTO sympoll_data VALUES('$a2[pid]', '$k', '$v', 0)";
         $r3 = mysql_query($q3, $s_dbid);
         if($k > $maxcid)  {
            $maxcid = $k; 
         }
      }
   }

   /* update correct value for nextcid */
   $maxcid++;
   $q4 = "UPDATE sympoll_list SET nextcid='$maxcid' WHERE pid='$a2[pid]'";
   $r4 = mysql_query($q4, $s_dbid);

   display_view($a2['pid']);
}


###################################################################
## PROCESSES EDIT ACTION
###################################################################
function process_edit($pid, $question, $view, $type, $newo, $updateo, $deleteo) {
   global $g_message, $s_dbid;

   if($question == "") {
      $g_message = "poll edit <b>failed</b>: invalid question";
      return;
   }
   $question = addslashes($question);
   $status = $view + $type;

   /* update the question */
   $q1 = "UPDATE sympoll_list SET question='$question',status='$status' WHERE(pid='$pid')";
   $r1 = mysql_query($q1, $s_dbid);

   /* add options */
   $maxcid = -1;
   while(isset($newo) && list($k,$v) = each($newo)) {
      if(trim($v) != "") {
         $v = addslashes($v);
         $q2 = "INSERT INTO sympoll_data VALUES('$pid', '$k', '$v', 0)";
         $r2 = mysql_query($q2, $s_dbid);
         if($k > $maxcid)  {
            $maxcid = $k; 
         }
      }
   }

   /* update nextcid */
   if($maxcid > -1) {
      $maxcid++;
      $q3 = "UPDATE sympoll_list SET nextcid='$maxcid' WHERE(pid='$pid')";
      $r3 = mysql_query($q3, $s_dbid);
   }

   /* update options */
   while(isset($updateo) && list($k,$v) = each($updateo)) {
      if(trim($v) != "") {
         $v = addslashes($v);
         $q4 = "UPDATE sympoll_data SET choice='$v' WHERE(pid='$pid' AND cid='$k')";
         $r4 = mysql_query($q4, $s_dbid);
      }
   }

   /* delete options */
   while(isset($deleteo) && list($k,$v) = each($deleteo)) {
      if($v == 'poof') {
         $q5 = "DELETE FROM sympoll_data WHERE(pid='$pid' AND cid='$k')";
         $r5 = mysql_query($q5, $s_dbid);
      }
   }

   display_view($pid);
}


###################################################################
## PROCESSES DELETE/RESET ACTION
###################################################################
function process_del_rs($pid, $confirmation) {
   global $g_message, $s_dbid;

   if($confirmation == 'delete') {
      $q1 = "DELETE FROM sympoll_list WHERE(pid='$pid')";
      $r1 = mysql_query($q1, $s_dbid);
      $q2 = "DELETE FROM sympoll_data WHERE(pid='$pid')";
      $r2 = mysql_query($q2, $s_dbid);
      $q3 = "DELETE FROM sympoll_iplog WHERE(pid='$pid')";
      $r3 = mysql_query($q3, $s_dbid);
      $g_message = "Poll #$pid deleted";
   } else if($confirmation == 'reset') {
      $time = time();
      $q4 = "UPDATE sympoll_list SET cookieStamp='$time' WHERE(pid='$pid')";
      $r4 = mysql_query($q4, $s_dbid);
      $q5 = "UPDATE sympoll_data SET votes='0' WHERE(pid='$pid')";
      $r5 = mysql_query($q5, $s_dbid);
      $q6 = "DELETE FROM sympoll_iplog WHERE(pid='$pid')";
      $r6 = mysql_query($q6, $s_dbid);
      $g_message = "Poll #$pid reset";
   } else {
      $g_message = "Poll #$pid <b>not</b> modified"; 
   }
}

###################################################################
## PROCESS LOGGING ACTION
###################################################################
function process_log($pid, $purgecookie, $purgeip) {
   global $g_message, $s_dbid;

   if($purgecookie == 'poof' && $purgeip == 'poof') {
      $g_message = "Cookie log and IP address log reset for Poll #${pid}";
   }
   if($purgecookie == 'poof') {
      $time = time();
      $q1 = "UPDATE sympoll_list SET cookieStamp='$time' WHERE(pid='$pid')";
      $r1 = mysql_query($q1, $s_dbid);
      if(!isset($g_message) || $g_message == "") {
         $g_message = "Cookie log reset for Poll #${pid}";
      }
   }
   if($purgeip == 'poof') {
      $q2 = "DELETE FROM sympoll_iplog WHERE(pid='$pid')";
      $r2 = mysql_query($q2, $s_dbid);
      if(!isset($g_message) || $g_message == "") {
         $g_message = "IP address log reset for Poll #${pid}";
      }
   }
   if(!isset($g_message) || $g_message == "") {
      $g_message = "Logs for Poll #$pid <b>not</b> modified"; 
   }
}

?>
