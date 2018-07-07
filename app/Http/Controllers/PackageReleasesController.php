<?php

/*
 * This file is part of Solder.
 *
 * (c) Kyle Klaus <kklaus@indemnity83.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers;

use App\Package;
use App\Release;
use App\Facades\FileHash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PackageReleasesController extends Controller
{
    /**
     * Store the posted Release.
     *
     * @param Request $request
     *
     * @param $packageSlug
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, $packageSlug)
    {
        $this->authorize('create', Release::class);

        $package = Package::where('slug', $packageSlug)->firstOrFail();

        request()->validate([
            'version' => ['required', 'regex:/^[a-zA-Z0-9_-][.a-zA-Z0-9_-]*$/', Rule::unique('releases')->where('package_id', $package->id)],
            'archive' => ['required_without:custom_url', 'mimes:zip'],
            'custom_url' => ['nullable','required_without:archive', 'url'],
        ]);

        if (request()->file('archive')) {
            $archive = request()
                ->file('archive')
                ->storeAs($package->slug, "{$package->slug}-{$request->version}.zip");

            Release::create([
                'package_id' => $package->id,
                'version' => $request->version,
                'path' => $archive,
                'md5' => FileHash::hash(Storage::url($archive)),
                'filesize' => request()->file('archive')->getSize(),
            ]);
        } elseif ($request->custom_url) {
            Release::create([
                'package_id' => $package->id,
                'version' => $request->version,
                'path' => $request->custom_url,
                'md5' => md5_file($request->custom_url),
            ]);
        }

        return redirect("/library/$packageSlug");
    }
}
