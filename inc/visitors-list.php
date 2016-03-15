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
    echo '<p class="alert alert-danger alert-anim-off">0 visitor found ...</p>';
    exit;
}

echo '<div class="btn-group btn-group-justified" role="group" aria-label="...">';
echo '<a class="btn btn-primary" href="?filter=all">All</a>';
echo '<a class="btn btn-primary" href="?filter=today">Today</a>';
echo '<a class="btn btn-primary" href="?filter=yesterday">Yesterday</a>';
echo '<a class="btn btn-primary" href="?filter=month">This Month</a>';
echo '<a class="btn btn-primary" href="?filter=year">This Year</a>';

// THIS GRID
echo '<div class="btn-group" role="group">';
echo '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
echo 'This Grid ';
echo '<span class="caret"></span>';
echo '</button>';
echo '<ul class="dropdown-menu">';

$buffer = [];
$query->execute();

while ($row = $query->fetch(PDO::FETCH_ASSOC))
{
    $gridname = $row['gridname'];

    if (!in_array($gridname, $buffer))
    {
        $buffer = [$gridname];
        echo '<li><a href="?filter='.$gridname.'">'.$gridname.'</a></li>';
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

$query->execute();
while ($row = $query->fetch(PDO::FETCH_ASSOC))
{
    $regionname = $row['regionname'];
    echo '<li><a href="?filter='.$regionname.'">'.$regionname.'</a></li>';
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
    echo '<li><a href="?filter='.$parcelname.'">'.$parcelname.'</a></li>';
}

echo '</ul>';
echo '</div>';
echo '</div>';

echo '<div class="table-responsive">';
echo '<table class="table table-hover">';
echo '<thead>';
echo '<tr>';
echo '<th>#</th>';
echo '<th>Username</th>';
echo '<th>Date</th>';
echo '<th>Time</th>';
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
    $username   = $row['username'];
    $useruuid   = $row['useruuid'];
    $gridname   = $row['gridname'];
    $regionname = $row['regionname'];
    $parcelname = $row['parcelname'];
    $counter    = $row['counter'];
    $timestamp  = $row['timestamp'];
    $date       = date("d/m/Y", $timestamp);
    $time       = date("h:m:s", $timestamp);

    if (isset($_GET['filter']))
    {
        if ($_GET['filter'] == "all")
        {
            $visites += $counter;

            echo '<tr>';
            echo '<td><span class="badge">'.++$i.'</span></td>';
            echo '<td>'.$username.'</td>';
            echo '<td>'.$date.'</td>';
            echo '<td>'.$time.'</td>';
            echo '<td>'.$gridname.'</td>';
            echo '<td>'.$regionname.'</td>';
            echo '<td>'.$parcelname.'</td>';
            echo '<td class="text-right"><span class="badge">'.$counter.'</span></td>';
            echo '</tr>';
        }

        if ($_GET['filter'] == "today")
        {
            if (date('d') == date("d", $timestamp))
            {
                $visites += $counter;

                echo '<tr>';
                echo '<td><span class="badge">'.++$i.'</span></td>';
                echo '<td>'.$username.'</td>';
                echo '<td>'.$date.'</td>';
                echo '<td>'.$time.'</td>';
                echo '<td>'.$gridname.'</td>';
                echo '<td>'.$regionname.'</td>';
                echo '<td>'.$parcelname.'</td>';
                echo '<td class="text-right"><span class="badge">'.$counter.'</span></td>';
                echo '</tr>';
            }
        }

        if ($_GET['filter'] == "yesterday")
        {
            if (date('d') - 1 == date("d", $timestamp))
            {
                $visites += $counter;

                echo '<tr>';
                echo '<td><span class="badge">'.++$i.'</span></td>';
                echo '<td>'.$username.'</td>';
                echo '<td>'.$date.'</td>';
                echo '<td>'.$time.'</td>';
                echo '<td>'.$gridname.'</td>';
                echo '<td>'.$regionname.'</td>';
                echo '<td>'.$parcelname.'</td>';
                echo '<td class="text-right"><span class="badge">'.$counter.'</span></td>';
                echo '</tr>';
            }     
        }

        if ($_GET['filter'] == "month")
        {
            if (date('m') == date("m", $timestamp))
            {
                $visites += $counter;

                echo '<tr>';
                echo '<td><span class="badge">'.++$i.'</span></td>';
                echo '<td>'.$username.'</td>';
                echo '<td>'.$date.'</td>';
                echo '<td>'.$time.'</td>';
                echo '<td>'.$gridname.'</td>';
                echo '<td>'.$regionname.'</td>';
                echo '<td>'.$parcelname.'</td>';
                echo '<td class="text-right"><span class="badge">'.$counter.'</span></td>';
                echo '</tr>';
            }     
        }

        if ($_GET['filter'] == "year")
        {
            if (date('Y') == date("Y", $timestamp))
            {
                $visites += $counter;

                echo '<tr>';
                echo '<td><span class="badge">'.++$i.'</span></td>';
                echo '<td>'.$username.'</td>';
                echo '<td>'.$date.'</td>';
                echo '<td>'.$time.'</td>';
                echo '<td>'.$gridname.'</td>';
                echo '<td>'.$regionname.'</td>';
                echo '<td>'.$parcelname.'</td>';
                echo '<td class="text-right"><span class="badge">'.$counter.'</span></td>';
                echo '</tr>';
            }     
        }

        // BY REGION, BY PARCEL
        if ($_GET['filter'] == $regionname || $_GET['filter'] == $parcelname || $_GET['filter'] == $gridname) 
        {
            $visites += $counter;

            echo '<tr>';
            echo '<td><span class="badge">'.++$i.'</span></td>';
            echo '<td>'.$username.'</td>';
            echo '<td>'.$date.'</td>';
            echo '<td>'.$time.'</td>';
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

        echo '<tr>';
        echo '<td><span class="badge">'.++$i.'</span></td>';
        echo '<td>'.$username.'</td>';
        echo '<td>'.$date.'</td>';
        echo '<td>'.$time.'</td>';
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
echo '<td>Total result(s) <span class="badge">'.$i.'</span></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td class="text-right">Total visit(s) <span class="badge">'.$visites.'</span></td>';
echo '</tr>';
echo '</tfoot>';
echo '</table>';
echo '</div>';

$query = null;
?>
