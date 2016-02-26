<?php

namespace Cliffom\Tokenex;

class Tokenex
{
    private $api_base_url;
    private $id;
    private $api_key;

    public function __construct($api_base_url = '', $id = '', $api_key = '')
    {
        $this->api_base_url = $api_base_url;
        $this->id = $id;
        $this->api_key = $api_key;
    }

    public function token_from_ccnum($ccnum)
    {
        return $this->tokenize($ccnum, TokenScheme::TOKENfour);
    }

    public function tokenize($data, $tokenScheme = TokenScheme::GUID)
    {
        $requestParams = [
            RequestParams::Data => $data,
            RequestParams::TokenScheme => $tokenScheme
        ];

        return $this->sendRequest(TokenAction::Tokenize, $requestParams);
    }

    public function tokenize_from_encrypted_value($encrypted_data, $token_scheme)
    {
        $requestParams = [
            RequestParams::EncryptedData => $encrypted_data,
            RequestParams::TokenScheme => $token_scheme
        ];

        return $this->sendRequest(TokenAction::TokenizeFromEncryptedValue, $requestParams);
    }

    public function detokenize($token)
    {
        $requestParams = [
            RequestParams::Token => $token
        ];

        return $this->sendRequest(TokenAction::Detokenize, $requestParams);
    }

    public function validate_token($token)
    {
        $requestParams = [
            RequestParams::Token => $token
        ];

        return $this->sendRequest(TokenAction::ValidateToken, $requestParams);
    }

    public function delete_token($token)
    {
        $requestParams = [
            RequestParams::Token => $token
        ];

        return $this->sendRequest(TokenAction::DeleteToken, $requestParams);
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

    private function sendRequest($action, $data)
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

        return $jsonResult[$action['Key']];
    }
}
