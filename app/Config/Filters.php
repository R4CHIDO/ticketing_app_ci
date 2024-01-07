<?php

namespace Config;

use App\Filters\AdminFilter as FiltersAdminFilter;
use App\Filters\ClientFilter as FiltersClientFilter;
use App\Filters\LoggedFilter as FiltersLoggedFilter;
use App\Filters\LoginFilter as FiltersLoginFilter;
use App\Filters\TechnicienFilter as FiltersTechnicienFilter;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use CodeIgniter\Filters\AdminFilter;
use CodeIgniter\Filters\TechnicienFilter;
use CodeIgniter\Filters\LoginFilter;
use CodeIgniter\Filters\LoggedFilter;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'admin'         => FiltersAdminFilter::class,
        'tech'          => FiltersTechnicienFilter::class,
        'client'        => FiltersClientFilter::class,
        'login'         => FiltersLoginFilter::class,
        'logged'        => FiltersLoggedFilter::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [
        'admin'   => ['before' => [ 'tickets/displayAllTickets/*' , 'admin/*']],
        'tech'    => ['before' => [ 'tickets/TicketsByTechs/' , 'tickets/updateForm/*' , 'tickets/TicketsByTechs/']],
        'client'  => ['before' => [ '/tickets/displayTicketsByStatus/*' , 'tickets/index/' , 'tickets/createTicket/']],
        'login'   => ['before' => [ '/tickets/*' , 'tickets/index/' ,''  , 'admin/*']],
        'logged'  => ['before' => [ '/login/signinForm' , '/login/signupForm' ,'/login/signup','/login/signin']]
    ];
}
