<?php

namespace Build\Core\Tests;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\ServiceProvider;
use GrahamCampbell\TestBench\AbstractPackageTestCase;

abstract class AbstractTestCase extends AbstractPackageTestCase
{

    /**
     * Override the base path.
     *
     * @return string
     */
    protected function getBasePath()
    {
        return __DIR__;
    }

    /**
     * Set the service provider.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     *
     * @return string
     */
    protected function getServiceProviderClass($app)
    {
        return ServiceProvider::class;
    }
}