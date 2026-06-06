<?php

use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;
use Bugsnag\BugsnagLaravel\BugsnagServiceProvider;

return [
    AppServiceProvider::class,
    FortifyServiceProvider::class,
    BugsnagServiceProvider::class,
];
