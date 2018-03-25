<b-card header="Danger Zone" class="solder-card">
        <ul class="list-group">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-sm-8">
                        <strong>Change package slug</strong><br />
                        <small>The package slug is used as the public key.</small>
                    </div>
                    <div class="col-sm-4">
                        <form class="form-inline pull-right" method="post" action="{{ route('library.update', ['package' => $package->slug]) }}">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}

                            <input class="form-control" name="slug" type="text" value="{{ old('slug', $package->slug) }}" />
                            @if($errors->has('slug'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('slug') }}
                                </div>
                            @endif
                            <button type="submit" class="btn btn-danger">
                                Change
                            </button>
                        </form>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-sm-8">
                        <strong>Delete this package</strong><br />
                        <small>Once you delete a package, there is no going back. Please be certain.</small>
                    </div>
                    <div class="col-sm-4">
                        <form class="pull-right" method="post" action="{{ route('library.destroy', ['package' => $package->slug]) }}">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button class="btn btn-danger" type="submit">Delete this package</button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
</b-card>
