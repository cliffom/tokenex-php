<?php

namespace Cliffom\Tokenex;

class Tokenizer extends Environment
{
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
}
