<?php
error_reporting(E_ERROR);
function request($url, $data = null, $headers = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if($data):
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    endif;
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if($headers):
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 1);
    endif;

    curl_setopt($ch, CURLOPT_ENCODING, "GZIP");
    return curl_exec($ch);
}

function kirim_telegram($message)
{
    $token = "1473238136:AAHzAXwr1dQnMFrkcrty-pCvK53YmhM_vUo"; // Isi secret tokennya
    $chatIds = "685065835"; // Isi id telegramnya
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatIds;
    $url = $url . "&text=" . urlencode($message);
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function getstr($str, $exp1, $exp2)
{
    $a = explode($exp1, $str)[1];
    return explode($exp2, $a)[0];
}

echo "Text : ";
$text = trim(fgets(STDIN));
$text = urlencode($text);

$url = "https://rest.quillbot.com/api/paraphraser/single-paraphrase/2?text=$text&strength=2&autoflip=false&wikify=false&fthresh=-1&inputLang=en&quoteIndex=-1";
$headers = array();
$headers[] = "Cookie: connect.sid=s%3Aw273ECI7VGWr-zj6xedu5pqLU4anPUJO.8Z8Oj5xbmF7iWiCmtf2UImeICYeCIg0QWY6cJt16sCc;";
$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0";
$headers[] = "Accept: application/json, text/plain, */*";
$headers[] = "Accept-Language: id,en-US;q=0.7,en;q=0.3";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Useridtoken: undefined";
$headers[] = "Te: trailers";
$paraphraser = request($url, $data = null, $headers);
if(strpos($paraphraser, 'paraphrased succesfully')!==false)
{
    $result = getstr($paraphraser, '"alt":"','"');
    echo "\n\n Result : $result\n";
}
else
{
    echo $paraphraser;
    echo "Error Perphraser\n";
    
}
