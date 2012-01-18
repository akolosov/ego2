<?php
            if (isset($days[$day]) and is_array($days[$day])) {
                @list($link, $classes, $content, $count) = $days[$day];
                    if (is_null($content)) {
                         $content  = $day;
                    }
                    $calendar .= '<td class="rb-border" id="calendar" '.$session->footer_style.' align="center" valign="middle">'.($link ? '<a href="'.htmlspecialchars($link).'" title="['.$i18n->count.': '.$count.']">'.$content.'</a>' : $content).'</td>';
            } else {
                 $calendar .= "<td class=\"rb-border\" id=\"calendar\" align=\"center\" valign=\"middle\" >$day</td>";
            }
?>