@php
    use App\Project;use App\Task;use Illuminate\Pagination\LengthAwarePaginator;
    /** @var Project $project
    *   @var LengthAwarePaginator $tasks
    *   @var Task $task
    */
@endphp


@extends('layouts.app', ['active_page' => 'project', 'page_title' => 'My Projects'])

@push('style')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/project.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/amsify.suggestags.css') }}"/>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#task_edit_modal"
                       data-task_id="-1}">New</a>
                    <a href="{{ route('projects.export', $project->id) }}" class="btn btn-primary">Export</a>
                    <input type="hidden" name="project_id" id="project_id" form="task_edit_form"
                           value="{{ $project->id }}">
                </div>
            </div>
        </div>
        <div class="row">
            <table id="task_table" class="table display">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Responsible Persons</th>
                    <th>Created by</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>
                            {{ Task::innerID($task) }}
                        </td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#task_edit_modal"
                               data-task_id="{{ $task->id }}">{{ $task->title }}</a>
                        </td>
                        <td>
                            @foreach($task->users as $u)
                                <a href="{{ route('user.show', $u->username) }}">{{ $u->username }}</a>,
                            @endforeach
                            <input type="hidden" id="{{ $task->id }}_responsibles"
                                   value="{{ \App\Task::userString($task) }}">
                        </td>
                        <td>
                            <a href="{{ route('user.show', $task->owner()->username) }}">{{ $task->owner()->username }}</a>
                        </td>
                        <td>
                            {{ $task->deadline }}
                        </td>
                        <td>
                            @switch($task->status)
                                @case('0')
                                <p>Backlog</p>
                                @break
                                @case('1')
                                <p>On Hold</p>
                                @break
                                @case('2')
                                <p>Planning</p>
                                @break
                                @case('3')
                                <p>In Progress</p>
                                @break
                                @case('4')
                                <p>Verifying</p>
                                @break
                                @case('5')
                                <p>On Review</p>
                                @break
                                @default
                                <p>Completed at {{ $task->completed }}</p>
                                @break
                            @endswitch
                        </td>
                        <td>
                            {{ $task->created_at }}
                        </td>
                        <td>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="task_edit_modal" tabindex="-1" role="dialog" aria-labelledby="task_edit_label"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="task_edit_label">Task data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="task_edit_form" id="task_edit_form" action="{{ route('api.task.update') }}"
                          method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" name="task_id" id="task_id" value="">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="new_title" class="col-form-label">Title:</label>
                                    <input type="text" required="required" class="form-control" name="new_title"
                                           id="new_title">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="new_status" class="col-form-label">Status:</label>
                                    <select class="form-control" name="new_status" id="new_status">
                                        <option value="0">Backlog</option>
                                        <option value="1">On Hold</option>
                                        <option value="2">Planning</option>
                                        <option value="3">In Progress</option>
                                        <option value="4">Verifying</option>
                                        <option value="5">On Review</option>
                                        <option value="9">Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="new_responsibles" class="col-form-label">Responsible persons:</label>
                                    <input type="text" class="form-control" name="new_responsibles"
                                           id="new_responsibles">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="new_deadline" class="col-form-label">Deadline:</label>
                                    <input type="datetime-local" class="form-control" name="new_deadline"
                                           id="new_deadline">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="new_content" class="col-form-label">Description:</label>
                                    <textarea class="form-control" name="new_content" id="new_content"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="task_edit_form" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/jquery.amsify.suggestags.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
    <script>
        let active_task = 0;
        $(document).ready(function () {
            $('#task_table').DataTable({
                select: true,
                colReorder: true
            });
            $('#task_edit_modal').on('show.bs.modal', function (event) {
                active_task = $(event.relatedTarget).data('task_id');
                $.ajax({
                    url: '/api/t/' + active_task,
                    dataType: 'json',
                    type: 'get',
                    contentType: 'application/x-www-form-urlencoded',
                    data: {},
                    success: function (data, textStatus, jQxhr) {
                        $('#new_title').val(data?.title);
                        $('#new_status').val(data?.status);
                        $('#new_content').val(data?.content);
                        $('#new_deadline').val(data?.deadline);
                        //$('#project_id').val(data?.project_id);
                        $('#task_id').val(active_task);
                        //$('#new_responsibles').val($('#' + active_task + '_responsibles').val());
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        console.log(jqXhr.message);
                    }
                });
            })
            $('#new_responsibles').amsifySuggestags({
                suggestions: [
                    @foreach(\App\User::all() as $user)
                        '{{ $user->username }}',
                    @endforeach
                ]
            });
        });

    </script>
@endpush
