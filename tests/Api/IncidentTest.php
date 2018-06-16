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

use CachetHQ\Cachet\Models\Component;
use CachetHQ\Cachet\Models\Incident;
use CachetHQ\Cachet\Models\IncidentTemplate;

/**
 * This is the incident test class.
 *
 * @author James Brooks <james@alt-three.com>
 * @author Graham Campbell <graham@alt-three.com>
 */
class IncidentTest extends AbstractApiTestCase
{
    public function test_can_get_all_incidents()
    {
        $incidents = factory(Incident::class, 3)->create();

        $response = $this->json('GET', '/api/incidents');

        $response->assertStatus(200);

        $response->assertJsonFragment(['id' => $incidents[0]->id]);
        $response->assertJsonFragment(['id' => $incidents[1]->id]);
        $response->assertJsonFragment(['id' => $incidents[2]->id]);
    }

    public function test_cannot_get_invalid_component()
    {
        $response = $this->json('GET', '/api/incidents/0');

        $response->assertStatus(404);
    }

    public function test_cannot_create_incident_without_authorization()
    {
        $response = $this->json('POST', '/api/incidents');

        $response->assertStatus(401);
    }

    public function test_cannot_create_incident_with_missing_data()
    {
        $this->beUser();

        $response = $this->json('POST', '/api/incidents');

        $response->assertStatus(400);
    }

    public function test_can_create_incident()
    {
        $this->beUser();

        $response = $this->json('POST', '/api/incidents', [
            'name'     => 'Foo',
            'message'  => 'Lorem ipsum dolor sit amet',
            'status'   => 1,
            'visible'  => 1,
            'stickied' => false,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Foo']);
    }

    public function test_can_create_incident_with_component_status()
    {
        $component = factory(Component::class)->create();

        $this->beUser();

        $response = $this->json('POST', '/api/incidents', [
            'name'             => 'Foo',
            'message'          => 'Lorem ipsum dolor sit amet',
            'status'           => 1,
            'component_id'     => $component->id,
            'component_status' => 1,
            'visible'          => 1,
            'stickied'         => false,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Foo']);
    }

    public function test_can_create_incident_with_template()
    {
        $template = factory(IncidentTemplate::class)->create();
        $this->beUser();

        $response = $this->json('POST', '/api/incidents', [
            'name'     => 'Foo',
            'status'   => 1,
            'visible'  => 1,
            'stickied' => false,
            'template' => $template->slug,
            'vars'     => [
                'name'    => 'Foo',
                'message' => 'Hello there this is a foo!',
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name'    => 'Foo',
            'message' => "Name: Foo,\nMessage: Hello there this is a foo!",
        ]);
    }

    public function test_can_get_newly_created_incident()
    {
        $incident = factory(Incident::class)->create();

        $response = $this->json('GET', '/api/incidents/1');

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $incident->name]);
    }

    public function test_can_update_incident()
    {
        $this->beUser();
        $component = factory(Incident::class)->create();

        $response = $this->json('PUT', '/api/incidents/1', [
            'name' => 'Foo',
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Foo']);
    }

    public function test_can_update_incident_with_template()
    {
        $this->beUser();
        $template = factory(IncidentTemplate::class)->create([
            'template' => 'Hello there this is a foo in my {{ incident.name }}!',
        ]);
        $component = factory(Incident::class)->create();

        $response = $this->json('PUT', '/api/incidents/1', [
            'name'     => 'Foo',
            'template' => $template->slug,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name'    => 'Foo',
            'message' => 'Hello there this is a foo in my Foo!',
        ]);
    }

    public function test_can_delete_incident()
    {
        $this->beUser();
        $component = factory(Incident::class)->create();

        $response = $this->json('DELETE', '/api/incidents/1');

        $response->assertStatus(204);
    }

    public function test_can_create_incident_with_meta_data()
    {
        $this->beUser();

        $response = $this->json('POST', '/api/incidents', [
            'name'    => 'Foo',
            'message' => 'Lorem ipsum dolor sit amet',
            'status'  => 1,
            'meta'    => [
                'id' => 123456789,
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'meta' => [
                'id' => 123456789,
            ],
        ]);
    }
}
