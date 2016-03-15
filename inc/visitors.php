<?php
// From Inword Script (todo: base64_decode)
if (isset($_POST['terminal']) && !empty($_POST['terminal']))
{
    if (htmlspecialchars($_POST['terminal']) == "visitors")
    {
        if (isset($_POST['name']) && !empty($_POST['name']))
        {
            if (isset($_POST['object']) && !empty($_POST['object']))
            {
                if (isset($_POST['uuid']) && !empty($_POST['uuid']))
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
                                $region = htmlspecialchars($_POST['region']);
                                $parcel = htmlspecialchars($_POST['parcel']);
                                $grid   = htmlspecialchars($_POST['grid']);
                                $host   = htmlspecialchars($_POST['host']);

                                if ($name == "") {$name = "Unknow";}

                                echo "Hello  ".$name.", thank you for visiting ".$parcel." on region ".$region;

                                $timestamp  = time();
                                $hostname   = $host;

                                $query = $db->prepare("
                                    SELECT id
                                    FROM osvisitors_inworld
                                    WHERE (
                                        useruuid = '".$uuid."'
                                        AND regionname = '".$region."'
                                    )
                                ");

                                $query->execute();
                                $counter = $query->rowCount();

                                if ($counter == 0)
                                {
                                    $query = $db->prepare("
                                        INSERT INTO osvisitors_inworld (
                                            username, 
                                            useruuid, 
                                            hostname, 
                                            gridname, 
                                            regionname, 
                                            parcelname, 
                                            counter, 
                                            timestamp
                                        )
                                        VALUES (
                                            '".$name."',
                                            '".$uuid."',
                                            '".$hostname."',
                                            '".$grid."', 
                                            '".$region."',
                                            '".$parcel."',
                                            1,
                                            '".$timestamp."'
                                        )
                                    ");
                                    $query->execute();
                                    exit();
                                }

                                else
                                {
                                    // UPDATE
                                    $query = $db->prepare("
                                        UPDATE osvisitors_inworld
                                        SET counter = counter + 1, 
                                            hostname = '".$hostname."', 
                                            gridname = '".$grid."', 
                                            regionname = '".$region."', 
                                            parcelname = '".$parcel."', 
                                            timestamp = '".$timestamp."'
                                        WHERE (
                                            useruuid = '".$uuid."'
                                            AND
                                            hostname = '".$hostname."'
                                            AND
                                            gridname = '".$grid."'
                                            AND
                                            regionname = '".$region."'
                                            AND
                                            parcelname = '".$parcel."'
                                        )
                                    ");

                                    $query->execute();
                                    exit();
                                }
                                $query = null;
                            }
                            else echo "Empty Grid detected ...";
                        }
                        else echo "Empty Parcel detected ...";
                    }
                    else echo "Empty Region detected ...";
                }
                else echo "Empty key detected ...";
            }
            else echo "Empty Object detected ...";
        }
        else echo "Empty Name detected ...";        
    }
    else echo "Invalid Terminal name ...";
}
else echo "No direct access ...";
?>
