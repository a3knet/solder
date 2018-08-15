<b-card header="Add Package" class="solder-card">
    <form action="{{ route('library.store') }}" method="post">
        {{ csrf_field() }}

        <!-- Name -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="package-name">Name</label>
            <div class="col-sm-10">
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" onKeyUp="nameUpdated()" id="package-name" name="name" placeholder="Buildcraft" value="{{ old('name') }}" />
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Slug -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="package-slug">Slug</label>
            <div class="col-sm-10">
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" onKeyUp="slugUpdated()" id="package-slug" name="slug" placeholder="buildcraft" value="{{ old('slug') }}" />
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Author -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="package-author">Author</label>
            <div class="col-sm-10">
                <input class="form-control {{ $errors->has('author') ? 'is-invalid' : '' }}" id="package-author" name="author" placeholder="SpaceToad" value="{{ old('author') }}" />
                @if($errors->has('author'))
                    <div class="invalid-feedback">
                        {{ $errors->first('author') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Website URL -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="package-website_url">Website URL</label>
            <div class="col-sm-10">
                <input class="form-control {{ $errors->has('website_url') ? 'is-invalid' : '' }}" id="package-website_url" name="website_url" placeholder="http://..." value="{{ old('website_url') }}" />
                @if($errors->has('website_url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('website_url') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Donation URL -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="package-donation_url">Donation URL</label>
            <div class="col-sm-10">
                <input class="form-control {{ $errors->has('donation_url') ? 'is-invalid' : '' }}" id="package-donation_url" name="donation_url" placeholder="http://..." value="{{ old('donation_url') }}" />
                @if($errors->has('donation_url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('donation_url') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Description -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label text-nowrap" for="package-description">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" id="package-description" name="description">{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Add Package</button>
            </div>
        </div>
    </form>
</b-card>


@push('afterScripts')
    <!-- @TODO Handle via VUE -->
    <script>
        var calculatedSlug = true;

        function nameUpdated() {
            if(calculatedSlug) {
                document.getElementById("package-slug").value = slugify(document.getElementById("package-name").value);
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
