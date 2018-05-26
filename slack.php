#!/usr/bin/php
<?php
// slack.io webhooker to hooker you way into slack
// declare room
$room="";
// where am i!
$path="/root/scripts";
// You can get your very own webhook endpoint here -- https://my.slack.com/services/new/incoming-webhook/
// The file defined below should contain a single variable called $slackkey.  Like this ---
//////////////////
// <?php
//$slackkey = "https://hooks.slack.com/services/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";
//?>
//////////////////
include ("/root/scripts/.slackkey");

// $argv[0] is path and scriptname 
if (count($argv) < 5) {
        echo "Error, I'm expecting 4 parameters\n";
        echo "slack.io [bot name] [emojii (no colons)] [(#/@)Channel or User] \"[message]\"\n";
        exit;
}

//slack goo
$channel=$argv[3];
$emoji=":" . $argv[2] . ":";
$botname=$argv[1];
$msg=$argv[4];
$message=str_replace("&", "and", $msg);

/*====== START THE RODEO ====== */
// setup emoji and bot name.  build $data payload
$room = ($room) ? $room : $channel;
$data = "payload=" . json_encode(array(
        "channel"       =>  "{$room}",
        "username"      =>  $botname,
        "text"          =>  $message,
        "icon_emoji"    =>  $emoji
         ));

// excute slack API call to incoming webhook
$ch = curl_init($slackkey);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

?>
