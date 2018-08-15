@extends('layouts.app')

@section('content')
        <assistant id="modpacks" v-cloak>
            Modpacks are made up of multiple versions, called 'builds'. Builds
            help you organize changes and upgrades to your modpack without
            breaking players worlds. A build is what the launcher will download
            and run, so it needs to have a unique version number and the version
            of Minecraft you want launched.
        </assistant>
        <h1 class="title">Modpack: {{ $modpack->name }}</h1>

        <div class="pull-right">
            Status: <span class="badge badge-{{ $modpack->status }}">{{ $modpack->status }}</span>
        </div>

        <b-tabs>
            <b-tab active>
                <template slot="title">
                    <span class="icon"><i class="fa fa-wrench"></i></span>General
                </template>
                @can('update', $modpack)
                    @include('modpacks.partials.update-modpack')
                    @include('modpacks.partials.danger-zone')
                @endcan
            </b-tab>
            <b-tab>
                <template slot="title">
                    <span class="icon"><i class="fa fa-cogs"></i></span>Builds
                </template>
                @can('update', $modpack)
                    @include('modpacks.partials.create-build')
                @endcan
                @includeWhen(count($modpack->builds), 'modpacks.partials.list-builds')
            </b-tab>
            <b-tab>
                <template slot="title">
                    <span class="icon"><i class="fa fa-users"></i></span>Collaborators
                </template>
                @include('modpacks.partials.add-collaborators')
                @includeWhen(count($modpack->collaborators), 'modpacks.partials.list-collaborators')
            </b-tab>
        </b-tabs>
@endsection
