@php
    /** @var \App\Project $project */
@endphp


<div class="col-12 col-md-6 col-lg-6 mb-4">
    <div class="card mx-auto ">
        <div class="card-body card-fix">
            <div class="card-header"><h5 class="card-title">Members</h5></div>
            <form action="{{ route('projects.members.add') }}" method="post">
                @csrf
                <input type="hidden" id="project" name="project" value="{{ $project->id }}">
                <div class="row border-bottom mt-2 pb-2">
                    <div class="col-md-9">
                        <input type="text" placeholder="Add new" class="form-control" id="new_member" name="new_member" required />
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" type="submit">Add</button>
                    </div>
                </div>
            </form>
            @foreach($project->users as $user)
                <div class="row mt-2 border-bottom">
                    <div class="col">
                        <a href="{{ route('user.show', $user->id) }}">{{ $user->full_name }}</a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('user.show', $user->id) }}">{{ '@' . $user->username }}</a>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('projects.members.remove', ['project' => $project, 'user'=>$user]) }}" method="post">
                            @csrf
                            @method('delete')
                            @if(Auth::id() == $user->id)
                                <button type="button" class="btn btn-secondary" disabled>( me )</button>
                            @else
                                <button type="submit" class="btn btn-danger">Delete</button>
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery.amsify.suggestags.js') }}"></script>
<script >
    $('#new_member').amsifySuggestags({
        suggestions: [
            @foreach(\App\User::all() as $user)
                '{{ $user->username }}',
            @endforeach
        ]
    });
</script>
