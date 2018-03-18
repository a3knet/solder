@extends('layouts.app')

@section('content')
    <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Builds</a>
                </li>
            </ul>
        </nav>
        <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
            <assistant id="modpacks" v-cloak>
                Modpacks are made up of multiple versions, called 'builds'. Builds
                help you organize changes and upgrades to your modpack without
                breaking players worlds. A build is what the launcher will download
                and run, so it needs to have a unique version number and the version
                of Minecraft you want launched.
            </assistant>
            <h1 class="title">Modpack: {{ $modpack->slug }}</h1>

            <div class="pull-right">
                Status: <span class="badge badge-{{ $modpack->status }}">{{ $modpack->status }}</span>
            </div>

            <tabs>
                <tab icon="fa-wrench" name="General" selected="true">
                    @can('update', $modpack)
                        @include('modpacks.partials.update-modpack')
                        @include('modpacks.partials.danger-zone')
                    @endcan
                </tab>
                <tab icon="fa-cogs" name="Builds">
                    @can('update', $modpack)
                        @include('modpacks.partials.create-build')
                    @endcan
                    @includeWhen(count($modpack->builds), 'modpacks.partials.list-builds')
                </tab>
                <tab icon="fa-users" name="Collaborators">
                    @include('modpacks.partials.add-collaborators')
                    @includeWhen(count($modpack->collaborators), 'modpacks.partials.list-collaborators')
                </tab>
            </tabs>

        </div>
    </div>
@endsection
