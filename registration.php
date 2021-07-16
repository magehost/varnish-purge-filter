<?php

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'MageHost_VarnishPurgeFilter',
    __DIR__
);
