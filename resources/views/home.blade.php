@extends('layouts.app')

@section('content')

<input type="hidden" value="{{route('album.move')}}" id="move-url">
<input type="hidden" value="{{route('album.delete')}}" id="delete-all-url">

<div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" id="album-id" name="id">
                        <div id="model-contecxt">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="AddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-form" method="POST" action="{{route("album.store")}}">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Album Name:</label>
                        <input type="text" class="form-control" id="album-name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-add">Add</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <input type="hidden" value="{{route("album.index")}}" id="stsrt-all">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> {{ __('Your Albums') }}

                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#AddModal" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        Add
                    </button>

                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul class="list-group">
                        @if ($albums->count() > 0)
                            @foreach($albums as $album)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{route('show' , $album->id)}}">{{$album->name}}</a>
                                    <span class="badge bg-primary ">{{$album->getMedia()->count()}}</span>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#DeleteModal" data-bs-album-count="{{$album->getMedia()->count()}}" data-bs-album-id="{{$album->id}}" role="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-folder-x" viewBox="0 0 16 16">
  <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181L15.546 8H14.54l.265-2.91A1 1 0 0 0 13.81 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91H9v1H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zm6.339-1.577A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/>
  <path d="M11.854 10.146a.5.5 0 0 0-.707.708L12.293 12l-1.146 1.146a.5.5 0 0 0 .707.708L13 12.707l1.146 1.147a.5.5 0 0 0 .708-.708L13.707 12l1.147-1.146a.5.5 0 0 0-.707-.708L13 11.293l-1.146-1.147z"/>
</svg> Delete
                                    </button>
                                </li>
                            @endforeach
                        @else
                            <li class="list-group-item d-flex justify-content-between align-items-center text-center">
                                No Data
                            </li>
                        @endif
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js-scripts')
    <script src="{{ asset('js/home.js') }}" ></script>

@endsection
