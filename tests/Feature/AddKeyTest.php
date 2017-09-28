<?php

/*
 * This file is part of Solder.
 *
 * (c) Kyle Klaus <kklaus@indemnity83.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Feature;

use App\Key;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddKeyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_key()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/settings/keys', [
            'token' => 'my-technic-key',
            'name' => 'Technicpack Website',
        ]);

        tap(Key::first(), function ($key) use ($response) {
            $this->assertEquals('my-technic-key', $key->token);
            $this->assertEquals('Technicpack Website', $key->name);

            $response->assertRedirect('/settings/keys');
        });
    }

    /** @test */
    public function a_guest_cannot_create_a_key()
    {
        $response = $this->post('/settings/keys', [
            'token' => 'my-technic-key',
            'name' => 'Technicpack Website',
        ]);

        $response->assertRedirect('/login');
        $this->assertCount(0, Key::all());
    }
}
