<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
// require_once('PHPExcel.php');

class Api_Whatsapp {
    function wa_notif($msgg,$phonee)
    {
    $phone = $phonee;
    $msg = $msgg;
    
    $sender = "embunpagi";
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://ljn.fantecno.net/cron/send',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'key='.$sender.'&phone='.$phone.'&msg='.$msgg,
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
    }
}