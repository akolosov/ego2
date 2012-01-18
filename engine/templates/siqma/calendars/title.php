<?php
        $calendar = '<table class="l-border" width="100%" height="100%" align="center" valign="middle" border="0" cellspacing="1" cellpadding="1">'."\n".
                    '<caption class="b-border" id="header"><span class="topiclinx">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</span></caption><tr>";

        if($day_name_length){ #if the day names should be shown ($day_name_length > 0)
            #if day_name_length is >3, the full name of the day will be printed
            foreach($day_names as $d) {
                $calendar .= '<th class="rb-border" '.$session->body_style.' abbr="'.$d.'"><span class="topic"><strong>'.($day_name_length < 4 ? substr_x($d, 0, $day_name_length) : $d).'</strong></span></th>';
            }
            $calendar .= "</tr>\n<tr>";
        }


?>