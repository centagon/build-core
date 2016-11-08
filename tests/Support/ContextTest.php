<?php

namespace Build\Core\Tests\Support;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Tests\AbstractTestCase;
use Build\Core\Support\Facades\Context;

class ContextTest extends AbstractTestCase
{

    public function test_context_is_frontend()
    {
        $this->assertEquals(Context::get(), 'frontend');
        $this->assertTrue(Context::isFrontend());
    }

    public function test_context_is_backend()
    {
        $this->visit(config('build.core.uri'));

        $this->assertEquals(Context::get(), 'backend');
        $this->assertTrue(Context::isBackend());
    }

    public function test_can_override_context()
    {
        $this->visit(config('build.core.uri'));

        $this->assertEquals(Context::get(), 'backend');
        $this->assertTrue(Context::isBackend());

        Context::override('frontend');

        $this->assertEquals(Context::get(), 'frontend');
        $this->assertTrue(Context::isFrontend());
    }
}