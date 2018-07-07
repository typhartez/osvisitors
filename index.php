<?php include_once("inc/config.php"); ?>
<?php include_once("inc/PDO-mysql.php"); ?>
<?php include_once("inc/header.php"); ?>
<?php include_once("inc/navbar.php"); ?>

<?php
if ($debug == TRUE)
{
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
?>

<?php
if (isset($_GET['home'])) $page = 1;
if (isset($_GET['login'])) $page = 2;
else if (isset($_GET['logout'])) $page = 3;
else if (isset($_GET['help'])) $page = 4;
else if (isset($_GET['search'])) $page = 5;
else if (isset($_GET['reorder'])) $page = 6;
else if (isset($_GET['delete'])) $page = 7;
else if (isset($_GET['update'])) $page = 8;
else {$page = 1;} 

echo '<div class="content">';
if ($page == 1) require("inc/visitors-list.php");
else if ($page == 2) require("inc/login.php");
else if ($page == 3) require("inc/logout.php");
else if ($page == 4) require("inc/help.php");
else if ($page == 5) require("inc/search.php");
else if ($page == 6) require("inc/reorder.php");
else if ($page == 7) require("inc/delete.php");
else if ($page == 8) require("inc/update.php");
else require("inc/404.php");
echo '</div>';
?>

<?php include_once("inc/footer.php"); ?>
