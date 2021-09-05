<?php 
namespace Config;

use App\Filters\JWTAuthenticationFilter;
use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    public $aliases = [
        'csrf' => CSRF::class,
        'toolbar' => DebugToolbar::class,
        'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'auth' => JWTAuthenticationFilter::class // add this line
    ];

    // global filters
    // method filters
    public $filters = [
      'auth' => [
        'before' => [
            'client/*',
            'client'
      ],
    ]
  ];
}
