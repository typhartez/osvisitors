<?php
if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password']))
{
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $buffer = explode(" ", $username);
    if (isset($buffer[0])) $firstname = $buffer[0];
    else $firstname = "Unknow Firstname";
    if (isset($buffer[1])) $lastname = $buffer[1];
    else $lastname = "Unknow Lastname";

    $sql = $db->prepare("
        SELECT *
        FROM useraccounts
        WHERE FirstName = '".$firstname."'
        AND LastName = '".$lastname."'
    ");

    $sql->execute();
    $rows = $sql->rowCount();

    if ($rows <> 0)
    {
        while ($row = $sql->fetch(PDO::FETCH_ASSOC))
        {
            $PrincipalID = $row['PrincipalID'];

            if ($PrincipalID <> "")
            {
                $sql = $db->prepare("
                    SELECT *
                    FROM auth
                    WHERE UUID = '".$PrincipalID."'
                ");

                $sql->execute();
                $rows = $sql->rowCount();

                if ($rows <> 0)
                {
                    while ($row = $sql->fetch(PDO::FETCH_ASSOC))
                    {
                        $passwordHash = $row['passwordHash'];
                        $passwordSalt = $row['passwordSalt'];
                    }

                    if ($passwordHash <> "")
                    {
                        $passwordHash   = md5(md5($password).":".$passwordSalt);
                        $md5Password    = $passwordHash;

                        if ($passwordHash == $md5Password)
                        {
                            $_SESSION['valid'] = TRUE;
                            $_SESSION['username'] = $username;
                            $_SESSION['useruuid'] = $PrincipalID;
                            $_SESSION['flash']['success'] = "You are connected succefully <strong>".$username."</strong>";
                        }
                        else $_SESSION['flash']['danger'] = "Wrong password ...";
                    }
                    else $_SESSION['flash']['danger'] = "Invalid password ...";
                }
                else $_SESSION['flash']['danger'] = "ID/Password no match ...";
            }
            else $_SESSION['flash']['danger'] = "Invalid ID ...";
        }
    }
    else $_SESSION['flash']['danger'] = "Invalid username ...";
}
?>

<h1><?php echo $osvisitors; ?> <span class="pull-right">Login</span></h1>
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
        text += '<strong>Login</strong>, please wait ...';
        document.getElementById("alert").innerHTML=text;
        setTimeout('loading()', 1000);
    }
    delay--;
}
loading();
</script>
