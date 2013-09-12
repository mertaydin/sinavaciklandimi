<?php


    function curlBaglantisiYap($url)
    {
        setlocale(LC_ALL,'turkish');

        $curl=curl_init(); 
        curl_setopt($curl,CURLOPT_URL,$url); 
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1); 
        curl_setopt($curl,CURLOPT_USERAGENT,"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)");
        $header=array("Accept:*/*","Connection:Keep Alive");
        curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
        curl_setopt($curl,CURLOPT_ENCODING,'gzip,deflate');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        
        $data=curl_exec($curl);  

        return $data;      

    }
    
    
    $osym =  curlBaglantisiYap("https://sonuc.osym.gov.tr/");
    
    preg_match_all('/<td><a[\s]*href="(.*?)"(.*?)<\/a><\/td>/', $osym, $matches);
    
    $varmi=0;
    foreach($matches[2] as $sezgin)
    {
        preg_match_all('/Maliye/', $sezgin, $match);
        //print_r($match);
        $varmi = (int)in_array('Maliye', $match[0]);
        
        if($varmi==1)
            break;
            
        if($varmi==0)
            continue;

    
    }
    
    
    
if($varmi == 0)
{

    include 'class.phpmailer.php';
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'gonderici@gmail.com';
    $mail->Password = 'gonericiSifre';
    $mail->SetFrom($mail->Username, 'Sezgin');
    $mail->AddAddress('alici@falan.com', 'Sezgin');
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Sonuçlar açıklandı! ÖSYM';
    $mail->MsgHTML('<h1>Müjde müjde, sonuçlar açıklandı!!!</h1>');
    if($mail->Send()) {
        echo 'Mail gönderildi!';
    } else {
        echo 'Mail gönderilirken bir hata oluştu: ' . $mail->ErrorInfo;
    }
    
}

?>