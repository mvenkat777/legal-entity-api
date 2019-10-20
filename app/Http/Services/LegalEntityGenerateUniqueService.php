<?php

namespace App\Http\Services;
use Illuminate\Support\Str;

/**
 * This class provides service to generate unique random number using laravel string helpers
 *  
 */
class LegalEntityGenerateUniqueService
{
    const RANDOM_STRING_LENGTH = 18;
    const RANDOM_INTEGER_START = 10;
    const RANDOM_INTEGER_END = 99;
    const DEFAULT_VERSION = 0;

    /**
     * [generateUniqueLegalEntity generates random string ]
     * @return [string] [returns string]
     */
    public function generateUniqueLegalEntity()
    {
    	$randomString = Str::random(self::RANDOM_STRING_LENGTH);
    	$randomString = Str::upper($randomString);
    	$randomString .= random_int(self::RANDOM_INTEGER_START, self::RANDOM_INTEGER_END);
    	return $randomString;
    }

    /**
     * [defaultLegalEntityVersion configuration of newly created legal entity version ]
     * @return [int] [returns integer]
     */
    public function defaultLegalEntityVersion()
    {
    	return self::DEFAULT_VERSION;
    }
}