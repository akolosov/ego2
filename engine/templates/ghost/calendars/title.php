<?php
        $calendar = '<table width="100%" height="100%" align="center" valign="middle">'."\n".
                    '<caption class="border" id="header" width="100%"><nobr class="topiclinx">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</nobr></caption><tr>";

        if ($day_name_length){
            foreach($day_names as $d) {
                $calendar .= '<th class="cal-header" abbr="'.$d.'"><span class="topic"><strong>'.($day_name_length < 4 ? substr_x($d, 0, $day_name_length) : $d).'</strong></span></th>';
            }
            $calendar .= "</tr>\n<tr>";
        }


?>