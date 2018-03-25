@extends('layouts.app')

@section('content')
    <assistant id="builds" v-cloak>
        The last step in building your modpack in Solder is to bundle together
        your favorite mods and resource packs from your Solder library. Simply
        select a package and version and click Bundle. If you don't see any
        packages listed, you probably need to go to your
        <a href="/library">Library</a> and create some.
    </assistant>
    <h1 class="title">
        Build: {{ $build->version }}
        <a href="{{ route('modpacks.show', ['modpack' => $build->modpack->slug]) }}">
            <small>(Modpack: {{ $build->modpack->slug }})</small>
        </a>
    </h1>

    <div class="pull-right">
        Status: <span class="badge badge-{{ $build->status }}">{{ $build->status }}</span>
    </div>

    <b-tabs>
        <b-tab active>
            <template slot="title">
                <span class="icon"><i class="fa fa-wrench"></i></span>General
            </template>
            @include('builds.partials.update-build')
            @include('builds.partials.danger-zone')
        </b-tab>
        <b-tab>
            <template slot="title">
                <span class="icon"><i class="fa fa-cogs"></i></span>Bundle
            </template>
            <b-card header="Bundle" class="solder-card">
                    <release-picker build_id="{{ $build->id }}" />
            </b-card>

            @if(count($build->releases))
                <b-card header="Bundled Releases" class="solder-card">
                    <build-table :releases='{{ json_encode($build->releases) }}'></build-table>
                </b-card>
            @endif
        </b-tab>
    </b-tabs>
@endsection
