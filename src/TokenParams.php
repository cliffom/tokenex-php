<?php

namespace Cliffom\Tokenex;

class TokenParams
{
    const RequestParams = [
        'APIKey'        => 'APIKey',
        'Data'          => 'Data',
        'EncryptedData' => 'EcryptedData',
        'Token'         => 'Token',
        'TokenExID'     => 'TokenExID',
        'TokenScheme'   => 'TokenScheme'
    ];

    const ResponseParams = [
        'Token'             => 'Token',
        'Success'           => 'Success',
        'ReferenceNumber'   => 'ReferenceNumber',
        'Error'             => 'Error',
        'Valid'             => 'Valid',
        'Value'             => 'Value'
    ];
}
