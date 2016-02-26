<?php

namespace Cliffom\Tokenex;

use GuzzleHttp\Client;

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
        $httpClient = new Client();
        $response = $httpClient->request('POST',
            $url,
            ['json' => $this->getRequestArray($data)]
        );

        $result = $response->getBody();

        //decode result
        $jsonResult = json_decode($result, true);
        $this->isValidResponse($jsonResult);

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
