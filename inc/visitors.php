<?php
// From Inword Script (todo: base64_decode)
if (!isset($_POST['terminal']) || empty($_POST['terminal'])) {
    echo "No direct access ...";
}
else if (htmlspecialchars($_POST['terminal']) !== "visitors") {
    echo "Invalid terminal name ...";
}
else if (!isset($_POST['name']) || empty($_POST['name'])) {
    echo "Empty name detected ...";
}
else if (!isset($_POST['uuid']) || empty($_POST['uuid'])) {
    echo "Empty uuid detected ...";
}
else if (!isset($_POST['gender']) || empty($_POST['gender'])) {
    echo "Empty gender detected ...";
}
else if (!isset($_POST['lang']) || empty($_POST['lang'])) {
    echo "Empty language detected ...";
}
else if (!isset($_POST['ip']) || empty($_POST['ip'])) {
    echo "Empty ip detected ...";
}
else if (!isset($_POST['object']) || empty($_POST['object'])) {
    echo "Empty object detected ...";
}
else if (!isset($_POST['region']) || empty($_POST['region'])) {
    echo "Empty region detected ...";
}
else if (!isset($_POST['parcel']) || empty($_POST['parcel'])) {
    echo "Empty parcel detected ...";
}
else if (!isset($_POST['grid']) || empty($_POST['grid'])) {
    echo "Empty grid detected ...";
}
else {
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
    $country = '';

    // NOT USED YET BUT SEND BY INWORD SCRIPT
    // $nick    = htmlspecialchars($_POST['nick']);

    if ($name == "") {
        $name = "Unknow";
    }

    echo "Hello  ".$name.", thank you for visiting ".$parcel." on region ".$region;

    $timestamp  = time();
    $hostname   = $host;

    try {
        // retrieve country
        if ($geoipservice != "" && $geoip_apikey != "") {
          $url = $geoipservice.$ip."?access_key=".$geoip_apikey;
          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          $geoip_resp = curl_exec($ch);
          curl_close($ch);
        
          $geoip_data = json_decode($geoip_resp);
          if (!isset($geoip_data->{'country_code'})) {
            throw new Exception("country_code empty");
          }
          $country = $geoip_data->{'country_code'};
        }

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

        if ($counter == 0) {
            $query = $db->prepare("
                INSERT INTO osvisitors_inworld (
                    username, 
                    useruuid,
                    gender,
                    language,
                    ip,
                    country,
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
                    :country,
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
            $query->bindValue(':country', $country, PDO::PARAM_STR);
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
        else {
            // UPDATE
            $query = $db->prepare("
                UPDATE osvisitors_inworld
                SET counter = counter + 1, 
                    gender = :gender, 
                    language = :language, 
                    ip = :ip,
                    country = :country,
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
            $query->bindValue(':country', $country, PDO::PARAM_STR);
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
    catch (PDOException $e) {
        $message = '
            <pre>
                Problem with mysql ...
                Error code: '.$e->getCode().'
                Error file: '.$e->getFile().'
                Error line: '.$e->getLine().'
                Error data: '.$e->getMessage().'
            </pre>
        ';
        die($message);
    }
}
?>
