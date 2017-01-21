<?php
// From Inword Script (todo: base64_decode)
if (isset($_POST['terminal']) && !empty($_POST['terminal']))
{
    if (htmlspecialchars($_POST['terminal']) == "visitors")
    {
        if (isset($_POST['name']) && !empty($_POST['name']))
        {
            if (isset($_POST['uuid']) && !empty($_POST['uuid']))
            {
                if (isset($_POST['gender']) && !empty($_POST['gender']))
                {
                    if (isset($_POST['lang']) && !empty($_POST['lang']))
                    {
                        if (isset($_POST['ip']) && !empty($_POST['ip']))
                        {
                            if (isset($_POST['object']) && !empty($_POST['object']))
                            {
                                if (isset($_POST['region']) && !empty($_POST['region']))
                                {
                                    if (isset($_POST['parcel']) && !empty($_POST['parcel']))
                                    {
                                        if (isset($_POST['grid']) && !empty($_POST['grid']))
                                        {
                                            include_once("config.php");
                                            include_once("PDO-mysql.php");

                                            $name   = htmlspecialchars($_POST['name']);
                                            $object = htmlspecialchars($_POST['object']);
                                            $uuid   = htmlspecialchars($_POST['uuid']);
                                            $gender = htmlspecialchars($_POST['gender']);
                                            $lang   = htmlspecialchars($_POST['lang']);
                                            $ip     = htmlspecialchars($_POST['ip']);
                                            $region = htmlspecialchars($_POST['region']);
                                            $parcel = htmlspecialchars($_POST['parcel']);
                                            $grid   = htmlspecialchars($_POST['grid']);
                                            $host   = htmlspecialchars($_POST['host']);

                                            // NOT USED YET BUT SEND BY INWORD SCRIPT
                                            // $nick    = htmlspecialchars($_POST['nick']);

                                            if ($name == "") {$name = "Unknow";}

                                            echo "Hello  ".$name.", thank you for visiting ".$parcel." on region ".$region;

                                            $timestamp  = time();
                                            $hostname   = $host;

                                            $query = $db->prepare("
                                                SELECT id
                                                FROM osvisitors_inworld
                                                WHERE (
                                                    useruuid = ?
                                                    AND regionname = ?
                                                )
                                            ");

                                            $query->bindValue(1, $uuid, PDO::PARAM_STR);
                                            $query->bindValue(2, $region, PDO::PARAM_STR);

                                            $query->execute();
                                            $counter = $query->rowCount();

                                            if ($counter == 0)
                                            {
                                                $query = $db->prepare("
                                                    INSERT INTO osvisitors_inworld (
                                                        username, 
                                                        useruuid,
                                                        gender,
                                                        language,
                                                        ip,
                                                        hostname, 
                                                        gridname, 
                                                        regionname, 
                                                        parcelname, 
                                                        counter, 
                                                        firstvisit,
                                                        lastvisit
                                                    )
                                                    VALUES (
                                                        :username,
                                                        :useruuid,
                                                        :gender,
                                                        :language,
                                                        :ip,
                                                        :hostname,
                                                        :gridname, 
                                                        :regionname,
                                                        :parcelname,
                                                        :counter,
                                                        :firstvisit,
                                                        :lastvisit
                                                    )
                                                ");

                                                $query->bindValue(':username', $name, PDO::PARAM_STR);
                                                $query->bindValue(':useruuid', $uuid, PDO::PARAM_STR);
                                                $query->bindValue(':gender', $gender, PDO::PARAM_STR);
                                                $query->bindValue(':language', $lang, PDO::PARAM_STR);
                                                $query->bindValue(':ip', $ip, PDO::PARAM_STR);
                                                $query->bindValue(':hostname', $hostname, PDO::PARAM_STR);
                                                $query->bindValue(':gridname', $grid, PDO::PARAM_STR);
                                                $query->bindValue(':regionname', $region, PDO::PARAM_STR);
                                                $query->bindValue(':parcelname', $parcel, PDO::PARAM_STR);
                                                $query->bindValue(':counter', '1', PDO::PARAM_INT);
                                                $query->bindValue(':firstvisit', $timestamp, PDO::PARAM_STR);
                                                $query->bindValue(':lastvisit', $timestamp, PDO::PARAM_STR);

                                                $query->execute();
                                                $query = null;
                                                exit();
                                            }

                                            else
                                            {
                                                // UPDATE
                                                $query = $db->prepare("
                                                    UPDATE osvisitors_inworld
                                                    SET counter = counter + 1, 
                                                        gender = :gender, 
                                                        language = :language, 
                                                        ip = :ip,
                                                        hostname = :hostname, 
                                                        gridname = :gridname, 
                                                        regionname = :regionname, 
                                                        parcelname = :parcelname, 
                                                        lastvisit = :lastvisit 
                                                    WHERE (
                                                        useruuid = :useruuid 
                                                        AND
                                                        hostname = :hostname 
                                                        AND
                                                        gridname = :gridname 
                                                        AND
                                                        regionname = :regionname 
                                                        AND
                                                        parcelname = :parcelname
                                                    )
                                                ");

                                                $query->bindValue(':gender', $gender, PDO::PARAM_STR);
                                                $query->bindValue(':language', $lang, PDO::PARAM_STR);
                                                $query->bindValue(':ip', $ip, PDO::PARAM_STR);
                                                $query->bindValue(':hostname', $hostname, PDO::PARAM_STR);
                                                $query->bindValue(':gridname', $grid, PDO::PARAM_STR);
                                                $query->bindValue(':regionname', $region, PDO::PARAM_STR);
                                                $query->bindValue(':parcelname', $parcel, PDO::PARAM_STR);
                                                $query->bindValue(':lastvisit', $timestamp, PDO::PARAM_STR);
                                                $query->bindValue(':useruuid', $uuid, PDO::PARAM_STR);

                                                $query->execute();
                                                $query = null;
                                                exit();
                                            }
                                        }
                                        else echo "Empty grid detected ...";
                                    }
                                    else echo "Empty parcel detected ...";
                                }
                                else echo "Empty region detected ...";
                            }
                            else echo "Empty object detected ...";
                        }
                        else echo "Empty ip detected ...";
                    }
                    else echo "Empty language detected ...";
                }
                else echo "Empty gender detected ...";
            }
            else echo "Empty uuid detected ...";
        }
        else echo "Empty name detected ...";
    }
    else echo "Invalid terminal name ...";
}
else echo "No direct access ...";
?>
