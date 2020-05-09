@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tags</div>

                <div class="card-body">
                    <form action="{{route('tags')}}" method="post" class="row">
                        @csrf
                        <div class="form-group col-md-6 ">
                            <label for="unit_text">Tag Name</label>
                            <input type="text" class="form-control" id="tag_name" name="tag_name"
                                   placeholder="Tag Name" required>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Save New Tag</button>
                        </div>
                    </form>
                    <div class="row">
                        @foreach($tags as $tag)
                            <div class="col-md-3">
                                <div class="alert alert-primary" role="alert">
                                    <p>{{$tag->tag}}</p>

                                </div>

                            </div>
                        @endforeach
                    </div>

                    {{$tags->links()}}
                </div>
            </div>
        </div>
    </div>
    @if (Session::has('message'))
        <div class="toast" style="position: absolute;z-index:99999;top:5%;right: 5%;" role="alert" aria-live="assertive"
             aria-atomic="true">
            <div class="toast-header">
                <strong class="mr-auto">Unit</strong>
                <span aria-hidden="true">&times;</span>
            </div>
            <div class="toast-body">

                {{Session::get('message')}}
            </div>
        </div>
    @endif

@endsection

@section('scripts')
@if(Session::has('message'))
    <script>
        $(document).ready(function () {
            var $toast = $('.toast').toast({
                autohide: false
            });

            $toast.toast('show');


        });


    </script>
@endif
@endsection
