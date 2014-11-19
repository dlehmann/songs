<?php
$songtext = file('../songs/schlaflied.chords');

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
        $output.= '<div class="verse-spacer"><br /></div>';
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
            for ($i = 0; $i < count($line); $i = $i + 2) 
            {
                if (!empty($line[$i - 1].$line[$i])) 
                {
                    $output .= '<td>' . $line[$i - 1] . '</td>';
                }   
            }
            $output .= '</tr><tr>';
            for ($i = 0; $i < count($line); $i = $i + 2) 
            {
                if (!empty($line[$i - 1].$line[$i])) 
                {
                    $output .= '<td>' . str_replace(' ', '&nbsp;', $line[$i]) . '</td>';
                }    
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
            @import url(http://fonts.googleapis.com/css?family=Roboto);
            body {
                font: 16px 'Roboto', sans-serif;
            }
            table {
                border-collapse: collapse;
            }
            table td {
                padding: 0;
                margin:0;
            }
            .verse-spacer {
                height:30px;
            }
        </style>
    </head>
    <body>
        <?php echo $output; ?>
    </body>
</html>