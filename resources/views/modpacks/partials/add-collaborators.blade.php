<b-card header="Add Collaborator" class="solder-card">
    <form action="{{ route('modpacks.collaborators.store', ['modpack' => $modpack->slug]) }}" method="post">
        {{ csrf_field() }}

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="collaborator-user_id">User</label>
            <div class="col-sm-10">
                <select class="form-control" name="user_id" id="collaborator-user_id">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Add Collaborator</button>
            </div>
        </div>
    </form>
</b-card>