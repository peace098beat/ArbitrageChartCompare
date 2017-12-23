<?php


// $r = file_get_contents("assets.json");
$res = file_get_contents("https://api.cryptowat.ch/assets/btc");
if($res == false) {
        echo "[ NG ] error. https://api.cryptowat.ch/assets/btc. die".PHP_EOL;
        die();
    }else{
        echo "[ OK ] GET https://api.cryptowat.ch/assets/btc. ".PHP_EOL;
    }
sleep(3);

$dec = json_decode($res, true);

$n = count($dec["result"]["markets"]["base"]);
// $n = 1;
echo "[ INFO ] Count=".$n.PHP_EOL;


for ($i = 0; $i < $n; $i++) {
    
    $exchange = $dec["result"]["markets"]["base"][$i]["exchange"];
    $pair = $dec["result"]["markets"]["base"][$i]["pair"];
    $route = $dec["result"]["markets"]["base"][$i]["route"];
    
    if($pair != "btcusd") {
        // echo "[ OK ] SKIP.".$route.PHP_EOL;
        continue;
    }
    $url = $route."/ohlc";
    
    

    // $now = time();
    // $after = $now - (24 * 60 * 60); //24h
    $after = strtotime( "-3 hour" ) ; // いまから1時間前のTIMESTAMP
    
    $periods = 180; // 時間足 	60,180,108000
    
    // $url = $url."?periods=".$periods."&after=".$after;
    $url = $url."?after=".$after;
    // echo $url.PHP_EOL;
    
    $res = file_get_contents($url);
    if($res == false) {
        echo "[ NG ] error.".PHP_EOL;
        continue;
    }else{
        echo "[ OK ] GET ".$url.PHP_EOL;
    }
    
    $fname = "data/".$exchange.".json";
    
    $r = file_put_contents($fname, $res);
    if($r){
        echo "[ OK ] Save. ".$fname." Size ".$r."[byte]".PHP_EOL;
    }else{
        echo "[ NG ] Faild save".PHP_EOL;
    }
    
    sleep(5);
}


?>
