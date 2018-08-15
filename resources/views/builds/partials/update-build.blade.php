<b-card header="Build Settings" class="solder-card">
        <form method="post" action="{{ route('modpacks.builds.update', ['modpack' => $build->modpack->slug, 'build' => $build->version]) }}" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="build-minecraft_version">Minecraft Version</label>
                <div class="col-sm-10">
                    <input class="form-control {{ $errors->has('minecraft_version') ? 'is-invalid' : '' }}" id="build-minecraft_version" name="minecraft_version" placeholder="1.7.10" value="{{ old('minecraft_version', $build->minecraft_version) }}" />
                    @if($errors->has('minecraft_version'))
                        <div class="invalid-feedback">
                            {{ $errors->first('minecraft_version') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="build-forge_version">Forge Version</label>
                <div class="col-sm-10">
                    <input class="form-control {{ $errors->has('forge_version') ? 'is-invalid' : '' }}" id="build-forge_version" name="forge_version" value="{{ old('forge_version', $build->forge_version) }}" />
                    @if($errors->has('forge_version'))
                        <div class="invalid-feedback">
                            {{ $errors->first('forge_version') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="build-java_version">Java Version</label>
                <div class="col-sm-10">
                    <input class="form-control {{ $errors->has('java_version') ? 'is-invalid' : '' }}" id="build-java_version" name="java_version" value="{{ old('java_version', $build->java_version) }}" />
                    @if($errors->has('java_version'))
                        <div class="invalid-feedback">
                            {{ $errors->first('java_version') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="build-required_memory">Required Memory</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input class="form-control {{ $errors->has('required_memory') ? 'is-invalid' : '' }}" id="build-required_memory" name="required_memory" value="{{ old('required_memory', $build->required_memory) }}" />
                        <div class="input-group-append">
                            <div class="input-group-text">MB</div>
                        </div>
                    </div>

                    @if($errors->has('required_memory'))
                        <div class="invalid-feedback">
                            {{ $errors->first('required_memory') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>

</b-card>
