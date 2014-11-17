<?php
$songtext = file('../songs/zeit-bleib-stehen.chords');

$songtext = implode($songtext);
preg_match('/^[\n\r\s]*-{3}([^-{3}]*)-{3}/i',$songtext,$matches);
$songtext = trim(str_replace($matches[0],'',$songtext));
$songtext = explode("\n",$songtext);
$meta = parse_ini_string($matches[1]);

$output = '<h1>'.$meta['title'].' ('.$meta['author'].')</h1>';
    
foreach($songtext as $num=>$line)
{
    if (preg_replace('/[\s\t\n\r]/m', '', $line) == '')
    {
        // empty line:
        $output.= '<div class="verse_spacer"><br /></div>';
    }
    else 
    {
        $line = preg_split('/\({1}([a-zA-Z0-9]+)\){1}/', $line, null, PREG_SPLIT_DELIM_CAPTURE);
        if (count($line) == 1) 
        {
            $output .= $line[0].'<br />';
        } 
        else 
        {
            $output .= '<table><tr>';
            for ($i = 0; $i < count($line); $i = $i + 2) {
                $output .= '<td>' . $line[$i - 1] . '<td>';
            }
            $output .= '</tr><tr>';
            for ($i = 0; $i < count($line); $i = $i + 2) {
                $output .= '<td>' . str_replace(' ', '&nbsp;', $line[$i]) . '<td>';
            }
            $output .= '</tr></table>';
        }
    }
}

?><!DOCTYPE html>
<html>
    <head>
        <title>
            Favorite guitar songs - Songfile loader test
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
            table {
                border-collapse: collapse;
            }
            table td {
                border:1px solid #e7e7e7;
            }
        </style>
    </head>
    <body>
        <?php echo $output; ?>
    </body>
</html>