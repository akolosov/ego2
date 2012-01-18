<?php
            if (isset($days[$day]) and is_array($days[$day])) {
                @list($link, $classes, $content, $count) = $days[$day];
                    if (is_null($content)) {
                         $content  = $day;
                    }
                    $calendar .= '<td class="navcell" '.$session->footer_style.' align="center" valign="middle">'.($link ? '<a href="'.htmlspecialchars($link).'" title="['.$i18n->count.': '.$count.']" class="navcell" id="cal"><strong>'.$content.'</strong></a>' : $content).'</td>';
            } else {
                 $calendar .= "<td class=\"border\" align=\"center\" valign=\"middle\" >$day</td>";
            }
?>