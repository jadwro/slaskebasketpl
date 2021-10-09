<?php

###################################################################
## WRITES OUT FILE WITH CURRENT DATA
###################################################################
function config_write() {
   global $s_dbhost, $s_dbuser, $s_dbpass, $s_dbname, $s_dirurl, $s_tx, $s_bg,
   $s_bord, $s_iplog, $s_cookielog, $s_qtx, $s_qbg, $s_optsize, $s_txtsize,
   $s_txtface, $s_width, $s_barimg, $s_barhite, $s_maxopts, $s_blength,
   $s_refer, $s_polllist, $s_resultnums, $s_showtotal, $g_message, $ext,
   $symphome, $s_lang;

   /* data to write */
   $data =  "<?php\n";
   $data .= "# YOU DO NOT NEED TO EDIT THIS FILE!\n";
   $data .= "# USE THE ADMIN PAGE TO CHANGE OPTIONS\n";
   $data .= "\$s_dbhost = '$s_dbhost';\n";
   $data .= "\$s_dbuser = '$s_dbuser';\n";
   $data .= "\$s_dbpass = '$s_dbpass';\n";
   $data .= "\$s_dbname = '$s_dbname';\n";
   $data .= "\$s_dirurl = '$s_dirurl';\n";
   $data .= "\$s_bord = '$s_bord';\n";
   $data .= "\$s_tx = '$s_tx';\n";
   $data .= "\$s_qtx = '$s_qtx';\n";
   $data .= "\$s_bg = '$s_bg';\n";
   $data .= "\$s_qbg = '$s_qbg';\n";
   $data .= "\$s_optsize = '$s_optsize';\n";
   $data .= "\$s_txtsize = '$s_txtsize';\n";
   $data .= "\$s_txtface = '$s_txtface';\n";
   $data .= "\$s_width = '$s_width';\n";
   $data .= "\$s_barimg = '$s_barimg';\n";
   $data .= "\$s_barhite = '$s_barhite';\n";
   $data .= "\$s_maxopts = '$s_maxopts'; \n";
   $data .= "\$s_blength = '$s_blength';\n";
   $data .= "\$s_cookielog = '$s_cookielog';\n";
   $data .= "\$s_iplog = '$s_iplog';\n";
   $data .= "\$s_polllist = '$s_polllist';\n";
   $data .= "\$s_resultnums = '$s_resultnums';\n";
   $data .= "\$s_showtotal = '$s_showtotal';\n";
   $data .= "\$s_lang = '$s_lang';\n";
   if($s_refer == "" || $s_refer == "0") {
      $data .= "\$s_refer = '';\n";
   } else { 
      $data .= "\$s_refer = \"\$refer_href\".\"sympoll \".\"\$s_version\".\"</a>\";\n"; 
   }
   $data .= "?>\n";

   /* open and write and close file */
   $fp = @fopen("${symphome}/config.$ext", "w");
   if(!$fp) {
      $g_message = "error: cannot open config file for writing";
      return FALSE;
   }
   if(@fwrite($fp, $data) <= 0) {
      fclose($fp);
      $g_message = "error: cannot write config file; lacking permissions?";
      return FALSE;
   }
   fclose($fp);
   return TRUE;
}


###################################################################
## DISPLAYS HTML FOR DATABASE CONFIG
###################################################################
function display_config_db() {
   global $ext, $g_message, $title, $s_dbhost, $s_dbuser, $s_dbname;

   if(!verify_access(0)) {
      $g_message = "error: you are not the super user!";
      return;
   }
   $odbhost = htmlspecialchars($s_dbhost);
   $odbuser = htmlspecialchars($s_dbuser);
   $odbname = htmlspecialchars($s_dbname);

   $title = "configure database";
   spit_header(); ?>

   <form action="index.<?php echo $ext; ?>" method="post">
   <input type="hidden" name="action" value="config_p_db" />
   <table border="0" cellspacing="0" align="center" width="95%">
   <tr><td><font size="2" face="Verdana, Geneva">

   <b>WARNING:</b> If the database information is changed successfully, you
   will be logged out and will have to authenticate against the new database
   settings.<br />
   
   <br />Database Server:<br />&nbsp;&nbsp;
   <input type="text" maxlength="50" size="20" name="ndbhost" value="<?php echo $odbhost; ?>" />
   <br />Database Username:<br />&nbsp;&nbsp;
   <input type="text" maxlength="50" size="20" name="ndbuser" value="<?php echo $odbuser; ?>" />
   <br />Database Password:<br />&nbsp;&nbsp;
   <input type="password" maxlength="50" size="20" name="ndbpass1" />
   <br />Database Password Again:<br />&nbsp;&nbsp;
   <input type="password" maxlength="50" size="20" name="ndbpass2" />
   <br />Actual Database Name:<br />&nbsp;&nbsp;
   <input type="text" maxlength="50" size="20" name="ndbname" value="<?php echo $odbname; ?>" />

   <br /><br /><br /><input type="submit" value="Process Changes" /> &nbsp;
   <input type="reset" value="Undo Changes" /></font></td></tr></table></form>
   <?php spit_footer();
}


###################################################################
## DISPLAYS HTML FOR DISPLAY CONFIG
###################################################################
function display_config_disp() {
   global $ext, $g_message, $title, $s_tx, $s_bg, $s_bord, $s_qtx, $s_qbg,
   $s_width, $s_optsize, $s_txtsize, $s_txtface, $s_barimg, $s_barhite,
   $s_barimg_dir, $symphome;

   /* get the available images */
   $ind = 0;
   $iarr = array();
   if($dp = opendir("$symphome/$s_barimg_dir/")) {
      while($fp = readdir($dp)){
         if($fp == $s_barimg) {
            $iarr[$ind++] = "<option value=\"$fp\" selected=\"selected\">$fp</option>";
         } else if(substr($fp, 0, 1) != '.') {
            $iarr[$ind++] = "<option value=\"$fp\">$fp</option>";
         }
      }
      closedir($dp);
      sort($iarr);
   }

   if(!verify_access(0)) {
      $g_message = "error: you are not the super user!";
      return;
   }
   $otx = htmlspecialchars($s_tx);
   $obg = htmlspecialchars($s_bg);
   $obord = htmlspecialchars($s_bord);
   $oqtx = htmlspecialchars($s_qtx);
   $oqbg = htmlspecialchars($s_qbg);
   $ooptsize = htmlspecialchars($s_optsize);
   $otxtsize = htmlspecialchars($s_txtsize);
   $otxtface = htmlspecialchars($s_txtface);
   $owidth = htmlspecialchars($s_width);
   $obarhite = htmlspecialchars($s_barhite);

   $title = "configure display";
   spit_header(); ?>

   <form action="index.<?php echo $ext; ?>" method="post">
   <input type="hidden" name="action" value="config_p_disp" />
   <table border="0" cellspacing="0" align="center" width="95%">
   <tr><td><font size="2" face="Verdana, Geneva">

   <b>NOTE:</b> Colors used in the &quot;More Polls&quot; poll list can be
   controlled through the &lt;BODY&gt; tag in the customize/polllist/header.php file.<br /> 

   <br />Primary Text Color:<br />&nbsp;&nbsp;
   <input type="text" maxlength="30" size="30" name="ntx" value="<?php echo $otx; ?>" />
   <br />Primary Background Color:<br />&nbsp;&nbsp;
   <input type="text" maxlength="30" size="30" name="nbg" value="<?php echo $obg; ?>" />
   <br />Booth Question Text Color:<br />&nbsp;&nbsp;
   <input type="text" maxlength="30" size="30" name="nqtx" value="<?php echo $oqtx; ?>" />
   <br />Booth Question Background Color:<br />&nbsp;&nbsp;
   <input type="text" maxlength="30" size="30" name="nqbg" value="<?php echo $oqbg; ?>" />
   <br />Booth Border Color:<br />&nbsp;&nbsp;
   <input type="text" maxlength="30" size="30" name="nbord" value="<?php echo $obord; ?>" />
   <br />Booth Table Width:
   <font size="1">(number of pixels, not percentage)</font><br />&nbsp;&nbsp;
   <input type="text" maxlength="10" size="30" name="nwidth" value="<?php echo $owidth; ?>" />
   <br />Font Face:<br />&nbsp;&nbsp;
   <input type="text" maxlength="50" size="30" name="ntxtface" value="<?php echo $otxtface; ?>" />
   <br />Primary Font Size:<br />&nbsp;&nbsp;
   <input type="text" maxlength="5" size="30" name="ntxtsize" value="<?php echo $otxtsize; ?>" />
   <br />Options Font Size:<br />&nbsp;&nbsp;
   <input type="text" maxlength="5" size="30" name="noptsize" value="<?php echo $ooptsize; ?>" />
   <br />Results Bar Height:<br />&nbsp;&nbsp;
   <input type="text" maxlength="10" size="30" name="nbarhite" value="<?php echo $obarhite; ?>" />
   <br />Results Bar Image:<br />&nbsp;&nbsp;
   <select name="nbarimg">
   <?php while(list($k,$v) = each($iarr)) {
      echo "${v}\n";
   } ?>
   </select>


   <br /><br /><br /><input type="submit" value="Process Changes" /> &nbsp;
   <input type="reset" value="Undo Changes" /></font></td></tr></table></form>
   <?php spit_footer();
}


###################################################################
## DISPLAYS HTML FOR MISCELLANY CONFIG
###################################################################
function display_config_misc() {
   global $ext, $g_message, $title, $s_dirurl, $s_maxopts, $s_blength, 
   $s_iplog, $s_refer, $s_polllist, $s_resultnums, $s_showtotal, $s_cookielog,
   $s_lang, $symphome, $s_lang_dir;

   if(!verify_access(0)) {
      $g_message = "error: you are not the super user!";
      return;
   }

   /* get the available language packs */
   $ind = 0;
   $larr = array();
   $addc = 0;
   if($dp = opendir("$symphome/$s_lang_dir/")) {
      while($fp = readdir($dp)){
         /* this next line does:  file_name --> language_name */
         $ln = substr($fp, 0, strrpos($fp, '.'));
         if($ln == $s_lang && strtolower($ln) == "custom") {
            $c = $ln;
            $addc = 2;
         } else if(strtolower($ln) == "custom") {
            $c = $ln;
            $addc = 1;
         } else if($ln == $s_lang) {
            $larr[$ind++] = "<option value=\"$ln\" selected=\"selected\">".ucfirst(strtolower($ln))."</option>";
         } else if("$ln.$ext" == "$fp") {
            $larr[$ind++] = "<option value=\"$ln\">".ucfirst(strtolower($ln))."</option>";
         }
      }
      closedir($dp);
      sort($larr);
      if($addc == 1) {
         $larr[$ind++] = "<option value=\"$c\">&lt;custom&gt;</option>";
      } else if($addc == 2) {
         $larr[$ind++] = "<option selected=\"selected\" value=\"$c\">&lt;custom&gt;</option>";
      }
   }

   $odirurl = htmlspecialchars($s_dirurl);
   $omaxopts = htmlspecialchars($s_maxopts);
   $oblen = htmlspecialchars($s_blength);

   $title = "configure miscellany";
   spit_header(); ?>

   <form action="index.<?php echo $ext; ?>" method="post">
   <input type="hidden" name="action" value="config_p_misc" />
   <table border="0" cellspacing="0" align="center" width="95%">
   <tr><td><font size="2" face="Verdana, Geneva">

   Full URL to Sympoll directory:<br />&nbsp;&nbsp;
   <input type="text" maxlength="80" size="40" name="ndirurl" value="<?php echo $odirurl; ?>" />
   <br />Max options allowed in a poll:<br />&nbsp;&nbsp;
   <input type="text" maxlength="2" size="10" name="nmaxopts" value="<?php echo $omaxopts; ?>" />
   <br />Multiple votes blocked for: 
   <font size="1">(affects cookies <b>and</b> ip logging)</font><br />&nbsp;&nbsp;
   <input type="text" maxlength="4" size="10" name="nblen" value="<?php echo $oblen; ?>" />days

   <br />Language File:<br />&nbsp;&nbsp;
   <select name="nlang">
   <?php while(list($k,$v) = each($larr)) {
      echo "${v}\n";
   } ?>
   </select>

   <br />Log IP address to block multiple votes?<br />&nbsp;&nbsp;
   <select name="niplog">
   <?php if($s_iplog == "0") { ?>
      <option selected="selected" value="0">No</option>
      <option value="1">Yes</option>
   <?php } else { ?>
      <option value="0">No</option>
      <option selected="selected" value="1">Yes</option>
   <?php } ?>
   </select>

   <br />Set cookie to block multiple votes?<br />&nbsp;&nbsp;
   <select name="ncookielog">
   <?php if($s_cookielog == "0") { ?>
      <option selected="selected" value="0">No</option>
      <option value="1">Yes</option>
   <?php } else { ?>
      <option value="0">No</option>
      <option selected="selected" value="1">Yes</option>
   <?php } ?>
   </select>

   <br />Display referral link in poll list?<br />&nbsp;&nbsp;
   <select name="nrefer">
   <?php if($s_refer == "" || $s_refer == "0") { ?>
      <option selected="selected" value="0">No</option>
      <option value="1">Yes</option>
   <?php } else { ?>
      <option value="0">No</option>
      <option selected="selected" value="1">Yes</option>
   <?php } ?>
   </select>

   <br />Display 'More Polls' link in booth?<br />&nbsp;&nbsp;
   <select name="nplist">
   <?php if($s_polllist == "0") { ?>
      <option selected="selected" value="0">No</option>
      <option value="1">Yes</option>
   <?php } else { ?>
      <option value="0">No</option>
      <option selected="selected" value="1">Yes</option>
   <?php } ?>
   </select>

   <br />Display total vote count in results?<br />&nbsp;&nbsp;
   <select name="nstotal">
   <?php if($s_showtotal == "0") { ?>
      <option selected="selected" value="0">No</option>
      <option value="1">Yes</option>
   <?php } else { ?>
      <option value="0">No</option>
      <option selected="selected" value="1">Yes</option>
   <?php } ?>
   </select>

   <br />Display Results As:<br />&nbsp;&nbsp;
   <select name="nrnums">
   <?php if($s_resultnums == "0") { ?>
      <option selected="selected" value="0">Percentages</option>
      <option value="1">Vote Count</option>
   <?php } else { ?>
      <option value="0">Percentages</option>
      <option selected="selected" value="1">Vote Count</option>
   <?php } ?>
   </select>
  
   <br /><br /><br /><input type="submit" value="Process Changes" /> &nbsp;
   <input type="reset" value="Undo Changes" /></font></td></tr></table></form>
   <?php spit_footer();
}


###################################################################
## PROCESSES DATABASE CONFIG
###################################################################
function process_config_db($ndbhost, $ndbuser, $ndbpass1, $ndbpass2, $ndbname) {
   global $g_message, $s_dbid;

   if(!verify_access(0)) {
      $g_message = "error: you are not the super user!";
      return;
   }

   if(!ereg("^[^\\\"']+$", $ndbhost)) {
      $g_message = "configure database <b>failed</b>: invalid server";
      return;
   } else if(!ereg("^[^\\\"']*$", $ndbuser)) {
      $g_message = "configure database <b>failed</b>: invalid username";
      return;
   } else if(strcmp($ndbpass1, $ndbpass2) != 0) {
      $g_message = "configure database <b>failed</b>: passwords do not match";
      return;
   } else if(!ereg("^[^\\\"']*$", $ndbpass1) != 0) {
      $g_message = "configure database <b>failed</b>: invalid password";
      return;
   } else if(!ereg("^[^\\\"']+$", $ndbname)) {
      $g_message = "configure database <b>failed</b>: invalid database";
      return;
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
      $g_message = "configure database <b>failed</b>: unable to connect to new server"; 
      return;
   }
   if(!@mysql_select_db($ndbname, $link)) {
      if($link != $s_dbid) {
         @mysql_close($link);
      }
      $g_message = "configure database <b>failed</b>: connected, but unable to access $ndbname";
      return;
   }
   if($link != $s_dbid) {
      @mysql_close($link);
   }

   /* update values */
   global $s_dbhost, $s_dbuser, $s_dbpass, $s_dbname;
   $s_dbhost = $ndbhost;
   $s_dbuser = $ndbuser;
   $s_dbpass = $ndbpass1;
   $s_dbname = $ndbname;
   if(config_write() == TRUE) {
      $data = serialize(array());
      setcookie("sympauth", "$data");
      auth_display();
   }
}


###################################################################
## PROCESSES DISPLAY CONFIG
###################################################################
function process_config_disp($ntx, $nbg, $nbord, $nqtx, $nqbg, $noptsize,
      $ntxtsize, $ntxtface, $nwidth, $nbarimg, $nbarhite) {

   global $g_message;
   if(!verify_access(0)) {
      $g_message = "error: you are not the super user!";
      return;
   }

   if(!ereg("^[^\\\"']*$", $ntx)) {
      $g_message = "configure display <b>failed</b>: invalid text color";
      return;
   } else if(!ereg("^[^\\\"']*$", $nbg)) {
      $g_message = "configure display <b>failed</b>: invalid background color";
      return;
   } else if(!ereg("^[^\\\"']*$", $nqtx)) {
      $g_message = "configure display <b>failed</b>: invalid question text color";
      return;
   } else if(!ereg("^[^\\\"']*$", $nqbg)) {
      $g_message = "configure display <b>failed</b>: invalid question background color";
      return;
   } else if(!ereg("^[^\\\"']*$", $nbord)) {
      $g_message = "configure display <b>failed</b>: invalid border color";
      return;
   } else if(!ereg("^[0-9]+$", $nwidth)) {
      $g_message = "configure display <b>failed</b>: invalid table width";
      return;
   } else if(!ereg("^[^\\\"']*$", $ntxtface)) {
      $g_message = "configure display <b>failed</b>: invalid text font face";
      return;
   } else if(!ereg("^(([+-][0-9]+)|([0-9]*))$", $ntxtsize)) {
      $g_message = "configure display <b>failed</b>: invalid text font size";
      return;
   } else if(!ereg("^(([+-][0-9]+)|([0-9]*))$", $noptsize)) {
      $g_message = "configure display <b>failed</b>: invalid options font size";
      return;
   } else if(!ereg("^[0-9]+$", $nbarhite)) {
      $g_message = "configure display <b>failed</b>: invalid results bar height";
      return;
   }
 
   /* update values */
   global $s_tx, $s_bg, $s_bord, $s_qtx, $s_qbg, $s_width, $s_optsize,
   $s_txtsize, $s_txtface, $s_barimg, $s_barhite;

   $s_tx = $ntx;
   $s_bg = $nbg;
   $s_bord = $nbord;
   $s_qtx = $nqtx;
   $s_qbg = $nqbg;
   $s_width = $nwidth;
   $s_txtface = $ntxtface;
   $s_txtsize = $ntxtsize;
   $s_optsize = $noptsize;
   $s_barimg = $nbarimg;
   $s_barhite = $nbarhite;
   if(config_write() == TRUE) {
      $g_message = "display successfully configured";
   }
}


###################################################################
## PROCESSES MISC CONFIG
###################################################################
function process_config_misc($ndirurl, $nmaxopts, $nblen, $nlang, $nrefer,
      $nplist, $nrnums, $nstotal, $niplog, $ncookielog) {

   global $g_message;
   if(!verify_access(0)) {
      $g_message = "error: you are not the super user!";
      return;
   }

   if(!ereg("^[^\\\"']+$", $ndirurl)) {
      $g_message = "configure miscellany <b>failed</b>: invalid url path";
      return;
   } else if(!ereg("^[0-9]+$", $nmaxopts)) {
      $g_message = "configure miscellany <b>failed</b>: invalid max options";
      return;
   } else if(!ereg("^[0-9]*$", $nblen)) {
      $g_message = "configure miscellany <b>failed</b>: invalid blocked length";
      return;
   }

   /* some more simple checks */
   if(substr($ndirurl, -1) != "/") {
      $ndirurl .= "/"; 
   }
   if($nblen == "") {
      $nblen = 0; 
   }

   /* update values */
   global $s_dirurl, $s_maxopts, $s_blength, $s_refer, $s_cookielog, 
   $s_polllist, $s_resultnums, $s_showtotal, $s_iplog, $s_lang;

   $s_dirurl = $ndirurl;
   $s_maxopts = $nmaxopts;
   $s_blength = $nblen;
   $s_lang = $nlang;
   $s_iplog = $niplog;
   $s_refer = $nrefer;
   $s_polllist = $nplist;
   $s_resultnums = $nrnums;
   $s_showtotal = $nstotal;
   $s_cookielog = $ncookielog;
   if(config_write() == TRUE) {
      $g_message = "miscellany successfully configured"; 
   }
}

?>
