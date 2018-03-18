<div class="card solder-card">
    <div class="card-header">
        Danger Zone
    </div>
    <div class="card-body">
        <ul class="list-group">
            @if($modpack->status == 'private')
                <li class="level list-group-item">
                    <div class="row">
                        <div class="col-sm-10">
                            <strong>Make this modpack public</strong><br />
                            <small>Make this modpack visible to anyone.</small>
                        </div>
                        <div class="col-sm-2">
                            <form class="pull-right" method="post" action="{{ route('modpacks.update', ['modpacks' => $modpack->slug]) }}">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}

                                <input type="hidden" name="status" value="public" />
                                <button class="btn btn-public" type="submit">Make public</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endif
            @if($modpack->status == 'public')
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-sm-10">
                            <strong>Make this modpack private</strong><br />
                            <small>Hide this modpack from the public.</small>
                        </div>
                        <div class="col-sm-2">
                            <form class="pull-right" method="post" action="{{ route('modpacks.update', ['modpacks' => $modpack->slug]) }}">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}

                                <input type="hidden" name="status" value="private" />
                                <button class="btn btn-private" type="submit">Make private</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endif
            <li class="list-group-item">
                <div class="row">
                    <div class="col-sm-8">
                        <strong>Change modpack slug</strong><br />
                        <small>The modpack slug is used as the public key.</small>
                    </div>
                    <div class="col-sm-4">
                        <form class="form-inline pull-right" method="post" action="{{ route('modpacks.update', ['modpacks' => $modpack->slug]) }}">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}

                            <input class="form-control" name="slug" type="text" value="{{ old('slug', $modpack->slug) }}">
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
                        <strong>Delete this modpack</strong><br />
                        <small>Once you delete a modpack, there is no going back. Please be certain.</small>
                    </div>
                    <div class="col-sm-4">
                        <form class="pull-right" method="post" action="{{ route('modpacks.update', ['modpacks' => $modpack->slug]) }}">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button class="btn btn-danger" type="submit">Delete this modpack</button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
