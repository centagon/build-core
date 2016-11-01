<?php

namespace Build\Core\Bauhaus\Widgets\Data;

/**
 * This file is part of the Centagon Build/Core package.
 *
 * (c) Centagon <build@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Bauhaus\Widgets\Widget;

class Table extends Widget
{

    /**
     * The table block needs to be set to 'mutiple'
     * to render the rows.
     * @var string
     */
    protected $queryType = self::QUERY_TYPE_MULTIPLE;

    /**
     * Override the view path.
     * @var string
     */
    protected $view = 'build.core::components.bauhaus.data.table';
}