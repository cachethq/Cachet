<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Models;

use AltThree\Validator\ValidatingTrait;
use CachetHQ\Cachet\Models\Traits\SearchableTrait;
use CachetHQ\Cachet\Models\Traits\SortableTrait;
use CachetHQ\Cachet\Presenters\TimedActionPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

/**
 * This is the timed action model.
 *
 * @author James Brooks <james@alt-three.com>
 */
class TimedAction extends Model implements HasPresenter
{
    use SearchableTrait, SortableTrait, ValidatingTrait;

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'name'               => 'string',
        'description'        => 'string',
        'active'             => 'bool',
        'timezone'           => 'string',
        'schedule_frequency' => 'int',
        'completion_latency' => 'int',
        'start_at'           => 'date'
    ];

    /**
     * The fillable properties.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'active',
        'timezone',
        'schedule_frequency',
        'completion_latency',
        'start_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'name'               => 'string|required',
        'description'        => 'string',
        'active'             => 'bool',
        'timezone'           => 'string',
        'schedule_frequency' => 'int',
        'completion_latency' => 'int',
        'start_at'           => 'date|required',
    ];

    /**
     * The searchable fields.
     *
     * @var string[]
     */
    protected $searchable = [
        'id',
        'name',
        'active',
        'timezone',
        'schedule_frequency',
        'completion_latency',
        'start_at',
    ];

    /**
     * The sortable fields.
     *
     * @var string[]
     */
    protected $sortable = [
        'id',
        'name',
        'active',
        'timezone',
        'schedule_frequency',
        'completion_latency',
        'start_at',
    ];

    /**
     * Get the responses relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responses()
    {
        return $this->hasMany(TimedActionResponse::class);
    }

    /**
     * Scope to enabled timed actions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled(Builder $query)
    {
        return $query->where('active', true);
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return TimedActionPresenter::class;
    }
}
