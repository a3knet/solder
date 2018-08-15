@extends('layouts.app')

@section('content')
    <assistant id="releases" v-cloak>
        This is the place for uploading new releases of a package, and managing
        the files for your library. The file structure is very important so before
        you upload anything take a minute to read about the
        <a href="http://docs.solder.io/docs/zip-file-structure">zip file structure</a>
        in the docs.
    </assistant>

    <h1 class="title">Package: {{ $package->name }}</h1>

    <b-tabs>
        <b-tab active>
            <template slot="title">
                <span class="icon"><i class="fa fa-wrench"></i></span>General
            </template>
            @can('update', $package)
                @include('packages.partials.update-package')
                @include('packages.partials.danger-zone')
            @endcan
        </b-tab>
        <b-tab>
            <template slot="title">
                <span class="icon"><i class="fa fa-cogs"></i></span>Release
            </template>
            @can('create', App\Release::class)
                @include('packages.partials.create-release')
            @endcan

            @if(count($package->releases))
                <release-table baseurl="{{ route('dashboard.show') }}" :releases='{{ json_encode($package->releases) }}'></release-table>
            @endif
        </b-tab>
    </b-tabs>
@endsection
