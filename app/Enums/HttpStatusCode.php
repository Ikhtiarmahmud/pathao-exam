<?php

namespace App\Enums;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class HttpStatusCode
{
    const SUCCESS = 200;

    const CREATED = 201;

    const BAD_REQUEST = 400;

    const VALIDATION_ERROR = 422;
    const ACCEPTED = 202;

    const UNAUTHORIZED = 401;

    const FORBIDDEN = 403;

    const NOT_FOUND = 404;

    const INTERNAL_ERROR = 500;

    const MULTIPLE_RESP = 207;

    const SERVICE_UNAVAILABLE = 503;

    const UNPROCESSABLE_ENTITY = 422;
}
