@extends('layouts.app')

@section('content')
    @component('components.assistant')
        Modpacks are made up of multiple versions, called 'builds'. Builds
        help you organize changes and upgrades to your modpack without
        breaking players worlds. A build is what the launcher will download
        and run, so it needs to have a unique version number and the version
        of Minecraft you want launched.
    @endcomponent

    <section class="section">
        <h1 class="title">Modpack: {{ $modpack->slug }}</h1>
        <div class="level-right">
            <div class="control">
                <div class="tags has-addons">
                    <span class="tag">Status</span>
                    <span class="tag is-{{ $modpack->status }}">{{ $modpack->status }}</span>
                </div>
            </div>
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
        <br>
    </section>
@endsection
