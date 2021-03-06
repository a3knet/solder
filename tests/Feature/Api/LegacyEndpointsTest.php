<?php

/*
 * This file is part of Solder.
 *
 * (c) Kyle Klaus <kklaus@indemnity83.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Feature\Api;

use App\Key;
use App\Build;
use App\Client;
use App\Modpack;
use App\Package;
use App\Release;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LegacyEndpointsTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function can_get_api_details()
    {
        config(['app.version' => '1.2.3']);
        config(['app.env' => 'production']);

        $response = $this->get('/api');

        $response->assertStatus(200);
        $response->assertExactJson([
            'api' => 'SolderIO',
            'version' => '1.2.3',
            'stream' => 'production',
        ]);
    }

    /** @test */
    public function verify_a_valid_api_key()
    {
        factory(Key::class)->create([
            'token' => 'APIKEY1234',
            'name' => 'Test Key',
        ]);

        $response = $this->get('/api/verify/APIKEY1234');

        $response->assertStatus(200);
        $response->assertExactJson([
            'valid' => 'Key Validated.',
            'name' => 'Test Key',
        ]);
    }

    /** @test */
    public function return_error_on_invalid_key()
    {
        $response = $this->get('/api/verify/INVALIDKEY');

        $response->assertStatus(200);
        $response->assertExactJson([
            'error' => 'Key does not exist.',
        ]);
    }

    /** @test */
    public function guests_can_list_public_modpacks()
    {
        factory(Modpack::class)->states('public')->create(['name' => 'Attack of the B-Team', 'slug' => 'b-team']);
        factory(Modpack::class)->states('public')->create(['name' => 'Tekkit', 'slug' => 'tekkit']);
        factory(Modpack::class)->states('private')->create(['name' => 'Big Dig', 'slug' => 'big-dig']);
        factory(Modpack::class)->states('draft')->create(['name' => 'Hexxit', 'slug' => 'hexxit']);

        $response = $this->get('api/modpack');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'modpacks' => [
                'b-team' => 'Attack of the B-Team',
                'tekkit' => 'Tekkit',
            ],
        ]);
    }

    /** @test */
    public function valid_api_keys_can_list_public_and_private_modpacks()
    {
        factory(Key::class)->create(['token' => 'APIKEY1234']);
        factory(Modpack::class)->states('public')->create(['name' => 'Attack of the B-Team', 'slug' => 'b-team']);
        factory(Modpack::class)->states('public')->create(['name' => 'Tekkit', 'slug' => 'tekkit']);
        factory(Modpack::class)->states('private')->create(['name' => 'Big Dig', 'slug' => 'big-dig']);
        factory(Modpack::class)->states('draft')->create(['name' => 'Hexxit', 'slug' => 'hexxit']);

        $response = $this->get('api/modpack?k=APIKEY1234');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'modpacks' => [
                'b-team' => 'Attack of the B-Team',
                'tekkit' => 'Tekkit',
                'big-dig' => 'Big Dig',
            ],
        ]);
    }

    /** @test */
    public function authorized_clients_can_list_public_and_authorized_private_modpacks()
    {
        $this->withoutExceptionHandling();

        factory(Modpack::class)->states('public')->create(['name' => 'Attack of the B-Team', 'slug' => 'b-team']);
        factory(Modpack::class)->states('private')->create(['name' => 'Tekkit', 'slug' => 'tekkit'])
            ->clients()->attach(factory(Client::class)->create(['token' => 'CLIENTKEY1234']));
        factory(Modpack::class)->states('private')->create(['name' => 'Big Dig', 'slug' => 'big-dig']);
        factory(Modpack::class)->states('draft')->create(['name' => 'Hexxit', 'slug' => 'hexxit']);

        $response = $this->get('api/modpack?cid=CLIENTKEY1234');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'modpacks' => [
                'b-team' => 'Attack of the B-Team',
                'tekkit' => 'Tekkit',
            ],
        ]);
    }

    /** @test */
    public function guests_can_list_public_modpacks_and_builds_with_full_parameters()
    {
        tap(factory(Modpack::class)->states('public')->create(['name' => 'Attack of the B-Team', 'slug' => 'b-team']), function ($modpack) {
            $v100 = factory(Build::class)->states('public')->create(['version' => '1.0.0', 'modpack_id' => $modpack->id]);
            $v200 = factory(Build::class)->states('draft')->create(['version' => '2.0.0', 'modpack_id' => $modpack->id]);
            factory(Build::class)->states('private')->create(['version' => '1.5.0', 'modpack_id' => $modpack->id]);
            $modpack->update(['recommended_build_id' => $v100->id, 'latest_build_id' => $v200->id]);
        });
        tap(factory(Modpack::class)->states('public')->create(['name' => 'Tekkit', 'slug' => 'tekkit']), function ($modpack) {
            $build = factory(Build::class)->states('private')->create(['version' => '1.5.0', 'modpack_id' => $modpack->id]);
            $modpack->update(['recommended_build_id' => $build->id, 'latest_build_id' => $build->id]);
        });
        factory(Modpack::class)->states('private')->create(['name' => 'Big Dig', 'slug' => 'big-dig']);
        factory(Modpack::class)->states('draft')->create(['name' => 'Hexxit', 'slug' => 'hexxit']);

        $response = $this->get('api/modpack?include=full');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'modpacks' => [
                'b-team' => [
                    'name' => 'b-team',
                    'display_name' => 'Attack of the B-Team',
                    'recommended' => '1.0.0',
                    'latest' => '2.0.0',
                    'builds' => [
                        '1.0.0',
                    ],
                ],
                'tekkit' => [
                    'name' => 'tekkit',
                    'display_name' => 'Tekkit',
                    'recommended' => '1.5.0',
                    'latest' => '1.5.0',
                    'builds' => [
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function authorized_clients_can_list_authorized_private_modpacks_and_builds_with_full_parameters()
    {
        tap(factory(Modpack::class)->states('private')->create(['name' => 'Attack of the B-Team', 'slug' => 'b-team']), function ($modpack) {
            $v100 = factory(Build::class)->states('public')->create(['version' => '1.0.0', 'modpack_id' => $modpack->id]);
            $v200 = factory(Build::class)->states('draft')->create(['version' => '2.0.0', 'modpack_id' => $modpack->id]);
            factory(Build::class)->states('private')->create(['version' => '1.5.0', 'modpack_id' => $modpack->id]);
            $modpack->update(['recommended_build_id' => $v100->id, 'latest_build_id' => $v200->id]);
            $modpack->clients()->attach(factory(Client::class)->create(['token' => 'CLIENTKEY1234']));
        });
        tap(factory(Modpack::class)->states('public')->create(['name' => 'Tekkit', 'slug' => 'tekkit']), function ($modpack) {
            $build = factory(Build::class)->states('private')->create(['version' => '1.5.0', 'modpack_id' => $modpack->id]);
            $modpack->update(['recommended_build_id' => $build->id, 'latest_build_id' => $build->id]);
        });
        factory(Modpack::class)->states('private')->create(['name' => 'Big Dig', 'slug' => 'big-dig']);
        factory(Modpack::class)->states('draft')->create(['name' => 'Hexxit', 'slug' => 'hexxit']);

        $response = $this->get('api/modpack?include=full&cid=CLIENTKEY1234');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'modpacks' => [
                'b-team' => [
                    'name' => 'b-team',
                    'display_name' => 'Attack of the B-Team',
                    'recommended' => '1.0.0',
                    'latest' => '2.0.0',
                    'builds' => [
                        '1.0.0',
                        '1.5.0',
                    ],
                ],
                'tekkit' => [
                    'name' => 'tekkit',
                    'display_name' => 'Tekkit',
                    'recommended' => '1.5.0',
                    'latest' => '1.5.0',
                    'builds' => [
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function valid_api_keys_can_list_public_and_private_modpacks_and_builds_with_full_parameters()
    {
        factory(Key::class)->create(['token' => 'APIKEY1234']);
        tap(factory(Modpack::class)->states('public')->create(['name' => 'Attack of the B-Team', 'slug' => 'b-team']), function ($modpack) {
            $v100 = factory(Build::class)->states('public')->create(['version' => '1.0.0', 'modpack_id' => $modpack->id]);
            $v200 = factory(Build::class)->states('draft')->create(['version' => '2.0.0', 'modpack_id' => $modpack->id]);
            factory(Build::class)->states('private')->create(['version' => '1.5.0', 'modpack_id' => $modpack->id]);
            $modpack->update(['recommended_build_id' => $v100->id, 'latest_build_id' => $v200->id]);
        });
        tap(factory(Modpack::class)->states('public')->create(['name' => 'Tekkit', 'slug' => 'tekkit']), function ($modpack) {
            $build = factory(Build::class)->states('private')->create(['version' => '1.5.0', 'modpack_id' => $modpack->id]);
            $modpack->update(['recommended_build_id' => $build->id, 'latest_build_id' => $build->id]);
        });
        factory(Modpack::class)->states('private')->create(['name' => 'Big Dig', 'slug' => 'big-dig']);
        factory(Modpack::class)->states('draft')->create(['name' => 'Hexxit', 'slug' => 'hexxit']);

        $response = $this->get('api/modpack?include=full&k=APIKEY1234');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'modpacks' => [
                'b-team' => [
                    'name' => 'b-team',
                    'display_name' => 'Attack of the B-Team',
                    'recommended' => '1.0.0',
                    'latest' => '2.0.0',
                    'builds' => [
                        '1.0.0',
                        '1.5.0',
                    ],
                ],
                'tekkit' => [
                    'name' => 'tekkit',
                    'display_name' => 'Tekkit',
                    'recommended' => '1.5.0',
                    'latest' => '1.5.0',
                    'builds' => [
                        '1.5.0',
                    ],
                ],
                'big-dig' => [
                    'name' => 'big-dig',
                    'display_name' => 'Big Dig',
                    'recommended' => null,
                    'latest' => null,
                    'builds' => [
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function guests_can_show_published_modpack_with_valid_slug()
    {
        tap(factory(Modpack::class)->states('public')->create(['name' => 'Attack of the B-Team', 'slug' => 'b-team']), function ($modpack) {
            $v100 = factory(Build::class)->states('public')->create(['version' => '1.0.0', 'modpack_id' => $modpack->id]);
            $v200 = factory(Build::class)->states('draft')->create(['version' => '2.0.0', 'modpack_id' => $modpack->id]);
            factory(Build::class)->states('private')->create(['version' => '1.5.0', 'modpack_id' => $modpack->id]);
            $modpack->update(['recommended_build_id' => $v100->id, 'latest_build_id' => $v200->id]);
        });

        $response = $this->get('api/modpack/b-team');

        $response->assertstatus(200);
        $response->assertExactJson([
            'name' => 'b-team',
            'display_name' => 'Attack of the B-Team',
            'recommended' => '1.0.0',
            'latest' => '2.0.0',
            'builds' => [
                '1.0.0',
            ],
        ]);
    }

    /** @test */
    public function authorized_users_can_show_authorized_private_modpack_with_valid_slug()
    {
        tap(factory(Modpack::class)->states('private')->create(['name' => 'Attack of the B-Team', 'slug' => 'b-team']), function ($modpack) {
            $v100 = factory(Build::class)->states('public')->create(['version' => '1.0.0', 'modpack_id' => $modpack->id]);
            $v200 = factory(Build::class)->states('draft')->create(['version' => '2.0.0', 'modpack_id' => $modpack->id]);
            factory(Build::class)->states('private')->create(['version' => '1.5.0', 'modpack_id' => $modpack->id]);
            $modpack->update(['recommended_build_id' => $v100->id, 'latest_build_id' => $v200->id]);
            $modpack->clients()->attach(factory(Client::class)->create(['token' => 'CLIENTKEY1234']));
        });

        $response = $this->get('api/modpack/b-team?cid=CLIENTKEY1234');

        $response->assertstatus(200);
        $response->assertExactJson([
            'name' => 'b-team',
            'display_name' => 'Attack of the B-Team',
            'recommended' => '1.0.0',
            'latest' => '2.0.0',
            'builds' => [
                '1.0.0',
                '1.5.0',
            ],
        ]);
    }

    /** @test */
    public function valid_api_keys_can_show_private_modpack_and_builds_with_valid_slug()
    {
        factory(Key::class)->create(['token' => 'APIKEY1234']);
        tap(factory(Modpack::class)->states('private')->create(['name' => 'Attack of the B-Team', 'slug' => 'b-team']), function ($modpack) {
            $v100 = factory(Build::class)->states('public')->create(['version' => '1.0.0', 'modpack_id' => $modpack->id]);
            $v200 = factory(Build::class)->states('draft')->create(['version' => '2.0.0', 'modpack_id' => $modpack->id]);
            factory(Build::class)->states('private')->create(['version' => '1.5.0', 'modpack_id' => $modpack->id]);
            $modpack->update(['recommended_build_id' => $v100->id, 'latest_build_id' => $v200->id]);
        });

        $response = $this->get('api/modpack/b-team?k=APIKEY1234');

        $response->assertstatus(200);
        $response->assertExactJson([
            'name' => 'b-team',
            'display_name' => 'Attack of the B-Team',
            'recommended' => '1.0.0',
            'latest' => '2.0.0',
            'builds' => [
                '1.0.0',
                '1.5.0',
            ],
        ]);
    }

    /** @test */
    public function returns_a_404_to_guests_for_private_and_draft_modpacks()
    {
        factory(Modpack::class)->states('private')->create(['name' => 'Big Dig', 'slug' => 'big-dig']);
        factory(Modpack::class)->states('draft')->create(['name' => 'Hexxit', 'slug' => 'hexxit']);

        $response = $this->get('api/modpack/big-dig');

        $response->assertstatus(404);
        $response->assertExactJson([
            'error' => 'Modpack does not exist',
        ]);

        $response = $this->get('api/modpack/big-dig/1.0.0');

        $response->assertstatus(404);
        $response->assertExactJson([
            'error' => 'Modpack does not exist',
        ]);

        $response = $this->get('api/modpack/hexxit');

        $response->assertstatus(404);
        $response->assertExactJson([
            'error' => 'Modpack does not exist',
        ]);

        $response = $this->get('api/modpack/hexxit/1.0.0');

        $response->assertstatus(404);
        $response->assertExactJson([
            'error' => 'Modpack does not exist',
        ]);
    }

    /** @test */
    public function returns_a_404_for_invalid_modpack_slug()
    {
        $response = $this->get('api/modpack/invalid-slug');

        $response->assertstatus(404);
        $response->assertExactJson([
            'error' => 'Modpack does not exist',
        ]);

        $response = $this->get('api/modpack/invalid-slug/1.0.0');

        $response->assertstatus(404);
        $response->assertExactJson([
            'error' => 'Modpack does not exist',
        ]);
    }

    /** @test */
    public function guest_can_show_public_build()
    {
        Storage::shouldReceive('url')->andReturn('http://technicpack.net/mod-a/file-a.zip', 'http://technicpack.net/mod-b/file-b.zip');
        tap(factory(Modpack::class)->states('public')->create(['name' => 'Attack of the B-Team', 'slug' => 'b-team']), function ($modpack) {
            $packageA = factory(Package::class)->create(['name' => 'Example Mod A', 'slug' => 'mod-a']);
            $releaseA = factory(Release::class)->create(['package_id' => $packageA->id, 'version' => '1.2.3', 'md5' => 'MD5HASHA']);
            $packageB = factory(Package::class)->create(['name' => 'Example Mod B', 'slug' => 'mod-b']);
            $releaseB = factory(Release::class)->create(['package_id' => $packageB->id, 'version' => '4.5.6', 'md5' => 'MD5HASHB']);
            factory(Build::class)->states('public')
                ->create([
                    'version' => '1.0.0',
                    'modpack_id' => $modpack->id,
                    'minecraft_version' => '1.11.2',
                    'java_version' => '1.8',
                    'forge_version' => '1.12.1234',
                    'required_memory' => 2048,
                ])->releases()->attach([$releaseA->id, $releaseB->id]);
        });

        $request = $this->get('/api/modpack/b-team/1.0.0');

        $request->assertStatus(200);
        $request->assertExactJson([
            'minecraft' => '1.11.2',
            'java' => '1.8',
            'memory' => 2048,
            'forge' => '1.12.1234',
            'mods' => [
                [
                    'name' => 'Example Mod A',
                    'version' => '1.2.3',
                    'md5' => 'MD5HASHA',
                    'url' => 'http://technicpack.net/mod-a/file-a.zip',
                ],
                [
                    'name' => 'Example Mod B',
                    'version' => '4.5.6',
                    'md5' => 'MD5HASHB',
                    'url' => 'http://technicpack.net/mod-b/file-b.zip',
                ],
            ],
        ]);
    }

    /** @test */
    public function authorized_clients_can_show_private_modpack_and_build()
    {
        Storage::shouldReceive('url')->andReturn('http://technicpack.net/mod-a/file-a.zip', 'http://technicpack.net/mod-b/file-b.zip');

        tap(factory(Modpack::class)->states('private')->create(['name' => 'Attack of the B-Team', 'slug' => 'b-team']), function ($modpack) {
            $packageA = factory(Package::class)->create(['name' => 'Example Mod A', 'slug' => 'mod-a']);
            $releaseA = factory(Release::class)->create(['package_id' => $packageA->id, 'version' => '1.2.3', 'md5' => 'MD5HASHA']);
            $packageB = factory(Package::class)->create(['name' => 'Example Mod B', 'slug' => 'mod-b']);
            $releaseB = factory(Release::class)->create(['package_id' => $packageB->id, 'version' => '4.5.6', 'md5' => 'MD5HASHB']);
            factory(Build::class)->states('private')
                ->create([
                    'version' => '1.0.0',
                    'modpack_id' => $modpack->id,
                    'java_version' => '1.8',
                    'forge_version' => '1.12.1234',
                    'required_memory' => 2048,
                ])->releases()->attach([$releaseA->id, $releaseB->id]);
            $modpack->clients()->attach(factory(Client::class)->create(['token' => 'CLIENTKEY1234']));
        });

        $request = $this->get('/api/modpack/b-team/1.0.0?cid=CLIENTKEY1234');

        $request->assertStatus(200);
        $request->assertExactJson([
            'minecraft' => '1.7.10',
            'java' => '1.8',
            'memory' => 2048,
            'forge' => '1.12.1234',
            'mods' => [
                [
                    'name' => 'Example Mod A',
                    'version' => '1.2.3',
                    'md5' => 'MD5HASHA',
                    'url' => 'http://technicpack.net/mod-a/file-a.zip',
                ],
                [
                    'name' => 'Example Mod B',
                    'version' => '4.5.6',
                    'md5' => 'MD5HASHB',
                    'url' => 'http://technicpack.net/mod-b/file-b.zip',
                ],
            ],
        ]);
    }

    /** @test */
    public function valid_api_key_can_show_private_modpack_and_build()
    {
        Storage::shouldReceive('url')->andReturn('http://technicpack.net/mod-a/file-a.zip', 'http://technicpack.net/mod-b/file-b.zip');

        factory(Key::class)->create(['token' => 'APIKEY1234']);
        tap(factory(Modpack::class)->states('private')->create(['name' => 'Attack of the B-Team', 'slug' => 'b-team']), function ($modpack) {
            $packageA = factory(Package::class)->create(['name' => 'Example Mod A', 'slug' => 'mod-a']);
            $releaseA = factory(Release::class)->create(['package_id' => $packageA->id, 'version' => '1.2.3', 'md5' => 'MD5HASHA']);
            $packageB = factory(Package::class)->create(['name' => 'Example Mod B', 'slug' => 'mod-b']);
            $releaseB = factory(Release::class)->create(['package_id' => $packageB->id, 'version' => '4.5.6', 'md5' => 'MD5HASHB']);
            factory(Build::class)->states('private')
                ->create([
                    'version' => '1.0.0',
                    'modpack_id' => $modpack->id,
                    'java_version' => '1.8',
                    'forge_version' => '1.12.1234',
                    'required_memory' => 2048,
                ])->releases()->attach([$releaseA->id, $releaseB->id]);
        });

        $request = $this->get('/api/modpack/b-team/1.0.0?k=APIKEY1234');

        $request->assertStatus(200);
        $request->assertExactJson([
            'minecraft' => '1.7.10',
            'java' => '1.8',
            'memory' => 2048,
            'forge' => '1.12.1234',
            'mods' => [
                [
                    'name' => 'Example Mod A',
                    'version' => '1.2.3',
                    'md5' => 'MD5HASHA',
                    'url' => 'http://technicpack.net/mod-a/file-a.zip',
                ],
                [
                    'name' => 'Example Mod B',
                    'version' => '4.5.6',
                    'md5' => 'MD5HASHB',
                    'url' => 'http://technicpack.net/mod-b/file-b.zip',
                ],
            ],
        ]);
    }

    /** @test */
    public function returns_a_404_to_guests_for_non_public_build()
    {
        tap(factory(Modpack::class)->states('public')->create(['name' => 'Attack of the B-Team', 'slug' => 'b-team']), function ($modpack) {
            factory(Build::class)->states('public')->create(['version' => '1.0.0', 'modpack_id' => $modpack->id]);
            factory(Build::class)->states('draft')->create(['version' => '2.0.0', 'modpack_id' => $modpack->id]);
            factory(Build::class)->states('private')->create(['version' => '1.5.0', 'modpack_id' => $modpack->id]);
        });

        $response = $this->get('api/modpack/b-team/1.5.0');

        $response->assertstatus(404);
        $response->assertExactJson([
            'error' => 'Build does not exist',
        ]);

        $response = $this->get('api/modpack/b-team/2.0.0');

        $response->assertstatus(404);
        $response->assertExactJson([
            'error' => 'Build does not exist',
        ]);
    }

    /** @test */
    public function returns_a_404_for_invalid_build()
    {
        factory(Modpack::class)->states('public')->create(['slug' => 'b-team']);

        $response = $this->get('api/modpack/b-team/invalid-version');

        $response->assertstatus(404);
        $response->assertExactJson([
            'error' => 'Build does not exist',
        ]);
    }
}
