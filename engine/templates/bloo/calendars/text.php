<?php
            if (isset($days[$day]) and is_array($days[$day])) {
                @list($link, $classes, $content, $count) = $days[$day];
                    if (is_null($content)) {
                         $content  = $day;
                    }
                    $calendar .= '<td class="rb-border" '.$session->body_style.' align="center" valign="middle">'.($link ? '<a href="'.htmlspecialchars($link).'" title="['.$i18n->count.': '.$count.']"><strong>'.$content.'</strong></a>' : $content).'</td>';
            } else {
                 $calendar .= "<td class=\"rb-border\" align=\"center\" valign=\"middle\" >$day</td>";
            }
?>