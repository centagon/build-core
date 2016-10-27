<?php

namespace Build\Core\Http\Controllers;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Models\Website;
use Build\Core\Http\Entities\WebsitesEntity;

class WebsitesController extends \Build\Core\Http\Controller
{

    public function index()
    {
        $this->authorize('index-website');

        return entity(WebsitesEntity::class, 'index')
            ->setQuery(Website::all())
            ->render();
    }
}