<b-card header="Add Release" class="solder-card">
        <form action="{{ route('library.releases.store', ['package' => $package->slug]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="package-release-version">Version</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0">
                                <i class="fa fa-code-fork"></i>
                            </span>
                        </div>
                        <input class="form-control border-left-0 {{ $errors->has('version') ? 'is-invalid' : '' }}" id="package-release-version" name="version" placeholder="1.2.3" value="{{ old('version') }}" />
                        @if($errors->has('version'))
                            <div class="invalid-feedback">
                                {{ $errors->first('version') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="package-release-archive">File</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="file" class="{{ $errors->has('modpack_icon') ? 'is-invalid' : '' }}" id="package-release-archive" name="archive" />
                    </div>
                    <small id="archiveHelpBlock" class="form-text text-muted">
                        <span class="icon">
                            <i class="fa fa-upload"></i>
                        </span>Choose a file archive (zip).
                    </small>
                    @if($errors->has('archive'))
                        <div class="invalid-feedback">
                            {{ $errors->first('archive') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Add Release</button>
                </div>
            </div>
        </form>
</b-card>
