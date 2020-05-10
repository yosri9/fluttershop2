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
                                     <span class="buttons-span">
                                        <span><a class="edit-tag"
                                                 data-tagname="{{$tag->tag}}"
                                                 data-tagid="{{$tag->id}}"
                                                ><i class="fas fa-edit"></i></a></span>
                                       <span><a class="delete-tag"
                                                data-tagname="{{$tag->tag}}"
                                                data-tagid="{{$tag->id}}"
                                                ><i class="fas fa-trash-alt"></i></a></span>

                                   </span>
                                    <p>{{$tag->tag}}</p>

                                </div>

                            </div>
                        @endforeach
                    </div>

                    {{(!is_null($showLinks) && $showLinks) ? $tags->links():''}}

                    <form action="{{route('search-tags')}}" method="get">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6 ">
                                <input type="text" class="form-control" id="tag_search" name="tag_search"
                                       placeholder="Search Tag" required>
                            </div>
                            <div class="form-group col-md-6 ">
                                <button type="submit" class="btn btn-primary">SEARCH</button>

                            </div>
                        </div>
                    </form>
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

    <div class="modal delete-window" tabindex="-1" role="dialog" id="delete-window">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('tags')}}" method="post">

                    <div class="modal-body">
                        <p id="delete-message"></p>
                        @csrf
                        <input type="hidden" name="_method" value="delete"/>
                        <input type="hidden" name="tag_id" value="" id="tag_id">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-primary">DELETE</button>
                    </div>
                </form>

            </div>


        </div>
    </div>

    <form action="{{route('tags')}}" method="post" class="row">

        <div class="modal edit-window" tabindex="-1" role="dialog" id="edit-window">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Tag</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        @csrf
                        <div class="form-group col-md-6 ">
                            <label for="edit_tag_name">Tag Name</label>
                            <input type="text" class="form-control" id="edit_tag_name" name="tag_name"
                                   placeholder="Tag Name" required>
                        </div>


                        <input type="hidden" name="tag_id" id="edit_tag_id">
                        <input type="hidden" name="_method" value="put"/>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                    </div>

                </div>
            </div>
        </div>
    </form>


@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var $deleteUnit = $('.delete-tag');
            var $deletewindow = $('#delete-window');
            var $tagId = $('#tag_id');
            var $deleteMessage = $('#delete-message');
            $deleteUnit.on('click', function (element) {
                element.preventDefault();
                var tag_id = $(this).data('tagid');
                $tagId.val(tag_id);
                $deleteMessage.text('Are you sure you want to delete tag ?');
                $deletewindow.modal('show');
            })

            var $edittag = $('.edit-tag');
            var $editWindow = $('#edit-window');
            var $edit_tag_name = $('#edit_tag_name');
            var $edit_tag_id = $('#edit_tag_id');
            $edittag.on('click', function (element) {
                element.preventDefault();
                var tagName = $(this).data('tagname');
                var tag_id = $(this).data('tagid');

                $edit_tag_id.val(tag_id);
                $edit_tag_name.val(tagName);

                $editWindow.modal('show');
            })
        });
    </script>

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
