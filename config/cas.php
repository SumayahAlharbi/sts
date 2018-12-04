<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CAS Hostname
    |--------------------------------------------------------------------------
    | Example: 'cas.example.com'.
    */
    'cas_hostname' => env('CAS_HOSTNAME', 'cas.ksau-hs.edu.sa'),

    /*
    |--------------------------------------------------------------------------
    | CAS Authorized Hosts
    |--------------------------------------------------------------------------
    | Example: 'cas.example.com'.  This is used when SAML is active and is
    | recommended for protecting against DOS attacks.  If using load
    | balanced hosts, then separate each with a comma.
    */
    'cas_real_hosts' => env('CAS_REAL_HOSTS', env('CAS_HOSTNAME', 'cas.ksau-hs.edu.sa')),


    /*
    |--------------------------------------------------------------------------
    | Customize CAS Session Cookie Name
    |--------------------------------------------------------------------------
    */
    'cas_session_name' => env('CAS_SESSION_NAME', 'CASAuth'),

    /*
    |--------------------------------------------------------------------------
    | This will cause CAS to skip authentication and assume this user id.
    | This should only be used for developmental purposes.  getAttributes()
    | will return null in this condition.
     */
    'cas_session_lifetime' => env('CAS_SESSION_LIFETIME', 7200),

    /*
    |--------------------------------------------------------------------------
    | This will cause CAS to skip authentication and assume this user id.
    | This should only be used for developmental purposes.  getAttributes()
    | will return null in this condition.
     */
    'cas_session_path' => env('CAS_SESSION_PATH', '/'),

    /*
    |--------------------------------------------------------------------------
    | Laravel has it's own authentication sessions. Unless you want phpCAS
    | to manage the session, leave this set to false.  Note that the
    | middleware and redirect classes will be handling removal
    | of the Laravel sessions when this is set to false.
    |--------------------------------------------------------------------------
    */
    'cas_control_session' => env('CAS_CONTROL_SESSIONS', false),

    /*
    |--------------------------------------------------------------------------
    | Enable using this as a cas proxy
    |--------------------------------------------------------------------------
    */
    'cas_proxy' => env('CAS_PROXY', false),

    /*
    |--------------------------------------------------------------------------
    | Cas Port
    |--------------------------------------------------------------------------
    | Usually 443
    */
    'cas_port' => env('CAS_PORT', 443),

    /*
    |--------------------------------------------------------------------------
    | CAS BASE URI
    |--------------------------------------------------------------------------
    | Usually /cas
    */
    'cas_uri' => env('CAS_URI', '/cas'),


    /*
    |--------------------------------------------------------------------------
    | CAS Validation
    |--------------------------------------------------------------------------
    | CAS server SSL validation: 'self' for self-signed certificate, 'ca' for
    | certificate from a CA, empty for no SSL validation.
    |
    | VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL
    */
    'cas_validation' => env('CAS_VALIDATION', ''),

    /*
    |--------------------------------------------------------------------------
    | CA Certificate
    |--------------------------------------------------------------------------
    | Path to the CA certificate file.  For production use set
    | the CA certificate that is the issuer of the cert
    */
    'cas_cert' => env('CAS_CERT', ''),

    /*
    |--------------------------------------------------------------------------
    | CN Validation (if you are using CA certs)
    |--------------------------------------------------------------------------
    | If for some reason you want to disable validating the certificate
    | intermediaries, here is where you can.  Recommended to leave
    | this set with default (true).
    */
    'cas_validate_cn' => env('CAS_VALIDATE_CN', true),

    /*
    |--------------------------------------------------------------------------
    | CAS LOGIN URL OVERRIDE
    |--------------------------------------------------------------------------
    | Usually /cas
    */
    'cas_login_url' => env('CAS_LOGIN_URL', ''),

    /*
    |--------------------------------------------------------------------------
    | CAS LOGOUT URL OVERRIDE
    |--------------------------------------------------------------------------
    */
    'cas_logout_url' => env('CAS_LOGOUT_URL', ''),

    /*
    |--------------------------------------------------------------------------
    | CAS Logout Redirect Services
    |--------------------------------------------------------------------------
    | If your server supports redirection services, enter the redirect url
    | in this section.  If left blank, it will default to disabled.
    */
    'cas_logout_redirect' => env('CAS_LOGOUT_REDIRECT', 'https://cas.ksau-hs.edu.sa/cas/logout'),

    /*
    |--------------------------------------------------------------------------
    | CAS Successful Logon Redirection Url
    |--------------------------------------------------------------------------
    | By default, CAS will assume that the user should be redirected to the
    | page in which the call was initiated.  You can override this method
    | and force the user to be redirected to a specific URL here.
    */
    'cas_redirect_path' => env('CAS_REDIRECT_PATH', ''),

    /*
    |--------------------------------------------------------------------------
    | CAS Supports SAML 1.1, allowing you to retrieve more than just the
    | user identifier.  If your CAS authentication service supports
    | this feature, you may be able to retrieve user meta data.
    |--------------------------------------------------------------------------
    */
    'cas_enable_saml' => env('CAS_ENABLE_SAML', true),

    /*
    |--------------------------------------------------------------------------
    | Enable PHPCas Debug Mode
    | Options are:
    | 1) true (defaults logfile creation to /tmp/phpCAS.log)
    | 2) 'path/to/logfile'
    | 3) false
    |--------------------------------------------------------------------------
    */
    'cas_debug' => env('CAS_DEBUG', false),


    /*
    |--------------------------------------------------------------------------
    | Enable Verbose error messages. Not recommended for production.
    | true | false
    |--------------------------------------------------------------------------
    */
    'cas_verbose_errors' => env('CAS_VERBOSE_ERRORS', false),

    /*
    |--------------------------------------------------------------------------
    | This will cause CAS to skip authentication and assume this user id.
    | This should only be used for developmental purposes.  getAttributes()
    | will return null in this condition.
     */
    'cas_masquerade' => env('CAS_MASQUERADE', ''),

    /*
    |--------------------------------------------------------------------------
    | Enable service to be proxied
    |--------------------------------------------------------------------------
    |
    | Example:
    | phpCAS::allowProxyChain(new CAS_ProxyChain(array(
    |                                 '/^https:\/\/app[0-9]\.example\.com\/rest\//',
    |                                 'http://client.example.com/'
    |                         )));
    | For the exemple above:
    |   'cas_proxied_services' => array('/^https:\/\/app[0-9]\.example\.com\/rest\//','http://client.example.com/'),
    */
    'cas_proxied_services' => array(),

    'cas_user_mapper' => App\LaravelUserMapper::class,
];
