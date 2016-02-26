<?php

namespace spec\Cliffom\Tokenex;

use PhpSpec\ObjectBehavior;
use Cliffom\Tokenex\TokenScheme;

class TokenexSpec extends ObjectBehavior
{
    public function let()
    {
        $tokenex_api_base_url = getenv('TOKENEX_API_BASE_URL');
        $tokenex_api_key = getenv('TOKENEX_API_KEY');
        $tokenex_id = getenv('TOKENEX_ID');
        $this->beConstructedWith(
            $tokenex_api_base_url,
            $tokenex_id,
            $tokenex_api_key
        );

        $this->shouldHaveType('Cliffom\Tokenex\Tokenex');
    }

    public function it_returns_a_valid_token_from_a_valid_credit_card_number()
    {
        $cc_number = "4242424242424242";
        $token = $this->token_from_ccnum($cc_number);
        $this->validate_token($token)
            ->shouldReturn(true);
        $this->detokenize($token)
            ->shouldReturn($cc_number);
        $this->delete_token($token)
            ->shouldReturn(true);
    }

    public function it_tokenizes_encrypted_data()
    {
        $encrypted_value = 'FWOd2HUAI+AYfaC3PKAz4dugByBdd+fEAzFfg/G41UuM8yFK23qoq8oD6CURF5WZpXPXySYbN8XvRM6Pd8dfQCTcSQdGiSBfD+Csv39XbOS/laAIekYsPav/eAnY+tNAV7sGUvtqOnDDr0H9W6Q8Z6nqL0rdezCIDY7DuNcOUZxPsv4EV2djG75c9oXI7rPUa/CtIxp1GOCkPYhkV4pv6sxoYOBAJ2KrMDgzlZS9UWQE5x346Jc8ixEOA0bWItTcXUW8/hITYAlM1mTKqRX/Er7Mag2uBrpNM/t5HNtw/zVNgwc8S4ltvm7ow3IG98K2cDpEi16ly2QuMiL5Iq8ghw==';
        $token = $this->tokenize_from_encrypted_value($encrypted_value, TokenScheme::sixTOKENfour);
        $this->validate_token($token)
            ->shouldReturn(true);
        $this->detokenize($token)
            ->shouldReturn("4242424242424242");
        $this->delete_token($token)
            ->shouldReturn(true);
    }
}
