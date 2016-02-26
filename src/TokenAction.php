<?php

namespace Cliffom\Tokenex;

class TokenAction
{
    const Tokenize = [
        'Name' => 'Tokenize',
        'Key' => 'Token'
    ];

    const TokenizeFromEncryptedValue = [
        'Name' => 'TokenizeFromEncryptedValue',
        'Key' => 'Token'
    ];

    const ValidateToken = [
        'Name' => 'ValidateToken',
        'Key' => 'Valid'
    ];

    const Detokenize = [
        'Name' => 'Detokenize',
        'Key' => 'Value'
    ];

    const DeleteToken = [
        'Name' => 'DeleteToken',
        'Key' => 'Success'
    ];
}
