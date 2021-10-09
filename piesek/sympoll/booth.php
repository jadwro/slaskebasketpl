<?php


if(!function_exists('symp_boothUI')) {

   /* file extension + includes */
   $ext = substr(__FILE__, strrpos(__FILE__, ".") + 1);
   require dirname(__FILE__)."/common.$ext";

   /* returns the entire html block for a voting booth */
   function symp_boothUI($p, $rand) {
      global $s_tx, $s_txtsize, $s_optsize, $s_txtface, $s_dirurl, $s_polllist,
      $ext, $symp_lang1, $symp_lang2, $symp_lang3, $s_width, $s_bg, $s_bord,
      $s_qtx, $s_qbg, $SYMP_URL, $S_TYPE_RADIO, $S_TYPE_CHECK, $_SERVER;

      /* handle results and random-poll markers */
      $_SERVER['QUERY_STRING'] = ereg_replace("(^&)|([&]?vo=[0-9]+)", "", $_SERVER['QUERY_STRING']); 
      $sympurl = "${SYMP_URL}?$_SERVER[QUERY_STRING]";
      if($_SERVER['QUERY_STRING'] != "") {
         $sympurl .= "&amp;";
      }
      if($rand) {
         if($_SERVER['QUERY_STRING'] != "") {
            $_SERVER['QUERY_STRING'] .= "&amp;";
         }
         $_SERVER['QUERY_STRING'] .= "rd=$p[pid]";
         $sympurl .= "rd=$p[pid]"."&amp;";
      }
      $sympurl .= "vo=$p[pid]";

      /* html question and such */
      $o = "<form method=\"post\" action=\"${s_dirurl}dovote.$ext\">\n";
      $o.= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\" width=\"$s_width\">\n";
      $o.= "<tr><td width=\"100%\">\n";
      $o.= "<table cellspacing=\"0\" cellpadding=\"1\" width=\"100%\" style=\"$s_bord\"$s_qbg>\n";
      $o.= "<tr><td width=\"100%\" valign=\"middle\">\n";
      $o.= "<font$s_qtx$s_txtsize$s_txtface>\n<b>$p[question]<br /></b></font>\n";
      $o.= "</td></tr></table>\n</td></tr><tr><td width=\"100%\">\n";
      $o.= "<table cellspacing=\"0\" cellpadding=\"1\" width=\"100%\" style=\"$s_bord\"$s_bg>\n";

      /* html poll options */
      while(list($k,$v) = each($p['options'])) {
         $o.= "<tr><td width=\"10\" valign=\"top\" align=\"left\">\n";
         if($p['status'] & $S_TYPE_RADIO) {
            $o.= "<input type=\"radio\" name=\"cid\" value=\"$k\" />";
         } else if($p['status'] & $S_TYPE_CHECK) {
            $o.= "<input type=\"checkbox\" name=\"cid[$k]\" value=\"poof\" />";
         } else {
            $o.= "!";
         }
         $o.= "</td>\n<td width=\"100%\" valign=\"middle\" align=\"left\">\n";
         $o.= "<font$s_tx$s_txtface$s_optsize>\n";
         $o.= "$v</font></td></tr>\n\n";
      }

      /* html poll footer */
      $o.= "<tr><td width=\"100%\" colspan=\"2\">\n";
      $o.= "<font color=\"#000000\" size=\"1\"$s_txtface>&nbsp;\n";
      $o.= "<input type=\"submit\" name=\"s_boom\" value=\"$symp_lang1\" ";
      $o.= "style=\"font-size: 10px\" />\n</font>\n";
      if($s_polllist == "0") {
         $o.= "<font size =\"1\"$s_txtface>\n";
         $o.= "&nbsp;&nbsp;&nbsp;";
         $o.= "<a href=\"$sympurl\">$symp_lang2</a></font>\n";
      } else {
         $o.= "<div align=\"center\">";
         $o.= "<font size =\"1\"$s_txtface><br />\n";
         $o.= "<a href=\"$sympurl\">$symp_lang2</a>";
         $o.= "&nbsp;<b>::</b>&nbsp;";
         $o.= "<a href=\"${s_dirurl}index.$ext\">$symp_lang3</a></font>";
         $o.= "</div>\n";
      }
      $o.= "</td></tr></table>\n</td></tr></table>\n";
      $o.= "<input type=\"hidden\" name=\"pid\" value=\"$p[pid]\" />\n";
      $o.= "<input type=\"hidden\" name=\"ref\" value=\"$sympurl\" />\n";
      $o.= "</form>\n";

      return $o;
   }



   /* returns the entire html block for poll results */
   function symp_resultsUI($p) {
      global $s_tx, $s_txtsize, $s_optsize, $s_width, $s_txtface, $s_barimg,
      $s_barhite, $ext, $s_showtotal, $s_dirurl, $s_polllist, $s_resultnums,
      $symp_lang3, $symp_lang7, $s_bg, $s_bord, $s_qtx, $s_qbg, $s_barimg_dir;

      /* start with html question and such */
      $o = "<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\" width=\"$s_width\">\n";
      $o.= "<tr><td width=\"100%\">\n";
      $o.= "<table cellspacing=\"0\" cellpadding=\"1\" width=\"100%\" style=\"$s_bord\"$s_qbg>\n";
      $o.= "<tr><td width=\"100%\" valign=\"middle\">\n";
      $o.= "<font$s_qtx$s_txtsize$s_txtface>\n<b>$p[question]<br /></b></font>\n";
      $o.= "</td></tr></table>\n</td></tr><tr><td width=\"100%\">\n";
      $o.= "<table cellspacing=\"0\" cellpadding=\"1\" width=\"100%\" style=\"$s_bord\"$s_bg>\n";

      /* do some quick math */
      $offset = 1;
      while(list($k,$v) = each($p['votes'])) {
         if($p['tvotes'] > 0)  {
            $p['votepcts'][$k] = round(($v / $p['tvotes']) * 100);
         } else {
            $p['votepcts'][$k] = 0;
         }
      }
      $highpct = max($p['votepcts']);

      /* print each result row */
      while(list($k,$v) = each($p['options'])) {
         if($s_resultnums == "0") {
            $rnum = $p['votepcts'][$k]."%"; 
         } else {
            $rnum = $p['votes'][$k]; 
         }

         /* get the image size in pixels */
         if($highpct > 0) {
            $imgsize = floor($p['votepcts'][$k] * (($s_width-42) / $highpct))
               + $offset;
         } else {
            $imgsize = $offset;
         }

         /* do the html */
         if($s_polllist != "0" && $s_showtotal != "0") {
            $o.= "<tr><td valign=\"top\" colspan=\"2\">";
         } else {
            $o.= "<tr><td valign=\"top\">";
         }
         $o.= "<font$s_tx$s_txtface$s_optsize>\n";

         /* image bar and result number text */
         $srcp = "$s_dirurl$s_barimg_dir/$s_barimg";
         $o.= "$v\n<br /><font color=\"#000000\">";
         $o.= "<img src=\"$srcp\" width=\"$imgsize\" height=\"$s_barhite\" ";
         $o.= "alt=\" [tally]\" border=\"1\" align=\"top\" /></font>";
         $o.= "&nbsp;$rnum<br /></font></td></tr>\n";
      }

      /* results footer */
      if($s_showtotal != "0" || $s_polllist != "0") {
         $o.= "<tr>";
         if($s_showtotal != "0")  {
            $o.= "<td align=\"left\">";
            $o.= "<font size=\"1\"$s_tx$s_txtface>\n";
            $o.= "<i>$symp_lang7:&nbsp;</i>"."$p[tvotes]"."\n</font></td>\n";
         }
         if($s_polllist != "0") { 
            if($s_showtotal != "0") {
               $o.= "<td align=\"right\">";
            } else {
               $o.= "<td align=\"left\">";
            }
            $o.= "<font size=\"1\"$s_tx$s_txtface>\n";
            $o.= "<a href=\"${s_dirurl}index.$ext\">$symp_lang3</a>";  
            $o.= "\n</font></td>\n";
         }
         $o.= "</tr>";
      }
      $o.= "</table>\n</td></tr></table>\n";

      return $o;
   }



   /* decides whether to show booth or results */
   function symp_get_booth($pid) {
      global $_GET, $symp_lang9, $S_VIEW_HIDDEN, $S_VIEW_CLOSED;

      /* they participated in a random poll-- keep same pid */
      if(isset($_GET['rd']) && $_GET['rd'] != "" && $pid == -1) {
         $pid = $_GET['rd']; 
      }

      /* get poll and check its status */
      $p = symp_poll_fetch($pid);
      if($p['pid'] < 0 || $p['status'] & $S_VIEW_HIDDEN) {
         return "<b>$symp_lang9</b>";
      } else if($p['status'] & $S_VIEW_CLOSED) {
         return symp_resultsUI($p);
      }

      /* now we can figure out what to do */
      if($p['voted'] != -1 || (isset($_GET['vo']) && $_GET['vo'] == $p['pid'])) {
         /* show results */
         return symp_resultsUI($p);
      } else {
         /* haven't voted, check for random marker then display booth */
         $rand = FALSE;
         if($pid == -1) {
            $rand = TRUE;
         }
         return symp_boothUI($p, $rand);
      }
   } 



   /* for use with templates, you can optionally change the following
    * three functions to use return instead of echo.  this will return
    * all the html text instead of directly displaying it.
    */

   function display_booth($pid) {
      echo symp_get_booth($pid);
   }
   function random_booth() {
      echo symp_get_booth(-1);
   } 
   function newest_booth() {
      echo symp_get_booth(-2);
   } 
}

?>
