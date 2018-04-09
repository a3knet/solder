<b-card header="Danger Zone" class="solder-card">
    <ul class="list-group">
        <li class="list-group-item">
            <div class="row">
                <div class="col-sm-6">
                    <strong>Update build status</strong><br />
                    <small>Change the visibility status of this build.</small>
                </div>
                <div class="col-sm-6">
                    <div class="btn-group pull-right">
                        <form method="post" action="{{ route('modpacks.builds.update', ['modpack' => $build->modpack->slug, 'build' => $build->version]) }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="status" value="draft" />
                            <button class="btn btn-draft" type="submit" {{ $build->status == 'draft' ? 'disabled' : '' }}>Draft</button>
                        </form>
                        <form method="post" action="{{ route('modpacks.builds.update', ['modpack' => $build->modpack->slug, 'build' => $build->version]) }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="status" value="private" />
                            <button class="btn btn-private mr-1 ml-1" type="submit" {{ $build->status == 'private' ? 'disabled' : '' }}>Private</button>
                        </form>
                        <form method="post" action="{{ route('modpacks.builds.update', ['modpack' => $build->modpack->slug, 'build' => $build->version]) }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="status" value="public" />
                            <button class="btn btn-public" type="submit" {{ $build->status == 'public' ? 'disabled' : '' }}>Public</button>
                        </form>
                    </div>
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-sm-8">
                    <strong>Change build version</strong><br />
                    <small>The build version is used as the public key.</small>
                </div>
                <div class="col-sm-4">
                    <form class="form-inline pull-right" method="post" action="{{ route('modpacks.builds.update', ['modpack' => $build->modpack->slug, 'build' => $build->version]) }}">
                        {{ csrf_field() }}

                        <input class="form-control" name="version" type="text" value="{{ old('version', $build->version) }}" />
                        @if($errors->has('version'))
                            <div class="invalid-feedback">
                                {{ $errors->first('version') }}
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
                    <strong>Delete this build</strong><br />
                    <small>Once you delete a build, there is no going back. Please be certain.</small>
                </div>
                <div class="col-sm-4">
                    <form class="pull-right" method="post" action="{{ route('modpacks.builds.destroy', ['modpack' => $build->modpack->slug, 'build' => $build->version]) }}">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button class="btn btn-danger" type="submit">Delete this build</button>
                    </form>
                </div>
            </div>
        </li>
    </ul>
</b-card>
