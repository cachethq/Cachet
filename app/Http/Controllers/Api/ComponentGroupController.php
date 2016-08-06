<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Http\Controllers\Api;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Request;
use GrahamCampbell\Binput\Facades\Binput;
use CachetHQ\Cachet\Models\ComponentGroup;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use CachetHQ\Cachet\Bus\Commands\ComponentGroup\AddComponentGroupCommand;
use CachetHQ\Cachet\Bus\Commands\ComponentGroup\RemoveComponentGroupCommand;
use CachetHQ\Cachet\Bus\Commands\ComponentGroup\UpdateComponentGroupCommand;

/**
 * This is the component group controller.
 *
 * @author James Brooks <james@alt-three.com>
 * @author Graham Campbell <graham@alt-three.com>
 * @author Joe Cohen <joe@alt-three.com>
 */
class ComponentGroupController extends AbstractApiController
{
    /**
     * Get all groups.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGroups()
    {
        $groups = ComponentGroup::query()->guest();

        if (app(Guard::class)->check()) {
            $groups = ComponentGroup::query()->loggedIn(app(Guard::class)->user());
        }

        $groups->search(Binput::except(['sort', 'order', 'per_page']));

        if ($sortBy = Binput::get('sort')) {
            $direction = Binput::has('order') && Binput::get('order') == 'desc';

            $groups->sort($sortBy, $direction);
        }

        $groups = $groups->paginate(Binput::get('per_page', 20));

        return $this->paginator($groups, Request::instance());
    }

    /**
     * Get a single group.
     *
     * @param \CachetHQ\Cachet\Models\ComponentGroup $group
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGroup(ComponentGroup $group)
    {
        return $this->item($group);
    }

    /**
     * Create a new component group.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postGroups()
    {
        try {
            $group = dispatch(new AddComponentGroupCommand(
                Binput::get('name'),
                Binput::get('order', 0),
                Binput::get('collapsed', 0),
                Binput::get('visible', 2),
                app(Guard::class)->user()->getKey()
            ));
        } catch (QueryException $e) {
            throw new BadRequestHttpException();
        }

        return $this->item($group);
    }

    /**
     * Update an existing group.
     *
     * @param \CachetHQ\Cachet\Models\ComponentGroup $group
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function putGroup(ComponentGroup $group)
    {
        try {
            $group = dispatch(new UpdateComponentGroupCommand(
                $group,
                Binput::get('name'),
                Binput::get('order'),
                Binput::get('collapsed'),
                Binput::get('visible'),
                app(Guard::class)->user()->getKey()
            ));
        } catch (QueryException $e) {
            throw new BadRequestHttpException();
        }

        return $this->item($group);
    }

    /**
     * Delete an existing group.
     *
     * @param \CachetHQ\Cachet\Models\ComponentGroup $group
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteGroup(ComponentGroup $group)
    {
        dispatch(new RemoveComponentGroupCommand($group));

        return $this->noContent();
    }
}
