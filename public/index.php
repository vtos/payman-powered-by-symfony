<?php

use Payman\Infrastructure\Framework\Kernel as FrameworkKernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new FrameworkKernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
