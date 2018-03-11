@extends('layouts.app')

@section('content')
    @component('components.assistant')
        The last step in building your modpack in Solder is to bundle together
        your favorite mods and resource packs from your Solder library. Simply
        select a package and version and click Bundle. If you don't see any
        packages listed, you probably need to go to your
        <a href="/library">Library</a> and create some.
    @endcomponent

    <section class="section">
	<h1 class="title">
		Build: {{ $build->version }}
		<a href="/modpacks/{{ $build->modpack->slug }}" class="menu-label">
			<small>(Modpack: {{ $build->modpack->slug }})</small>
		</a>
	</h1> 
        <div class="level-right">
            <div class="control">
                <div class="tags has-addons">
                    <span class="tag">Status</span>
                    <span class="tag is-{{ $build->status }}">{{ $build->status }}</span>
                </div>
            </div>
	</div>

        <tabs>
                <tab icon="fa-wrench" name="General" selected="true">
                        @include('builds.partials.update-build')
                        @include('builds.partials.danger-zone')
                </tab>
                <tab icon="fa-cogs" name="Bundle">
                        <div class="box">
                            <h1>Bundle</h1>
                            <div class="box-body">
		                <form method="post" action="/bundles">
		                    {{ csrf_field() }}
		                    <input type="hidden" name="build_id" value="{{ $build->id }}" />
		                    <release-picker />
		                </form>
		            </div>
		        </div>
			
		        @if(count($build->releases))
		        <div class="box">
		            <h1>Bundled Releases</h1>
		            <build-table :releases='{{ json_encode($build->releases) }}'></build-table>
		        </div>
		        @endif
                </tab>
        </tabs>
        
    </section>
@endsection
