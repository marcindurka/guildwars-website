<?php
class apigw2{
    public function api($content,$apikey){
        stream_context_set_default(array('http' => array('ignore_errors' => true)));
        $check= file_get_contents("https://api.guildwars2.com/v2/".$content."?access_token=".$apikey);
        $answer = json_decode($check,true);
    return $answer;
    }
    
    public function apiopen($content,$id){
        stream_context_set_default(array('http' => array('ignore_errors' => true)));
        $check= file_get_contents("https://api.guildwars2.com/v2/".$content."/".$id);
        $answer = json_decode($check,true);
    return $answer;
    }
     
    public function validate_apikey($apikey){
        $apikeyinfo=array(
          'name'        => 'No key',
          'account'     => 0,
          'inventories' => 0,
          'characters'  => 0,
          'tradingpost' => 0,
          'wallet'      => 0,
          'unlocks'     => 0,
          'pvp'         => 0,
          'builds'      => 0,
          'progression' => 0,
          'guilds'      => 0
        );
        stream_context_set_default(array('http' => array('ignore_errors' => true)));
        $check = json_decode(file_get_contents("https://api.guildwars2.com/v2/tokeninfo?access_token=".$apikey),true);
        //$i=0;
        if (isset($check['id'])){
            $apikeyinfo['name']=$check['name'];
            foreach ($check['permissions'] as $checkpermissions){
                if (isset($checkpermissions)){
                    $apikeyinfo[($checkpermissions)]=1;
                }else{
                    $apikeyinfo[($checkpermissions)]=0;
                }
                //echo $apikeyinfo[$checkpermissions]."|".$checkpermissions."<br/>";
                //$i++;
            }
        }
        return $apikeyinfo;
    } 
}

/*
 * account =        0A146268-B8E1-1040-9A14-5F39F6D2A8BB0AB0D48F-E464-4A85-8971-6BCEAF30383D
 * inventories =    B8EF5913-EC95-BD4C-98F5-CEC51092B216EDAE9877-F8F5-4F70-8193-07C7302FA716
 * characters =     3DB55348-30C6-484D-8D06-11259F465890AADD82F1-1351-4991-8A53-3F176DE6BAF5
 * tradingpost =    05C33DF6-885D-A946-9592-FD7C5F52C1D4EC2D3D4E-5E83-4B86-BB1F-C60495F9B487
 * wallet =         2CE86F75-5614-544E-AB9C-8745E19FDC94A0ED1816-E1EC-492C-8ED5-AF490D1D4F70
 * unlocks =        7F61C086-698D-4445-A4EA-4FA5C049CB79FA3DA3DA-9B8D-4E1B-AF62-EC1BC6F673AE
 * pvp =            B7FAA918-7335-044C-8B39-92FB2D6B21B33289E257-28CB-4BDC-96F9-9B30071845F3
 * builds =         799334A1-00F4-A84C-ACDF-F8ECC29FBBCBC53591AA-899F-4AA6-86C7-CDDE8525D731
 * progression =    68B0F406-4A3B-E645-8344-DA9B418D2F9AE337AC4F-3077-4EF7-BC15-9D7603B0741E
 * guilds =         D01384CD-582B-1B49-807C-986E444628D9C7F5A695-F1A7-4998-82BA-F108D2883B2E
 * all =            40E7132E-DBFA-D940-ABFC-D11BF4F68D75C0A46CF7-6B6F-41B6-B666-0963B7B184D6
 */