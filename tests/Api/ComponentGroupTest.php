<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Tests\Cachet\Api;

use CachetHQ\Cachet\Models\User;
use Illuminate\Contracts\Auth\Guard;
use CachetHQ\Cachet\Models\Component;
use CachetHQ\Cachet\Models\ComponentGroup;

/**
 * This is the component group test class.
 *
 * @author James Brooks <james@alt-three.com>
 * @author Graham Campbell <graham@alt-three.com>
 */
class ComponentGroupTest extends AbstractApiTestCase
{
    const COMPONENT_GROUP_1_NAME = 'Component Group 1';
    const COMPONENT_GROUP_2_NAME = 'Component Group 2';
    const COMPONENT_GROUP_3_NAME = 'Component Group 3';
    const COMPONENT_GROUP_4_NAME = 'Component Group 4';

    public function testGetGroups()
    {
        $groups = factory('CachetHQ\Cachet\Models\ComponentGroup', 3)
            ->create(['visible' => ComponentGroup::VISIBLE_PUBLIC]);

        $this->get('/api/v1/components/groups');
        $this->seeJson(['id' => $groups[0]->id]);
        $this->seeJson(['id' => $groups[1]->id]);
        $this->seeJson(['id' => $groups[2]->id]);
        $this->assertResponseOk();
    }

    public function testGetInvalidGroup()
    {
        $this->get('/api/v1/components/groups/1');
        $this->assertResponseStatus(404);
    }

    public function testPostGroupUnauthorized()
    {
        $this->post('/api/v1/components/groups');

        $this->assertResponseStatus(401);
    }

    public function testPostGroupNoData()
    {
        $this->beUser();

        $this->post('/api/v1/components/groups');
        $this->assertResponseStatus(400);
    }

    public function testPostGroup()
    {
        $this->beUser();

        $this->post('/api/v1/components/groups', [
            'name'      => 'Foo',
            'order'     => 1,
            'collapsed' => 1,
        ]);
        $this->seeJson(['name' => 'Foo', 'order' => 1, 'collapsed' => 1]);
        $this->assertResponseOk();
    }

    public function testGetNewGroup()
    {
        $group = factory('CachetHQ\Cachet\Models\ComponentGroup')->create();

        $this->get('/api/v1/components/groups/1');
        $this->seeJson(['name' => $group->name]);
        $this->assertResponseOk();
    }

    public function testPutGroup()
    {
        $this->beUser();
        $group = factory('CachetHQ\Cachet\Models\ComponentGroup')->create();

        $this->put('/api/v1/components/groups/1', [
            'name' => 'Lorem Ipsum Groupous',
        ]);
        $this->seeJson(['name' => 'Lorem Ipsum Groupous']);
        $this->assertResponseOk();
    }

    public function testDeleteGroup()
    {
        $this->beUser();
        $group = factory('CachetHQ\Cachet\Models\ComponentGroup')->create();

        $this->delete('/api/v1/components/groups/1');
        $this->assertResponseStatus(204);
    }

    /** @test */
    public function only_public_component_groups_are_shown_for_a_guest()
    {
        $this->createComponentGroups();

        $this->get('/api/v1/components/groups')
            ->seeJson(['name' => self::COMPONENT_GROUP_1_NAME])
            ->dontSeeJson(['name' => self::COMPONENT_GROUP_2_NAME])
            ->dontSeeJson(['name' => self::COMPONENT_GROUP_3_NAME]);
        $this->assertResponseOk();
    }

    /** @test */
    public function all_component_groups_are_displayed_for_loggedin_users()
    {
        $this->createComponentGroups()
            ->signIn();

        $this->get('/api/v1/components/groups')
            ->seeJson(['name' => self::COMPONENT_GROUP_1_NAME])
            ->seeJson(['name' => self::COMPONENT_GROUP_2_NAME])
            ->seeJson(['name' => self::COMPONENT_GROUP_3_NAME]);
        $this->assertResponseOk();
    }

    /** @test */
    public function hidden_component_groups_arent_shown_if_not_belonging_to_loggedin_user()
    {
        $this->createComponentGroups()
            ->signIn()
            ->createComponentGroup(
                self::COMPONENT_GROUP_4_NAME,
                ComponentGroup::VISIBLE_HIDDEN,
                $this->createUser()
            );

        $this->get('/api/v1/components/groups')
            ->seeJson(['name' => self::COMPONENT_GROUP_1_NAME])
            ->seeJson(['name' => self::COMPONENT_GROUP_2_NAME])
            ->seeJson(['name' => self::COMPONENT_GROUP_3_NAME])
            ->dontSeeJson(['name' => self::COMPONENT_GROUP_4_NAME]);
        $this->assertResponseOk();
    }

    /**
     * Set up the needed data for the tests.
     *
     * @return TestCase
     */
    protected function createComponentGroups()
    {
        $this->signIn()
            ->createComponentGroup(self::COMPONENT_GROUP_1_NAME, ComponentGroup::VISIBLE_PUBLIC)
            ->createComponentGroup(self::COMPONENT_GROUP_2_NAME, ComponentGroup::VISIBLE_LOGGED_IN)
            ->createComponentGroup(self::COMPONENT_GROUP_3_NAME, ComponentGroup::VISIBLE_HIDDEN);

        app(Guard::class)->logout();

        return $this;
    }

    /**
     * Create a component group.
     * Also attaches a creator if any given as a parameter
     * or exists in the test class.
     *
     * @param string $name
     * @param string $visible
     * @param User   $user
     *
     * @return AbstractApiTestCase
     */
    protected function createComponentGroup($name, $visible, User $user = null)
    {
        $createdBy = 0;
        if (!is_null($user)) {
            $createdBy = $user->getKey();
        } elseif (!is_null($this->user)) {
            $createdBy = $this->user->getKey();
        }

        factory(ComponentGroup::class)
            ->create(['name' => $name, 'visible' => $visible, 'created_by' => $createdBy]);

        return $this;
    }
}
