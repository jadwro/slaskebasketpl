<?php

/* file extension */
$ext = substr(__FILE__, strrpos(__FILE__, ".") + 1);

if(!function_exists('symp_poll_fetch')) {
   /* incase register_globals is disabled.. */
   if(!isset($_GET) && isset($HTTP_GET_VARS)) {
      $_GET = $HTTP_GET_VARS;
   }
   if(!isset($_COOKIE) && isset($HTTP_COOKIE_VARS)) {
      $_COOKIE = $HTTP_COOKIE_VARS;
   }
   if(!isset($_SERVER) && isset($HTTP_SERVER_VARS)) {
      $_SERVER = $HTTP_SERVER_VARS;
   }
   /* some servers put things in $_ENV that others put in $_SERVER */
   if(isset($_ENV) && is_array($_ENV)) {
      while(list($k,$v) = each($_ENV)) {
         if(!isset($_SERVER[$k]) || $_SERVER[$k] == "") { $_SERVER[$k] = $v; }
      }
   } else if(isset($HTTP_ENV_VARS) && is_array($HTTP_ENV_VARS)) {
      while(list($k,$v) = each($HTTP_ENV_VARS)) {
         if(!isset($_SERVER[$k]) || $_SERVER[$k] == "") { $_SERVER[$k] = $v; }
      }
   }
   if(isset($_POST) && is_array($_POST)) {
      extract($_POST, EXTR_OVERWRITE);
   } else if(isset($HTTP_POST_VARS) && is_array($HTTP_POST_VARS)) {
      extract($HTTP_POST_VARS, EXTR_OVERWRITE);
   }

   /* fix up our cookie arrays and don't trust integrity */
   if(isset($_COOKIE['sympvotes'])) { 
      $sympvotes = unserialize(stripslashes($_COOKIE['sympvotes'])); 
      while(is_array($sympvotes) && list($k,$v) = each($sympvotes)) {
         $sympvotes[$k] = addslashes($v);
      }
   }
   if(isset($_COOKIE['sympauth'])) { 
      $sympauth = unserialize(stripslashes($_COOKIE['sympauth'])); 
   }

   /* make sure query_string is set after an ssi */
   if(!isset($_SERVER['QUERY_STRING']) || $_SERVER['QUERY_STRING'] == "") {
      if(isset($_SERVER['QUERY_STRING_UNESCAPED'])) {
         $_SERVER['QUERY_STRING'] = str_replace("\\","",$_SERVER['QUERY_STRING_UNESCAPED']);
         parse_str($_SERVER['QUERY_STRING']);
      } else {
         $_SERVER['QUERY_STRING'] = "";
      }
   }

   /* include config info and format display variables */
   $s_version = '1.4';
   $refer_href = '<a href="http://www.ralusp.net/sympoll/">';
   $s_lang_dir = "customize/language";
   $s_barimg_dir = "customize/bar_imgs";
   $s_polllist_dir = "customize/polllist";

   require dirname(__FILE__)."/config.$ext";
   if(isset($s_lang) && file_exists(dirname(__FILE__)."/$s_lang_dir/$s_lang.$ext")) {
      require dirname(__FILE__)."/$s_lang_dir/$s_lang.$ext";
   } else {
      require dirname(__FILE__)."/$s_lang_dir/english.$ext";
   }
   if(!isset($_SympAdmin) || !$_SympAdmin) {
      if($s_bord != "") {
         $s_bord = "border: 1px solid $s_bord; ";
      }
      if($s_tx != "") {
         $s_tx = " color=\"$s_tx\"";
      }
      if($s_qtx != "") {
         $s_qtx = " color=\"$s_qtx\"";
      }
      if($s_bg != "") {
         $s_bg = " bgcolor=\"$s_bg\"";
      }
      if($s_qbg != "") {
         $s_qbg = " bgcolor=\"$s_qbg\"";
      }
      if($s_optsize != "") {
         $s_optsize = " size=\"$s_optsize\"";
      }
      if($s_txtsize != "") {
         $s_txtsize = " size=\"$s_txtsize\"";
      }
      if($s_txtface != "") {
         $s_txtface = " face=\"$s_txtface\"";
      }
   }

   /* status types, powers of 2 */
   $S_VIEW_HIDDEN = 1;
   $S_VIEW_OPEN = 2;
   $S_VIEW_CLOSED = 4;
   $S_TYPE_RADIO = 8;
   $S_TYPE_CHECK = 16;

   ### SET SYMP_URL FOR HIGHEST POSSIBLE COMPATIBILITY ###
   if(!isset($SYMP_URL) || $SYMP_URL == "") {
      $SYMP_URL = "";
      if(isset($s_dirurl)) { 
         $purl = parse_url($s_dirurl);
      }

      /* path,first check for cgi on php4 */
      if(function_exists('php_sapi_name') && (php_sapi_name() == "cgi") &&
            isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] != "") { 
         $SYMP_URL = $_SERVER['PATH_INFO']; 
         $cgi4 = TRUE;
      } /* path,second try redirect_url for proxies */
      else if(isset($_SERVER['REDIRECT_URL']) && $_SERVER['REDIRECT_URL'] != "") { 
         $SYMP_URL = $_SERVER['REDIRECT_URL'];
      } /* path,third try request_uri */
      else if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != "") {
         if($pos = strpos($_SERVER['REQUEST_URI'], "?")) {
            $SYMP_URL = substr($_SERVER['REQUEST_URI'], 0, $pos);
         } else {
            $SYMP_URL = $_SERVER['REQUEST_URI'];
         }
      } /* path,fourth try document_uri for shtml */
      else if(isset($_SERVER['DOCUMENT_URI']) && $_SERVER['DOCUMENT_URI'] != "") {
         $SYMP_URL = $_SERVER['DOCUMENT_URI'];
      } /* path,fifth default to php_self */
      else if(isset($_SERVER['PHP_SELF']) && $_SERVER['PHP_SELF'] != "") {
         $SYMP_URL = $_SERVER['PHP_SELF'];
      }
      /* path, check for cgi in php3, switch to path_info */
      $prolly_cgi = ereg("^([^.?]+\\?)?([^/]+\\.[^/]+)?/", strrev($SYMP_URL));
      if(!isset($cgi4) && (stristr($SYMP_URL, "php.exe") || $prolly_cgi) &&
            (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] != "")) {
         $SYMP_URL = $_SERVER['PATH_INFO'];
      }
      /* add filename if necessary */
      if(substr($SYMP_URL, -1) == "/" &&
            isset($_SERVER['DOCUMENT_NAME']) && $_SERVER['DOCUMENT_NAME'] != "") { 
         $SYMP_URL = "$SYMP_URL$_SERVER[DOCUMENT_NAME]";
      }

      /* port,first check config file */
      if(isset($purl['port']) && $purl['port'] != "") {
         $SYMP_URL = ":"."$purl[port]$SYMP_URL";
      } /* port,second try SERVER_PORT if not 80 */
      else if(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != "" &&
            $_SERVER['SERVER_PORT'] != "80") {
         $SYMP_URL = ":"."$_SERVER[SERVER_PORT]$SYMP_URL";
      }

      /* hostname,first use config file */
      if(isset($purl['host']) && $purl['host'] != "") {
         $SYMP_URL = "$purl[host]$SYMP_URL";
      } /* hostname,second try server_name */
      else if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != "") {
         $SYMP_URL = "$_SERVER[SERVER_NAME]$SYMP_URL";
      } /* hostname,third try http_host */
      else if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != "") {
         $SYMP_URL = "$_SERVER[HTTP_HOST]$SYMP_URL";
      }

      /* hack fix for proxad sites */
      if((stristr($_SERVER['SERVER_NAME'], ".proxad.") || stristr($_SERVER['HTTP_HOST'], ".proxad."))
            && isset($_SERVER['PATH_INFO']) && ereg("^/([^./]+\\.)+[^./]+/", $_SERVER['PATH_INFO'])) {
         $SYMP_URL = substr($_SERVER['PATH_INFO'], 1);
      }

      /* protocol,first check config file */
      if(isset($purl['scheme']) && $purl['scheme'] != "") {
         $SYMP_URL = "$purl[scheme]"."://"."$SYMP_URL";
      } /* protocol,second use http */
      else {
         $SYMP_URL = "http://"."$SYMP_URL";
      }
   }


   /* grab unique voter id through proxies */
   $proxymaybe = array("REMOTE_ADDR", "HTTP_X_COMING_FROM", "HTTP_X_FORWARDED_FOR",
         "HTTP_COMING_FROM", "HTTP_FORWARDED_FOR", "CLIENT_IP", "HTTP_FROM");
   $SYMP_REMOTE_ADDR = "";
   while(list($k,$v) = each($proxymaybe)) {
      if(isset($_SERVER[$v]) && $_SERVER[$v] != "") {
         $SYMP_REMOTE_ADDR .= $_SERVER[$v];
      }
   }
   $SYMP_REMOTE_ADDR = md5($SYMP_REMOTE_ADDR);

   /***************************** FUNCTIONS ********************************/

   /* database wrapper functions */
   $s_dbid = FALSE;
   $s_dbnum = 0;
   function symp_connect() {
      global $s_dbhost, $s_dbuser, $s_dbpass, $s_dbname;
      global $s_dbid, $s_dbnum;
      if($s_dbid && $s_dbnum > 0) {
         $s_dbnum = $s_dbnum + 1;
      } else {
         if($s_dbuser == "" && $s_dbpass == "") {
            $s_dbid = mysql_connect($s_dbhost);
         } else if($s_dbpass == "") {
            $s_dbid = mysql_connect($s_dbhost, $s_dbuser);
         } else {
            $s_dbid = mysql_connect($s_dbhost, $s_dbuser, $s_dbpass);
         }
         if(!$s_dbid || !mysql_select_db($s_dbname, $s_dbid)) {
            die("Unable to connect to the database!\n");
         }
         $s_dbnum = 1;
      }
   }
   function symp_disconnect($full=FALSE) {
      global $s_dbid, $s_dbnum;
      if($s_dbid && ($full || $s_dbnum <= 1)) {
         mysql_close($s_dbid);
         $s_dbid = FALSE;
         $s_dbnum = 0;
      } else if(!$s_dbid) {
         $s_dbnum = 0;
      } else {
         $s_dbnum = $s_dbnum - 1;
      }
   }

   /* needed to get around an iis bug */
   function symp_redir($url) {
      global $_SERVER;
      if(isset($_SERVER['SERVER_SOFTWARE']) && strstr($_SERVER['SERVER_SOFTWARE'], "IIS")) {
         header("Refresh: 0; URL=$url");
         echo "<html><body bgcolor=\"#000000\">&nbsp;</body></html>";
      } else {
         header("Location: $url");
      }
      exit();
   }

   /* grab a poll from db */
   function symp_poll_fetch($pid) {
      global $s_dbid, $SYMP_REMOTE_ADDR, $s_blength, $s_iplog, $s_cookielog, 
      $sympvotes, $s_srand, $S_VIEW_HIDDEN, $S_VIEW_OPEN, $S_VIEW_CLOSED;

      symp_connect();

      /* -1 = random poll 
       * -2 = latest poll
       * -3 = nonexistant
       */

      if($pid == -1) {
         $q1 = "SELECT pid FROM sympoll_list WHERE (status & '$S_VIEW_OPEN')";
         $r1 = mysql_query($q1, $s_dbid);
         if(!isset($s_srand)) {
            srand((double) microtime() * 1000000);
            $s_srand = TRUE;
         }
         $pid = mysql_result($r1, rand(0, mysql_num_rows($r1) - 1), 'pid');
      } else if($pid == -2) {
         $q2  = "SELECT pid FROM sympoll_list WHERE (status & '$S_VIEW_OPEN') ORDER BY ";
         $q2 .= "timeStamp DESC LIMIT 1";
         $r2 = mysql_query($q2, $s_dbid);
         $a2 = mysql_fetch_array($r2);
         $pid = $a2['pid'];
      } 

      $q3  = "SELECT * FROM sympoll_list,sympoll_data WHERE (sympoll_list.pid";
      $q3 .= "='$pid' AND sympoll_data.pid='$pid') ORDER BY cid";
      $r3 = mysql_query($q3, $s_dbid);

      if(mysql_num_rows($r3) <= 0) {
         $p['pid'] = -3;
         symp_disconnect();
         return $p;
      }
      $a3 = mysql_fetch_array($r3);
      $p['pid'] = $pid;
      $p['nextcid'] = $a3['nextcid'];
      $p['question'] = htmlspecialchars(stripslashes($a3['question']));
      $p['tstamp'] = $a3['timeStamp'];
      $p['cstamp'] = $a3['cookieStamp'];
      $p['status'] = $a3['status'];
      $p['tvotes'] = 0;

      do {
         $cid = $a3['cid'];
         $p['options'][$cid] = htmlspecialchars(stripslashes($a3['choice']));
         $p['votes'][$cid] = $a3['votes'];
         $p['tvotes'] += $a3['votes'];
      } while($a3 = mysql_fetch_array($r3));

      $p['voted'] = -1;
      if($s_cookielog != "0" && isset($sympvotes["symp$p[cstamp]"])) {
         $p['voted'] = $sympvotes["symp$p[cstamp]"];
      } else if($s_iplog != "0") {
         $q4  = "SELECT voted FROM sympoll_iplog WHERE (vid='$SYMP_REMOTE_ADDR' ";
         $q4 .= "AND pid='$pid')";
         $r4 = mysql_query($q4, $s_dbid);
         if(mysql_num_rows($r4) > 0) {
            $now = time();
            $a4 = mysql_fetch_array($r4);
            if($now > ($a4['voted'] + ($s_blength * 86400)) ) {
               $q5  = "DELETE FROM sympoll_iplog WHERE (vid='$SYMP_REMOTE_ADDR' ";
               $q5 .= "AND pid='$pid')";
               $r5 = mysql_query($q5, $s_dbid);
            } else {
               $p['voted'] = $a4['voted'];
            }
         }
      }
      symp_disconnect();
      return $p;
   }
}


?>
