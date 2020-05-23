<div class="col-12 col-md-6 col-lg-6 mb-4">
    <div class="card mx-auto ">
        <div class="card-body card-fix">
            <div class="card-header"><h3 class="card-title">About {{ wordwrap($project->name) }}</h3></div>
            @php
                $Parsedown = new Parsedown();
                $Parsedown->setBreaksEnabled(true)->setSafeMode(true)->setMarkupEscaped(true);
                $description = $Parsedown->text($project->description == null || strlen($project->description) == 0 ? 'No description provided' : $project->description);
            @endphp
            <div id="p_description">{!! $description !!}</div>
            @if($project->owner()->id == Auth::user()->id)
                <button type="button" id="description_button" class="btn btn-primary" data-toggle="modal"
                        data-target="#desc_modal" data-ptitle="{{ $project->name }}"
                        data-pdesc="{{ $project->description }}">
                    Edit description
                </button>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="desc_modal" tabindex="-1" role="dialog" aria-labelledby="modal_label"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_label">Edit Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="desc_edit_form" action="{{ route('projects.update', $project->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="new_name" class="col-form-label">Project Name:</label>
                        <input type="text" value="{{ $project->name }}" class="form-control" id="new_name"
                               name="new_name" required="required">
                    </div>
                    <div class="form-group">
                        <label for="new_description" class="col-form-label">Description:</label>
                        <textarea class="form-control card-fix" id="new_description"
                                  name="new_description">{{ $project->description }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="desc_edit_form" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
