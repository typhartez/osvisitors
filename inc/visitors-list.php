<h1><?php echo $osvisitors; ?><span class="pull-right">Home</span></h1>

<!-- Fash Message -->
<?php if(isset($_SESSION['flash'])): ?>
    <?php foreach($_SESSION['flash'] as $type => $message): ?>
        <div class="alert alert-<?php echo $type; ?> alert-anim">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $message; ?>
        </div>
    <?php endforeach; ?>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<?php
$query = $db->prepare("
    SELECT *
    FROM osvisitors_inworld
");

$query->execute();
$counter = $query->rowCount();

if ($counter == 0)
{
    echo '<div class="alert alert-danger alert-anim">';
    echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    echo '0 visitor found ...</div>';
}

echo '<div class="btn-group btn-group-justified" role="group" aria-label="...">';
echo '<a class="btn btn-primary" href="?home&filter=all">All</a>';
echo '<a class="btn btn-primary" href="?home&filter=today">Today</a>';
echo '<a class="btn btn-primary" href="?home&filter=yesterday">Yesterday</a>';
echo '<a class="btn btn-primary" href="?home&filter=week">This Week</a>';
echo '<a class="btn btn-primary" href="?home&filter=month">This Month</a>';
echo '<a class="btn btn-primary" href="?home&filter=year">This Year</a>';

// THIS GRID
echo '<div class="btn-group" role="group">';
echo '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
echo 'This Grid ';
echo '<span class="caret"></span>';
echo '</button>';
echo '<ul class="dropdown-menu">';

$sql = $db->prepare("
    SELECT *
    FROM osvisitors_inworld
    GROUP BY gridname
");

$sql->execute();
$buffer = [];

while ($row = $sql->fetch(PDO::FETCH_ASSOC))
{
    $gridname = $row['gridname'];

    if (!in_array($gridname, $buffer))
    {
        $buffer = [$gridname];
        echo '<li class="dropdown"><a href="?home&filter='.$gridname.'">'.$gridname.'</a></li>';
    }
}
echo '</ul>';
echo '</div>';

// THIS REGION
echo '<div class="btn-group" role="group">';
echo '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
echo 'This Region ';
echo '<span class="caret"></span>';
echo '</button>';
echo '<ul class="dropdown-menu">';

$sql->execute();

while ($row = $query->fetch(PDO::FETCH_ASSOC))
{
    $regionname = $row['regionname'];

    if (!in_array($regionname, $buffer))
    {
        $buffer = [$regionname];
        echo '<li><a href="?home&filter='.$regionname.'">'.$regionname.'</a></li>';
    }
}
echo '</ul>';
echo '</div>';

// THIS PARCEL
echo '<div class="btn-group" role="group">';
echo '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
echo 'This Parcel ';
echo '<span class="caret"></span>';
echo '</button>';
echo '<ul class="dropdown-menu">';

$query->execute();
while ($row = $query->fetch(PDO::FETCH_ASSOC))
{
    $parcelname = $row['parcelname'];

    if (!in_array($parcelname, $buffer))
    {
        $buffer = [$parcelname];
        echo '<li><a href="?home&filter='.$parcelname.'">'.$parcelname.'</a></li>';
    }
}
echo '</ul>';
echo '</div>';
echo '</div>';

echo '<div class="spacer"></div>';

echo '<div class="table-responsive">';
echo '<table class="table table-hover">';
echo '<thead>';
echo '<tr>';
echo '<th>#</th>';
echo '<th>Username</th>';
echo '<th>Gender</th>';
echo '<th>Language</th>';
echo '<th>Country</th>';
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

$query->execute();
while ($row = $query->fetch(PDO::FETCH_ASSOC))
{
    $id         = $row['id'];
    $username   = '<i class="glyphicon glyphicon-user"></i> '.$row['username'];
    $useruuid   = $row['useruuid'];
    $gender     = $row['gender'];
    $language   = $row['language'];
    $ip         = $row['ip'];
    $country    = $row['country'];
    $gridname   = $row['gridname'];
    $regionname = $row['regionname'];
    $parcelname = $row['parcelname'];
    $counter    = $row['counter'];

    $firstvisit = $row['firstvisit'];
    $firstdate  = date("d/m/Y", $firstvisit);
    $firsttime  = date("h:m:s", $firstvisit);

    $lastvisit  = $row['lastvisit'];
    $lastdate   = date("d/m/Y", $lastvisit);
    $lasttime   = date("h:m:s", $lastvisit);

    // GET FLAGS
    $flag = './img/flags/'.strtolower($country).'.png';
    if (file_exists($flag)) {$country = '<img src="'.$flag.'" alt="'.$country.'" title="'.$country.'">';}
    $flag = './img/flags/'.strtolower($language).'.png';
    if (file_exists($flag)) {$language = '<img src="'.$flag.'" alt="'.$language.'" title="'.$language.'">';}

    // SET CLASS
    if (date('d') == date("d", $lastvisit)) $class = 'active';
    else $class = '';

    if (isset($_GET['filter']))
    {
        if ($_GET['filter'] == "all")
        {
            $visites += $counter;

            echo '<tr class="'.$class.'">';
            echo '<td><span class="badge">'.++$i.'</span></td>';
            echo '<td>'.$username.'</td>';
            echo '<td>'.$gender.'</td>';
            echo '<td>'.$language.'</td>';
            echo '<td>'.$country.'</td>';
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

        if ($_GET['filter'] == "today")
        {
            if (date('d') == date("d", $lastvisit))
            {
                $visites += $counter;

                echo '<tr class="'.$class.'">';
                echo '<td><span class="badge">'.++$i.'</span></td>';
                echo '<td>'.$username.'</td>';
                echo '<td>'.$gender.'</td>';
                echo '<td>'.$language.'</td>';
                echo '<td>'.$country.'</td>';
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

        if ($_GET['filter'] == "yesterday")
        {
            if (date('d') - 1 == date("d", $lastvisit))
            {
                $visites += $counter;

                echo '<tr class="'.$class.'">';
                echo '<td><span class="badge">'.++$i.'</span></td>';
                echo '<td>'.$username.'</td>';
                echo '<td>'.$gender.'</td>';
                echo '<td>'.$language.'</td>';
                echo '<td>'.$country.'</td>';
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

        if ($_GET['filter'] == "week")
        {
            if (date('W') == date("W", $lastvisit))
            {
                $visites += $counter;

                echo '<tr class="'.$class.'">';
                echo '<td><span class="badge">'.++$i.'</span></td>';
                echo '<td>'.$username.'</td>';
                echo '<td>'.$gender.'</td>';
                echo '<td>'.$language.'</td>';
                echo '<td>'.$country.'</td>';
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

        if ($_GET['filter'] == "month")
        {
            if (date('m') == date("m", $lastvisit))
            {
                $visites += $counter;

                echo '<tr class="'.$class.'">';
                echo '<td><span class="badge">'.++$i.'</span></td>';
                echo '<td>'.$username.'</td>';
                echo '<td>'.$gender.'</td>';
                echo '<td>'.$language.'</td>';
                echo '<td>'.$country.'</td>';
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

        if ($_GET['filter'] == "year")
        {
            if (date('Y') == date("Y", $firstvisit))
            {
                $visites += $counter;

                echo '<tr class="'.$class.'">';
                echo '<td><span class="badge">'.++$i.'</span></td>';
                echo '<td>'.$username.'</td>';
                echo '<td>'.$gender.'</td>';
                echo '<td>'.$language.'</td>';
                echo '<td>'.$country.'</td>';
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

        // BY REGION, BY PARCEL
        if ($_GET['filter'] == $regionname || $_GET['filter'] == $parcelname || $_GET['filter'] == $gridname || $_GET['filter'] == $username) 
        {
            $visites += $counter;

            echo '<tr class="'.$class.'">';
            echo '<td><span class="badge">'.++$i.'</span></td>';
            echo '<td>'.$username.'</td>';
            echo '<td>'.$gender.'</td>';
            echo '<td>'.$language.'</td>';
            echo '<td>'.$country.'</td>';
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

    // BY DEFAULT
    else
    {
        $visites += $counter;

        echo '<tr class="'.$class.'">';
        echo '<td><span class="badge">'.++$i.'</span></td>';
        echo '<td>'.$username.'</td>';
        echo '<td>'.$gender.'</td>';
        echo '<td>'.$language.'</td>';
        echo '<td>'.$country.'</td>';
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
echo '<td colspan=2>Total result(s) <span class="badge">'.$i.'</span></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td colspan=2 class="text-right">Total visit(s) <span class="badge">'.$visites.'</span></td>';
echo '</tr>';
echo '</tfoot>';
echo '</table>';
echo '</div>';

$query = null;
$sql = null;
?>
