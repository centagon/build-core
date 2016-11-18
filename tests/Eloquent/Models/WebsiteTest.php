<?php

namespace Build\Core\Tests\Eloquent\Models;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Tests\AbstractTestCase;
use Build\Core\Eloquent\Models\Website;
use Build\Core\Eloquent\Models\Language;

class WebsiteTest extends AbstractTestCase
{

    public function test_can_create_a_website()
    {
        $website = factory(Website::class)->create();

        $this->assertNotEmpty($website->name);
        $this->assertNotEmpty($website->domain);
        $this->assertNotEmpty($website->language);
        $this->assertInternalType('bool', $website->is_active);
    }

    public function test_get_url_from_website()
    {
        $website = factory(Website::class)->create();
        $domain = $website->domain;

        $this->assertEquals('http://' . $domain, $website->url);
        $this->assertEquals('http://' . $domain . '/test', $website->url('test'));
    }
}