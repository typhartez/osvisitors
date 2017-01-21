<h1><?php echo $osvisitors; ?> <span class="pull-right">Search</span></h1>

<?php
if (isset($_POST['search']))
{
    if (!empty($_POST['searchword']))
    {
        $search_word  = htmlspecialchars($_POST['searchword']);

        $query = ('
            SELECT * 
            FROM '.$tbname.' 
            WHERE username LIKE ?
            OR gridname LIKE ?
            OR regionname LIKE ?
            OR parcelname LIKE ? 
            ORDER BY lastvisit DESC
        ');
        $query = $db->prepare($query);

        $value = "%{$search_word}%";
        $query->bindValue(1, $value, PDO::PARAM_STR);
        $query->bindValue(2, $value, PDO::PARAM_STR);
        $query->bindValue(3, $value, PDO::PARAM_STR);
        $query->bindValue(4, $value, PDO::PARAM_STR);

        $query->execute();
        $rowcount = $query->rowCount();

        echo '<span class="badge">'.$rowcount.'</span> result(s) found ...';

        echo '<div class="table-responsive">';
        echo '<table class="table table-hover">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>#</th>';
        echo '<th>Username</th>';
        echo '<th>First Date</th>';
        echo '<th>First Time</th>';
        echo '<th>Last Date</th>';
        echo '<th>Last Time</th>';
        echo '<th>Grid</th>';
        echo '<th>Region</th>';
        echo '<th>Parcel</th>';
        echo '<th class="text-right">Visit(s)</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 0;
        $visites = 0;

        if ($rowcount <> 0)
        {
            while ($result = $query->fetch()) 
            {
                $id         = $result['id'];
                $username   = $result['username'];
                $gridname   = $result['gridname'];
                $regionname = $result['regionname'];
                $parcelname = $result['parcelname'];

                $counter    = $result['counter'];
                $visites   += $counter;

                $firstvisit = $result['firstvisit'];
                $firstdate  = date("d/m/Y", $firstvisit);
                $firsttime  = date("d/m/Y", $firstvisit);

                $lastvisit  = $result['lastvisit'];
                $lastdate   = date("d/m/Y", $lastvisit);
                $lasttime   = date("h:m:s", $lastvisit);

                if (date('d') == date("d", $lastvisit)) $class = 'active';
                else $class = '';

                echo '<tr class="'.$class.'">';
                echo '<td><span class="badge">'.++$i.'</span></td>';
                echo '<td>'.$username.'</td>';
                echo '<td>'.$firstdate.'</td>';
                echo '<td>'.$firsttime.'</td>';
                echo '<td>'.$lastdate.'</td>';
                echo '<td>'.$lasttime.'</td>';
                echo '<td>'.$gridname.'</td>';
                echo '<td>'.$regionname.'</td>';
                echo '<td>'.$parcelname.'</td>';
                echo '<td class="text-right"><span class="badge">'.$counter.'</span></td>';
                echo '</tr>';
            }
        }

        echo '</tbody>';
        echo '<tfoot>';
        echo '<tr>';
        echo '<td>Total result(s) <span class="badge">'.$rowcount.'</span></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td class="text-right">Total visites <span class="badge">'.$visites.'</span></td>';
        echo '</tr>';
        echo '</tfoot>';
        echo '</table>';
        echo '</div>';
    }

    else 
    {
        echo '<div class="alert alert-danger alert-anim-off">';
        echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
        echo 'Please enter a search word ...</div>';
        echo '<span class="badge">0</span> result found ...';
    }
}

else
{
    echo '<p class="alert alert-danger alert-anim-off">';
    echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    echo 'Please enter a search query ...</p>';
}

$query = null;
?>
