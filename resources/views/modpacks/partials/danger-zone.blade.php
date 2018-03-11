<div class="box is-danger">
    <h1>Danger Zone</h1>
    <div class="box-body">
        <ul class="list-group">
            @if($modpack->status == 'private')
                <li class="level list-group-item">
                    <div class="level-left">
                        <div class="level-item">
                            <div class="content">
                                <strong>Make this modpack public</strong><br />
                                <small>Make this modpack visible to anyone.</small>
                            </div>
                        </div>
                    </div>
                    <div class="level-right">
                        <div class="level-item">
                            <form method="post" action="/modpacks/{{ $modpack->slug }}">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}

                                <input type="hidden" name="status" value="public" />
                                <button class="button is-public" type="submit">Make public</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endif
            @if($modpack->status == 'public')
                <li class="level list-group-item">
                    <div class="level-left">
                        <div class="level-item">
                            <div class="content">
                                <strong>Make this modpack private</strong><br />
                                <small>Hide this modpack from the public.</small>
                            </div>
                        </div>
                    </div>
                    <div class="level-right">
                        <div class="level-item">
                            <form method="post" action="/modpacks/{{ $modpack->slug }}">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}

                                <input type="hidden" name="status" value="private" />
                                <button class="button is-private" type="submit">Make private</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endif
            <li class="level list-group-item">
                <div class="level-left">
                    <div class="level-item">
                        <div class="content">
                            <strong>Change modpack slug</strong><br />
                            <small>The modpack slug is used as the public key.</small>
                        </div>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <form method="post" action="/modpacks/{{ $modpack->slug }}">
                            {{ csrf_field() }}
                            {{ method_field('patch') }}

                            <div class="field has-addons">
                                <div class="control">
                                    <input class="input is-danger" name="slug" type="text" value="{{ old('slug', $modpack->slug) }}">
                                    @if($errors->has('slug'))
                                        <p class="help is-danger">{{ $errors->first('slug') }}</p>
                                    @endif
                                </div>
                                <div class="control">
                                    <button type="submit" class="button is-danger">
                                        Change
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </li>
            <li class="level list-group-item">
                <div class="level-left">
                    <div class="level-item">
                        <div class="content">
                            <strong>Delete this modpack</strong><br />
                            <small>Once you delete a modpack, there is no going back. Please be certain.</small>
                        </div>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <form method="post" action="/modpacks/{{ $modpack->slug }}">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button class="button is-danger" type="submit">Delete this modpack</button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
