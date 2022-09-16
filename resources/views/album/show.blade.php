@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <form method="post" action="{{route('file.store')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                            @csrf
                            <input type="hidden" name="album" id="album" value="{{$album->id}}">
                            <input type="hidden"  id="delete-url" value="{{route('file.delete')}}">
                            <input type="hidden"  id="init-url" value="{{route('file.getall' , $album->id)}}">
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col" id="images-container">

                            </div>
                        </div>

{{--                        @if($album->getMedia()->count() > 0)--}}
{{--                                <div class="col">--}}
{{--                                @foreach($album->getMedia() as $media)--}}
{{--                                    <img class="img-thumbnail m-3" src="{{$media->getFullUrl()}}"  width="170" height="170">--}}
{{--                                @endforeach--}}
{{--                                </div>--}}
{{--                        @endif--}}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js-scripts')

    <script src="{{ asset('js/custom.js') }}" ></script>

@endsection
