<b-card header="Packages" class="solder-card">
    <table class="table w-100">
        <thead>
        <tr>
            <th>Name</th>
            <th>Author</th>
            <th>Links</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($packages as $package)
            <tr>
                <td>
                    <a href="{{ route('library.show', ['package'=> $package->slug]) }}">
                        <strong>{{ $package->name }}</strong>
                    </a>
                </td>
                <td>{{ $package->author }}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="URLs">
                        <a href="{{ $package->website_url }}" class="btn btn-sm btn-light btn-secondary {{ $package->website_url == null ? 'disabled' : '' }}" role="button" aria-pressed="true" {{ $package->website_url == null ? 'aria-disabled="true"' : '' }}>
                            <span class="icon">
                                <i class="fa fa-external-link"></i>
                            </span>
                        </a>
                        <a href="{{ $package->donation_url }}" class="btn btn-sm btn-light btn-secondary {{ $package->donation_url == null ? 'disabled' : '' }}" role="button" aria-pressed="true" {{ $package->donation_url == null ? 'aria-disabled="true"' : '' }}>
                            <span class="icon">
                                <i class="fa fa-external-link"></i>
                            </span>
                        </a>
                    </div>
                </td>
                <td class="text-right">
                    <form method="post" action="{{ route('library.destroy', ['package' => $package->slug]) }}">
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
