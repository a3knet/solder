@extends('layouts.app')

@section('content')
    <assistant id="library" v-cloak>
        Here is where you store all the mods, resource packs, configs or whatever
        else you might want to bundle into a modpack. You'll need to create a
        package to keep multiple versions of the same mod or resource pack
        together before you can start uploading files.
    </assistant>

    <h1 class="title">Library</h1>

    @can('create', App\Package::class)
        @include('packages.partials.create-package')
    @endcan

    @if(count($packages))
        @include('packages.partials.list-packages')
    @endif
@endsection
