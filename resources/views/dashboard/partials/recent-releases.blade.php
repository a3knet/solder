<b-card header="Recently Uploaded Package Versions" class="solder-card">
    <table class="table w-100">
        <thead>
        <tr>
            <th>Version</th>
            <th>Name</th>
            <th>Updated</th>
        </tr>
        </thead>
        <tbody>
        @foreach($releases as $release)
            <tr>
                <td>{{ $release->version }}</td>
                <td>
                    <a href="{{ route('library.show', ['package' => $release->package->slug]) }}">
                        <strong>{{ $release->package->name }}</strong>
                    </a>
                </td>
                <td class="w-1">{{ $release->created }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
