<?php

namespace EasySwoole\WeChat\Tests\Mock\Message;


class Status
{
    // Informational 1xx
    const CODE_CONTINUE = 100;
    const CODE_SWITCHING_PROTOCOLS = 101;
    const CODE_PROCESSING = 102;            // RFC2518
    const CODE_EARLY_HINTS = 103;           // RFC8297
    // Success 2xx
    const CODE_OK = 200;
    const CODE_CREATED = 201;
    const CODE_ACCEPTED = 202;
    const CODE_NON_AUTHORITATIVE_INFORMATION = 203;
    const CODE_NO_CONTENT = 204;
    const CODE_RESET_CONTENT = 205;
    const CODE_PARTIAL_CONTENT = 206;
    const CODE_MULTI_STATUS = 207;          // RFC4918
    const CODE_ALREADY_REPORTED = 208;      // RFC5842
    const CODE_IM_USED = 226;               // RFC3229
    // Redirection 3xx
    const CODE_MULTIPLE_CHOICES = 300;
    const CODE_MOVED_PERMANENTLY = 301;
    const CODE_MOVED_TEMPORARILY = 302;
    const CODE_SEE_OTHER = 303;
    const CODE_NOT_MODIFIED = 304;
    const CODE_USE_PROXY = 305;
    const CODE_RESERVED = 306;
    const CODE_TEMPORARY_REDIRECT = 307;
    const CODE_PERMANENTLY_REDIRECT = 308;  // RFC7238
    // Client Error 4xx
    const CODE_BAD_REQUEST = 400;
    const CODE_UNAUTHORIZED = 401;
    const CODE_PAYMENT_REQUIRED = 402;
    const CODE_FORBIDDEN = 403;
    const CODE_NOT_FOUND = 404;
    const CODE_METHOD_NOT_ALLOWED = 405;
    const CODE_NOT_ACCEPTABLE = 406;
    const CODE_PROXY_AUTHENTICATION_REQUIRED = 407;
    const CODE_REQUEST_TIMEOUT = 408;
    const CODE_CONFLICT = 409;
    const CODE_GONE = 410;
    const CODE_LENGTH_REQUIRED = 411;
    const CODE_PRECONDITION_FAILED = 412;
    const CODE_REQUEST_ENTITY_TOO_LARGE = 413;
    const CODE_REQUEST_URI_TOO_LONG = 414;
    const CODE_UNSUPPORTED_MEDIA_TYPE = 415;
    const CODE_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const CODE_EXPECTATION_FAILED = 417;
    const CODE_I_AM_A_TEAPOT = 418;                                               // RFC2324
    const CODE_MISDIRECTED_REQUEST = 421;                                         // RFC7540
    const CODE_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    const CODE_LOCKED = 423;                                                      // RFC4918
    const CODE_FAILED_DEPENDENCY = 424;                                           // RFC4918
    const CODE_TOO_EARLY = 425;                                                   // RFC-ietf-httpbis-replay-04
    const CODE_UPGRADE_REQUIRED = 426;                                            // RFC2817
    const CODE_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    const CODE_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    const CODE_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    const CODE_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    // Server Error 5xx
    const CODE_INTERNAL_SERVER_ERROR = 500;
    const CODE_NOT_IMPLEMENTED = 501;
    const CODE_BAD_GATEWAY = 502;
    const CODE_SERVICE_UNAVAILABLE = 503;
    const CODE_GATEWAY_TIMEOUT = 504;
    const CODE_HTTP_VERSION_NOT_SUPPORTED = 505;
    const CODE_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    const CODE_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    const CODE_LOOP_DETECTED = 508;                                               // RFC5842
    const CODE_BANDWIDTH_LIMIT_EXCEEDED = 509;
    const CODE_NOT_EXTENDED = 510;                                                // RFC2774
    const CODE_NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585

    /** @deprecated Use CODE_REQUEST_ENTITY_TOO_LARGE */
    const CODE_REQUIRED_ENTITY_TOO_LARGE = 413;

    private static $phrases = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        103 => 'Early Hints',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',    // RFC7238
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        421 => 'Misdirected Request',                                         // RFC7540
        422 => 'Unprocessable Entity',                                        // RFC4918
        423 => 'Locked',                                                      // RFC4918
        424 => 'Failed Dependency',                                           // RFC4918
        425 => 'Too Early',                                                   // RFC-ietf-httpbis-replay-04
        426 => 'Upgrade Required',                                            // RFC2817
        428 => 'Precondition Required',                                       // RFC6585
        429 => 'Too Many Requests',                                           // RFC6585
        431 => 'Request Header Fields Too Large',                             // RFC6585
        451 => 'Unavailable For Legal Reasons',                               // RFC7725
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',                                     // RFC2295
        507 => 'Insufficient Storage',                                        // RFC4918
        508 => 'Loop Detected',                                               // RFC5842
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',                                                // RFC2774
        511 => 'Network Authentication Required',                             // RFC6585
    ];

    static function getReasonPhrase($statusCode):?string
    {
        if(isset(self::$phrases[$statusCode])){
            return self::$phrases[$statusCode];
        }else{
            return null;
        }
    }
}
