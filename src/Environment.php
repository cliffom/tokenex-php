<?php

namespace Cliffom\Tokenex;

class Environment
{
    protected $api_base_url;
    protected $id;
    protected $api_key;

    public $error;
    public $reference_number;

    public function __construct($api_base_url = '', $id = '', $api_key = '')
    {
        $this->api_base_url = $api_base_url;
        $this->id = $id;
        $this->api_key = $api_key;
    }

    private function getRequestArray($data)
    {
        return array_merge(
            [
                RequestParams::APIKey => $this->api_key,
                RequestParams::TokenExID => $this->id
            ],
            $data
        );
    }

    protected function sendRequest($action, $data)
    {
        $url = $this->api_base_url . $action['Name'];
        $json = json_encode($this->getRequestArray($data));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: '.strlen($json),
                'Accept: application/json')
        );

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //call web service
        $result = curl_exec($ch);
        //decode result
        $jsonResult = json_decode($result, true);
        if (!$this->isValidResponse($jsonResult)) {

        }

        return $jsonResult[$action['Key']];
    }

    private function isValidResponse($response)
    {
        $this->error = empty($response[ResponseParams::Error]) ? [] : $this->errorFromResponse($response[ResponseParams::Error]);
        $this->reference_number = empty($response[ResponseParams::ReferenceNumber]) ? '' : $response[ResponseParams::ReferenceNumber];
        return isset($response[ResponseParams::Success]) &&
            $response[ResponseParams::Success] === true;
    }

    private function errorFromResponse($response)
    {
        $responseArray = explode(' : ', $response);
        return [
            'code' => intval($responseArray[0]),
            'message' => $responseArray[1]
        ];
    }
}
