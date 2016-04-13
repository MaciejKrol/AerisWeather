<?php 

/* 
    Aeris Weather 
    http://www.aerisweather.com/support/docs/api/getting-started/
*/

namespace maciejkrol\AerisWeather;

class AerisWeather {
    
    private $cliendID;
    private $clientSecret;
    
    public function __construct ($_cliendID, $_clientSecret) {
     
        $this->cliendID     = $_cliendID;
        $this->clientSecret = $_clientSecret;
    }
    
    private $endpoint = null;

    public function endpoint ($_endpoint = null) {
        if ($_endpoint === null) {
            return $this->endpoint;
        } else {
            $this->endpoint = $_endpoint;            
            return $this;
        }
    }
    
    private $action = null;
    
    public function action ($_action = null) {
        if ($_action === null) {
            return $this->action;
        } else {    
            $this->action = $_action;        
            return $this;
        }
    }

    public function request ($_args) {
                
        $url = $this->buildURL($_args); 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
	    
        $data = curl_exec($curl);
        curl_close($curl);

        $result = json_decode ($data, true);
        
        return $result;
    }
    
    private function buildURL ($_args) {

        $url = 'http://api.aerisapi.com/'
            .$this->endpoint ().'/'
            .$this->action ().'?'
            .'client_id='.$this->cliendID.'&'
            .'client_secret='.$this->clientSecret.'&';
        
        foreach ($_args as $key => $value) {
            $url .= $key.'='.$value.'&';
        }
        
        return $url;
    }    
}




				