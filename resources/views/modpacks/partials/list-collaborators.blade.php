<b-card header="Collaborators" class="solder-card">
    <ul class="list-group">
        @foreach($modpack->collaborators as $collaborator)
            <li class="list-group-item">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="level-item" style="width:100px;">
                            <span class="icon">
                                <i class="fa fa-user-circle fa-2x"></i>
                            </span>
                        </div>

                    </div>
                    <div class="col-auto mr-auto">
                            <strong>{{ $collaborator->user->username }}</strong><br>
                            <small>Added on {{ $collaborator->created_at }}</small>
                    </div>
                    <div class="col-auto">
                                <form method="post" action="{{ route('collaborators.destroy', ['collaborator' => $collaborator->id]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</b-card>
