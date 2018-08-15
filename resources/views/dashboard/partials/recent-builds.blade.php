<b-card header="Recently Updated Modpacks" class="solder-card">
    <table class="table is-fullwidth">
        <thead>
        <tr>
            <th>Version</th>
            <th>Name</th>
            <th>Minecraft</th>
            <th>Updated</th>
        </tr>
        </thead>
        <tbody>
        @foreach($builds as $build)
            <tr>
                <td>
                    <a href="{{ route('modpacks.builds.show', ['modpack' => $build->modpack->slug, 'build' => $build->version]) }}">
                        <strong>{{ $build->version }}</strong>
                    </a>
                </td>
                <td>
                    <a href="{{ route('modpacks.show', ['modpack' => $build->modpack->slug]) }}">
                        <strong>{{ $build->modpack->name }}</strong>
                    </a>
                </td>
                <td>{{ $build->minecraft }}</td>
                <td class="w-1">{{ $build->created }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</b-card>
