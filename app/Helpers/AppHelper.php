<?php

	  function getallCountries(){ 
    //$url = 'https://api.islamichelp.net/v2/country?apikey=$2y$12$qX0oHMOQgdAwUdJD9ToZRurpO1FuLFtA6Uo723ubIkerKoJ5SNf9K';
        $url = config('config.ICHARM_API_URL').'/v2/country?apikey='.config('config.ICHARM_API_KEY');
         $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);  
        $dataAr = json_decode($response, TRUE);
        return $dataAr['data'];
    } 

     function getProgramList(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('config.ICHARM_API_URL').'/v2/program?apikey='.config('config.ICHARM_API_KEY'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $dataAr = json_decode($result, TRUE);
        return $dataAr['data']; 
    } 
?>