<?php

namespace Modules\QBD\;

use App\Providers\AuthServiceProvider;

class QbdAuthProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \Modules\Qbd\Models\Qbd::class => \Modules\Qbd\Policies\QbdPolicy::class,
    ];
}
