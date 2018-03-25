<b-card header="Modpack Settings" class="solder-card">
        <form method="post" action="{{ route('modpacks.update', ['modpacks' => $modpack->slug]) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('patch') }}

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="modpack-name">Name</label>
                <div class="col-sm-10">
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" onKeyUp="nameUpdated()" id="modpack-name" name="name" placeholder="Attack of the B-Team" value="{{ old('name', $modpack->name) }}" />
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="modpack-name">Icon</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="file" class="{{ $errors->has('modpack_icon') ? 'is-invalid' : '' }}" id="modpack_icon" name="modpack_icon" />
                    </div>
                    <small id="iconHelpBlock" class="form-text text-muted">
                        Icon should be square and at least 50px wide.
                    </small>
                    @if($errors->has('modpack_icon'))
                        <div class="invalid-feedback">
                            {{ $errors->first('modpack_icon') }}
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
