<?php

/**
 * Class WhatsApi
 * @package kreate\WhatsApi
 */


abstract class WhatsApi{

        /** @var string $endpoint endpoint for sendtext or image, file etc */
        private $endpoint;

        /** @var string $apiUser username for whatsapi */
        private $apiUser;

        /** @var string $apiKey whatsapi key for user */
        private $apiKey;

        /** @var string $file file location for send */
        private $file;

        /** @var string $mensage mensage to send */
        private $mensage;

        /** @var string $phone destination number with internacional code without + or 00 */
        private $phone;

    public function __construct(string $apiUser, string $apiKey)
    {

        //$this->apiUrl="https://api.whatsapi.pt/v0.1/";
        $this->apiUrl="http://whatsapi.pt/curlapi/index.php";        
        $this->apiUser=$apiUser;
        $this->apiKey=$apiKey;

    }

    public function send(string $endpoint,string $phone, string $mensage, string $file = ""): WhatsApi
    {
		$apiData= [ 
            "endpoint" => $this->endpoint,
            "phone" => $this->phone,
            "file" => $this->file,
            "mensage" => $this->mensage
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $this->apiUrl,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>json_encode($apiData),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($this->apiUser . ':' . $this->apiKey)
          )
        ));  
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl));
        }
        curl_close($curl);
        return json_decode($response, true);
    }
}
