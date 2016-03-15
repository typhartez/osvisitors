<?php
$_SESSION['flash']['success'] = "You are disconnected successfully ".$_SESSION["username"]." ...";
unset($_SESSION["valid"]);
unset($_SESSION["username"]);
unset($_SESSION['useruuid']);
?>

<h1><?php echo $osvisitors; ?> <span class="pull-right">Logout</span></h1>
<div id="alert" class="alert alert-info alert-anim"></div>

<script>
delay = 3;
function loading()
{
    if (delay == 0)
    {
        <?php echo "window.location.href='./';"; ?>
    }

    if (delay > 0)
    {
        var text;
        text  = '<i class="glyphicon glyphicon-refresh glyphicon-refresh-animate pull-right"></i>';
        text += '<strong>Logout</strong>, please wait ...';
        document.getElementById("alert").innerHTML=text;
        setTimeout('loading()', 1000);
    }
    delay--;
}
loading();
</script>
