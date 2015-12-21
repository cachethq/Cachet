<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Events\Metric;

use CachetHQ\Cachet\Models\MetricPoint;

class MetricPointWasRemovedEvent implements MetricEventInterface
{
    /**
     * The metric point that was removed.
     *
     * @var \CachetHQ\Cachet\Models\MetricPoint
     */
    public $metricPoint;

    /**
     * Create a new metric point was removed event instance.
     *
     * @param MetricPoint $metricPoint
     */
    public function __construct(MetricPoint $metricPoint)
    {
        $this->metricPoint = $metricPoint;
    }
}
