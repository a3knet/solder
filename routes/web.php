<?php

/*
 * This file is part of Solder.
 *
 * (c) Kyle Klaus <kklaus@indemnity83.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::view('/login', 'auth.login')->name('auth.show-login');
Route::post('/login', 'Auth\LoginController@login')->name('auth.login');
Route::post('/logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::middleware('auth')->group(function () {
    Route::get('/', 'DashboardController')->name('dashboard.show');

    Route::get('/modpacks/{modpack}', 'ModpacksController@show')->name('modpacks.show');
    Route::post('/modpacks', 'ModpacksController@store')->name('modpacks.store');
    Route::patch('/modpacks/{modpack}', 'ModpacksController@update')->name('modpacks.update');
    Route::delete('/modpacks/{modpack}', 'ModpacksController@destroy')->name('modpacks.destroy');

    Route::post('/modpacks/{modpack}/collaborators', 'ModpackCollaboratorsController@store')->name('modpacks.collaborators.store');

    Route::delete('/collaborators/{collaborator}', 'CollaboratorsController@destroy')->name('collaborators.destroy');

    Route::get('/modpacks/{modpack}/{build}', 'ModpackBuildsController@show')->name('modpacks.builds.show');
    Route::post('/modpacks/{modpack}/builds', 'ModpackBuildsController@store')->name('modpacks.builds.store');
    Route::post('/modpacks/{modpack}/{build}', 'ModpackBuildsController@update')->name('modpacks.builds.update');
    Route::delete('/modpacks/{modpack}/{build}', 'ModpackBuildsController@destroy')->name('modpacks.builds.destroy');

    Route::get('/library', 'PackagesController@index')->name('library.list');
    Route::get('/library/{package}', 'PackagesController@show')->name('library.show');
    Route::post('/library', 'PackagesController@store')->name('library.store');
    Route::patch('/library/{package}', 'PackagesController@update')->name('library.update');
    Route::delete('/library/{package}', 'PackagesController@destroy')->name('library.destroy');

    Route::post('/library/{package}/releases', 'PackageReleasesController@store')->name('library.releases.store');

    Route::delete('/releases/{release}', 'ReleasesController@destroy')->name('releases.destroy');

    Route::delete('/bundles', 'BundlesController@destroy');
    Route::post('/bundles', 'BundlesController@store');
});

Route::middleware('auth')->namespace('Admin')->prefix('settings')->group(function () {
    Route::view('about', 'settings.about.show');

    Route::view('api', 'settings.api')->name('settings.api.show');

    Route::get('permissions', 'PermissionsController@index');
    Route::post('permissions', 'PermissionsController@update');

    Route::get('keys', 'KeysController@index');
    Route::post('keys', 'KeysController@store');
    Route::delete('keys/{key}', 'KeysController@destroy');

    Route::get('clients', 'ClientsController@index');
    Route::post('clients', 'ClientsController@store');
    Route::delete('clients/{client}', 'ClientsController@destroy');

    Route::get('users', 'UsersController@index');
    Route::post('users', 'UsersController@store');
    Route::post('users/{user}', 'UsersController@update');
    Route::delete('users/{user}', 'UsersController@destroy');
});
