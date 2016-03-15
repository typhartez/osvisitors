<h1><?php echo $osvisitors; ?><span class="pull-right">Reorder</span></h1>

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
        if (isset($_POST['reorder']))
        {
            $query = $db->prepare("
                ALTER TABLE osvisitors_inworld 
                DROP id
            ");
            $query->execute();

            $query = $db->prepare("
                ALTER TABLE osvisitors_inworld 
                AUTO_INCREMENT = 1
            ");
            $query->execute();

            $query = $db->prepare("
                ALTER TABLE osvisitors_inworld 
                ADD id int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST
            ");
            $query->execute();
        }

        if ($query)
        {
            echo '<div class="alert alert-success alert-anim-off">';
            echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
            echo '<i class="glyphicon glyphicon-ok"></i> Table <strong>id</strong> re-ordered successfully ...';
            echo '</div>';
        }

        else
        {
            echo '<div class="alert alert-danger alert-anim-off">';
            echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
            echo '<i class="glyphicon glyphicon-ok"></i> Table <strong>id</strong> re-ordered failed ...';
            echo '</div>';
        }
    }

    if ($_SESSION['useruuid'] === $superadmin) {$state = "";}
    else $state = 'disabled="disabled"';
    echo '<form class="form form-group" action="" method="post">';
    echo '<button class="btn btn-success" '.$state.' type="submit" role="button" name="reorder" value="true">';
    echo '<i class="glyphicon glyphicon-sort-by-order-alt"></i> reorder visitors id</button>';
    echo '</form>';
}
?>

<!-- BLOCK FORM -->
<script>
$('form').submit( function(e) {
    e.preventDefault();
});
</script>
