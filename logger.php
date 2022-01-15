<?php
date_default_timezone_set("Europe/Moscow");
include "db_settings.php";

function getID($number) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $number; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
function getInfoBrowser(){
    $agent = $_SERVER['HTTP_USER_AGENT'];
    preg_match("/(MSIE|Opera|Firefox|Chrome|Version)(?:\/| )([0-9.]+)/", $agent, $bInfo);
    $browserInfo = array();
    $browserInfo['name'] = ($bInfo[1]=="Version") ? "Safari" : $bInfo[1];
    $browserInfo['version'] = $bInfo[2];     
    return $browserInfo;
}

function onProxy(){
    if(file_get_contents("https://blackbox.ipinfo.app/lookup/" . $_SERVER['REMOTE_ADDR']) == "Y"){
        return "да";
    }else{
        return "нет";
    }
}

function getOS($user_agent) { 
    $os_platform  = "Unknown OS";
    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

include("db_settings.php");

$ip = $_SERVER['REMOTE_ADDR'];
$getip = json_decode(file_get_contents("http://ip-api.com/json/".$ip. "?fields=192511&lang=ru"));
$city = $getip->country . " (" . $getip->countryCode . ")". ", " .$getip->city;
if($getip->country == ""){
	$city = "Ошибка";
}
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$browser = getInfoBrowser();
$browser = $browser['name'];
$os = getOS($user_agent);
$id = getID(16);

/* Write info to database */

$conn = new mysqli($host, $user, $password, $db);

$user_bd = "SELECT * FROM `banned` WHERE ip = '$ip'";
$ress = $conn->query($user_bd);
if (mysqli_num_rows($ress) == 0){
} else {
die("Вы забанены");
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "error";
} 
$onproxy = onProxy();
$vowels = array("\"", "\\", "'");
$isp = str_replace($vowels, "", $getip->isp);

$date = date('d/m/Y h:i:s a', time());


$user_bd = "SELECT * FROM ip_logger WHERE ip = '$ip'";
$ress = $conn->query($user_bd);
if (mysqli_num_rows($ress) == 0){
$sql = "INSERT INTO `$table`(`id`, `ip`, `browser`, `system`, `city`, `user_agent`, `date`, `proxy`, `isp`) VALUES ('$id', '$ip', '$browser', '$os', '$city', '$user_agent','$date', '$onproxy', '$isp')";
$res = $conn->query($sql);
$conn-> close();
} else {

}
?>