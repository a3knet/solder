<b-card header="Package Settings" class="solder-card">
    <form method="post" action="{{ route('library.update', ['package' => $package->slug]) }}">
        {{ csrf_field() }}
        {{ method_field('patch') }}

        <!-- Name -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="package-name">Name</label>
            <div class="col-sm-10">
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="package-name" name="name" value="{{ old('name', $package->name) }}" />
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Author -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="package-author">Author</label>
            <div class="col-sm-10">
                <input class="form-control {{ $errors->has('author') ? 'is-invalid' : '' }}" id="package-author" name="author" placeholder="SpaceToad" value="{{ old('author', $package->author) }}" />
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
                <div class="input-group">
                    <input class="form-control {{ $errors->has('website_url') ? 'is-invalid' : '' }}" id="package-website_url" name="website_url" placeholder="http://..." value="{{ old('website_url', $package->website_url) }}" />
                    <div class="input-group-append">
                        <a href="{{ $package->website_url }}" class="btn btn-outline-secondary {{ $package->website_url == null ? 'disabled' : '' }}" {{ $package->website_url == null ? 'aria-disabled="true"' : '' }}><i class="fa fa-fw fa-external-link"></i></a>
                    </div>
                </div>

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
                <div class="input-group">
                    <input class="form-control {{ $errors->has('donation_url') ? 'is-invalid' : '' }}" id="package-donation_url" name="donation_url" placeholder="http://..." value="{{ old('donation_url', $package->donation_url) }}" />
                    <div class="input-group-append">
                        <a href="{{ $package->donation_url }}" class="btn btn-outline-secondary {{ $package->donation_url == null ? 'disabled' : '' }}" {{ $package->donation_url == null ? 'aria-disabled="true"' : '' }}><i class="fa fa-fw fa-external-link"></i></a>
                    </div>
                </div>
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
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" id="package-description" name="description">{{ old('description', $package->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
</b-card>
