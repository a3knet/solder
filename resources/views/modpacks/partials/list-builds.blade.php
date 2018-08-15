<b-card header="Builds" class="solder-card">
    <table class="table w-100">
        <thead>
        <tr>
            <th>Build</th>
            <th>Minecraft</th>
            <th>Forge</th>
            <th>Java</th>
            <th>Memory</th>
            <th class="text-center w-1">Promoted</th>
            <th class="text-center w-1">Latest</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($modpack->builds as $build)
            <tr>
                <td>
                    <a href="{{ route('modpacks.builds.show', ['modpack' => $modpack->slug, 'build' => $build->version]) }}">
                        <strong>{{ $build->version }}</strong>
                        @if($build->status != 'public')
                            <span class="badge badge-{{ $build->status }}">{{ $build->status }}</span>
                        @endif()
                    </a>
                </td>
                <td>{{ $build->minecraft_version }}</td>
                <td>{{ $build->forge_version }}</td>
                <td>{{ $build->java_version }}</td>
                <td>{{ $build->required_memory }}</td>
                <td class="text-center w-1">
                    <form method="post" action="{{ route('modpacks.update', ['modpack' => $modpack->slug]) }}">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}
                        <input type="hidden" name="recommended_build_id" value="{{ $build->id }}" />

                        @if($build->id == $modpack->recommended_build_id)
                            <button class="btn btn-sm btn-success" type="submit">
                                <i class="fa fa-fw fa-heart"></i>
                            </button>
                        @else
                            <button class="btn btn-sm" type="submit">
                                <i class="fa fa-fw fa-heart-o"></i>
                            </button>
                        @endif
                    </form>
                </td>
                <td class="text-center w-1">
                    <form method="post" action="{{ route('modpacks.update', ['modpack' => $modpack->slug]) }}">
                        {{ csrf_field() }}
                        {{ method_field('patch') }}
                        <input type="hidden" name="latest_build_id" value="{{ $build->id }}" />

                        @if($build->id == $modpack->latest_build_id)
                            <button class="btn btn-sm btn-success" type="submit">
                                <i class="fa fa-fw fa-star"></i>
                            </button>
                        @else
                            <button class="btn btn-sm" type="submit">
                                <i class="fa fa-fw fa-star-o"></i>
                            </button>
                        @endif
                    </form>
                </td>
                <td class="text-right">
                    <form method="post" action="{{ route('modpacks.builds.destroy', ['modpack' => $modpack->slug, 'build' => $build->version]) }}">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button class="btn btn-danger btn-small">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</b-card>
