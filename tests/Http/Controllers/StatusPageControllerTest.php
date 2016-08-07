<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Tests\Cachet\Http\Controllers;

use CachetHQ\Cachet\Models\Component;
use CachetHQ\Cachet\Models\ComponentGroup;
use CachetHQ\Cachet\Models\Setting;
use CachetHQ\Cachet\Models\User;
use CachetHQ\Tests\Cachet\AbstractTestCase;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StatusPageControllerTest extends AbstractTestCase
{
    use DatabaseMigrations;

    const COMPONENT_GROUP_1_NAME = 'Component Group 1';
    const COMPONENT_GROUP_2_NAME = 'Component Group 2';
    const COMPONENT_GROUP_3_NAME = 'Component Group 3';
    const COMPONENT_GROUP_4_NAME = 'Component Group 4';

    /**
     * @var User
     */
    protected $user;

    protected function setUp()
    {
        parent::setUp();

        $this->setupPublicLoggedInAndHiddenComponentGroups()
            ->setupConfig();
    }

    /** @test */
    public function on_index_only_public_component_groups_are_shown_to_a_guest()
    {
        $this->visit('/')
            ->see(self::COMPONENT_GROUP_1_NAME)
            ->dontSee(self::COMPONENT_GROUP_2_NAME)
            ->dontSee(self::COMPONENT_GROUP_3_NAME);
    }

    /** @test */
    public function on_index_all_component_groups_are_displayed_to_logged_in_users()
    {
        $this->signIn();

        $this->visit('/')
            ->see(self::COMPONENT_GROUP_1_NAME)
            ->see(self::COMPONENT_GROUP_2_NAME)
            ->see(self::COMPONENT_GROUP_3_NAME);
    }

    /** @test */
    public function on_index_hidden_component_groups_are_not_displayed_if_not_belonging_to_logged_in_user()
    {
        $this->signIn()
            ->createAComponentGroupAndAddAComponent(
                self::COMPONENT_GROUP_4_NAME,
                ComponentGroup::VISIBLE_HIDDEN,
                $this->createUser()
            );

        $this->visit('/')
            ->see(self::COMPONENT_GROUP_1_NAME)
            ->see(self::COMPONENT_GROUP_2_NAME)
            ->see(self::COMPONENT_GROUP_3_NAME)
            ->dontSee(self::COMPONENT_GROUP_4_NAME);
    }

    /**
     * Set up the needed data for the components groups tests.
     *
     * @return AbstractTestCase
     */
    protected function setupPublicLoggedInAndHiddenComponentGroups()
    {
        $this->signIn()
            ->createAComponentGroupAndAddAComponent(self::COMPONENT_GROUP_1_NAME, ComponentGroup::VISIBLE_PUBLIC)
            ->createAComponentGroupAndAddAComponent(self::COMPONENT_GROUP_2_NAME, ComponentGroup::VISIBLE_LOGGED_IN)
            ->createAComponentGroupAndAddAComponent(self::COMPONENT_GROUP_3_NAME, ComponentGroup::VISIBLE_HIDDEN);

        factory(Setting::class)->create();

        app(Guard::class)->logout();

        return $this;
    }

    /**
     * Create a component group and add one component to it.
     * Also attaches a creator if any given as a parameter
     * or exists in the test class.
     *
     * @param string $name
     * @param string $visible
     * @param User   $user
     *
     * @return AbstractTestCase
     */
    protected function createAComponentGroupAndAddAComponent($name, $visible, User $user = null)
    {
        $createdBy = 0;
        if ($user) {
            $createdBy = $user->getKey();
        } elseif ($this->user) {
            $createdBy = $this->user->getKey();
        }

        factory(ComponentGroup::class)
            ->create(['name' => $name, 'visible' => $visible, 'created_by' => $createdBy])
            ->components()
            ->save(factory(Component::class)->create());

        return $this;
    }
}
