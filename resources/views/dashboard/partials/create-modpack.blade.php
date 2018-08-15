<b-card header="Create Modpack" class="solder-card">
        <form action="{{route('modpacks.store')}}" method="post" id="create-modpack" enctype="multipart/form-data">
        {{ csrf_field() }}

        <!-- Name -->
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="modpack-name">Name</label>
                <div class="col-sm-10">
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" onKeyUp="nameUpdated()" id="modpack-name" name="name" placeholder="Attack of the B-Team" value="{{ old('name') }}" />
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Slug -->
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="modpack-slug">Slug</label>
                <div class="col-sm-10">
                    <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" onKeyUp="slugUpdated()" id="modpack-slug" name="slug" placeholder="attack-of-the-bteam" value="{{ old('slug') }}" />
                    @if($errors->has('slug'))
                        <div class="invalid-feedback">
                            {{ $errors->first('slug') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Icon -->
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="modpack-modpack_icon">Icon</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="file" class="{{ $errors->has('modpack_icon') ? 'is-invalid' : '' }}" id="modpack-modpack_icon" name="modpack_icon" />
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

            <!-- Status -->
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="modpack-status">Status</label>
                <div class="col-sm-10">
                    <select class="form-control" id="modpack-status" name="status">
                        <option value="public" selected>Public</option>
                        <option value="private">Private</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>

            <!-- Submit -->
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Add Modpack</button>
                </div>
            </div>
        </form>
</b-card>

@push('afterScripts')
    <script>
        //@TODO Move to VUE
        var calculatedSlug = true;

        function nameUpdated() {
            if(calculatedSlug) {
                document.getElementById("modpack-slug").value = slugify(document.getElementById("modpack-name").value);
            }
        }

        function slugUpdated() {
            calculatedSlug = false;
        }

        function slugify(text) {
            // https://gist.github.com/mathewbyrne/1280286
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '')             // Trim - from end of text
                .replace(/[\s_-]+/g, '-');
        }
    </script>
@endpush
