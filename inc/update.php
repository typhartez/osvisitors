<h1><?php echo $osvisitors; ?><span class="pull-right">Update</span></h1>

<!-- Login Form -->
<?php if (!isset($_SESSION['valid'])): ?>
<div class="alert alert-danger alert-anim">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>SuperAdmin</strong> access only ...
</div>
<form class="form-signin" role="form" action="?login" method="post" >
<h2 class="form-signin-heading">Please login 
    <i class="glyphicon glyphicon-lock pull-right"></i>
</h2>
    <label for="username" class="sr-only">User name</label>
    <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
    <label for="password" class="sr-only">Password</label>
    <input type="password" name="password" class="form-control" placeholder="Password" required>
    <div class="checkbox">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>        
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">
        <i class="glyphicon glyphicon-log-in"></i> Log-in
    </button>
</form>
<?php endif; ?>

<?php
if (isset($_SESSION['valid']))
{
    if (!empty($_POST))
    {
        if (isset($_POST['update']))
        {
            $sql = $db->prepare("
                SELECT ip, country
                FROM osvisitors_inworld
                GROUP BY ip
            ");
            $sql->execute();

            $buffer = [];

            while ($row = $sql->fetch(PDO::FETCH_ASSOC))
            {
                $ip = $row['ip'];

                if (!in_array($ip, $buffer))
                {
                    $buffer = [$ip];
                    $details = json_decode(file_get_contents($geoipservice."{$ip}"));
                    $country = $details->country;

                    $query = $db->prepare("
                        UPDATE osvisitors_inworld
                        SET country = :country
                        WHERE ip = :ip
                    ");

                    $query->bindValue(':country', $country, PDO::PARAM_STR);
                    $query->bindValue(':ip', $ip, PDO::PARAM_STR);
                    $query->execute();
                }
            }
        }

        if ($query)
        {                       
            echo '<div class="alert alert-success alert-anim-off">';
            echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
            echo '<i class="glyphicon glyphicon-ok"></i> Visitors country updated successfully ...';
            echo '</div>';

            $sql->execute();

            while ($row = $sql->fetch(PDO::FETCH_ASSOC))
            {
                $ip = $row['ip'];
                $country = $row['country'];
                echo '<ul class="">';
                echo '<li>';
                echo 'The Flag for IP Adress <strong>'.$ip.'</strong> is <strong>'.$country.'</strong>';
                echo ' <img src="./img/flags/'.strtolower($country).'.png" alt="'.$country.'">';
                echo '</li>';
                echo '</ul>';
                echo '';
            }
        }

        else
        {
            echo '<div class="alert alert-danger alert-anim-off">';
            echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
            echo '<i class="glyphicon glyphicon-ok"></i> Visitors country updated failed ...';
            echo '</div>';
        }

        $query = null;
        $sql = null;
    }

    if ($_SESSION['useruuid'] === $superadmin) {$state = "";}
    else $state = 'disabled="disabled"';
    echo '<form class="form form-group" action="" method="post">';
    echo '<button class="btn btn-success" '.$state.' type="submit" role="button" name="update" value="true">';
    echo '<i class="glyphicon glyphicon-refresh"></i> Update all visitors country</button>';
    echo '</form>';
}
?>

<!-- BLOCK FORM -->
<script>
$('form').submit( function(e) {
    e.preventDefault();
});
</script>
