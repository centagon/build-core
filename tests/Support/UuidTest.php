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

use Build\Core\Support\Uuid;
use Build\Core\Tests\AbstractTestCase;

class UuidTest extends AbstractTestCase
{

    public function test_can_make_valid_v3_uuid()
    {
        $uuid = '6b18cdcf-295f-339d-8291-1e2b4d47f48d';
        $excepted = 'cf0e8713-e4e7-3780-9370-ed49154e4855';

        $this->assertEquals(Uuid::v3($uuid, 'name'), $excepted);
        $this->assertTrue(Uuid::isValid(Uuid::v3($uuid, 'name')));
    }

    public function test_can_make_valid_v4_uuid()
    {
        $this->assertTrue(Uuid::isValid(Uuid::v4()));
    }

    public function test_can_make_valid_v5_uuid()
    {
        $uuid = '6b18cdcf-295f-339d-8291-1e2b4d47f48d';
        $excepted = 'd0e8a567-202a-57bb-857f-0e390c66fc9a';

        $this->assertEquals(Uuid::v5($uuid, 'name'), $excepted);
        $this->assertTrue(Uuid::isValid(Uuid::v5($uuid, 'name')));
    }
}