<b-card header="Add Build" class="solder-card">
    <form method="post" action="{{ route('modpacks.builds.store', ['modpack' => $modpack->slug]) }}">
        {{ csrf_field() }}

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="build-version">Version</label>
            <div class="col-sm-10">
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="build-version" name="version" placeholder="1.0.0" value="{{ old('version') }}" />
                @if($errors->has('version'))
                    <div class="invalid-feedback">
                        {{ $errors->first('version') }}
                    </div>
                @endif
            </div>
        </div>

        @if (count($modpack->builds) >= 1)
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="build-clone_build_id">Copy From</label>
                <div class="col-sm-10">
                    <select class="form-control" name="clone_build_id" id="build-clone_build_id">
                        <option value="">none</option>
                        @foreach($modpack->builds as $build)
                            <option value="{{ $build->id }}">{{ $build->version }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="build-minecraft_version">Minecraft Version</label>
            <div class="col-sm-10">
                <input class="form-control {{ $errors->has('minecraft_version') ? 'is-invalid' : '' }}" id="build-minecraft_version" name="minecraft_version" placeholder="1.7.10" value="{{ old('minecraft_version') }}" />
                @if($errors->has('minecraft_version'))
                    <div class="invalid-feedback">
                        {{ $errors->first('minecraft_version') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="build-id">Status</label>
            <div class="col-sm-10">
                <select class="form-control" name="status" id="build-id">
                    <option value="public" selected>Public</option>
                    <option value="private">Private</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Add Build</button>
            </div>
        </div>
    </form>
</b-card>
