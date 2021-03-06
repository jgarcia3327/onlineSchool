@extends('layouts.app')

@section('title', "Books - English Hours")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <!-- Books -->
                  Sách
                  @if ($auth->is_admin == 1)
                  <h4>Add Book</h4>
                  <p class="no-title-desc"></p>
                  <form id="book-upload-form" action="{{ url('/books') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group book-fields">
                      <input class="form-control" type="file" name="book" required placeholder="Upload Book" accept="application/pdf" multiple >
                      <input class="form-control" type="text" name="title" required placeholder="Book Title">
                      <textarea class="form-control" name="description" required placeholder="Book Description"></textarea>
                      <input class="form-control btn btn-primary" type="submit" value="Submit" />
                    </div>
                    <div class="upload-progress text-center" style="display: none;">
                      <p class="text-center">Uploading <i class="upload-title text-error-inline"></i>, please wait...</p>
                      <img src="{{asset('images/ajax-loader.gif')}}" />
                    </div>
                  </form>
                  @endif
                </div>

                <div class="panel-body">
                  <div class="row text-center">
                    <ul class="list-group">
                      @foreach($books AS $v)
                        <li class="list-group-item text-left">
                          <span class="fa fa-book fa-2x"></span> <a href="{{ asset('uploaded_books/'.$v->id.'/'.$v->file_name) }}">{{ $v->title }}</a>
                          <i>- {{ $v->description }}</i>
                          @if ($auth->is_admin == 1)
                          <form action="{{ url('/books/'.$v->id) }}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            [ <a class="text-danger" href="javascript:void(0)" onclick="$(this).closest('form').submit()">Delete</a> ]
                          </form>
                          @endif
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@if ($auth->is_admin == 1)
@section('javascript')
<script type="text/javascript">
  $("form#book-upload-form").submit(function(event){
    var book = $("input[name='book']").val();
    var title = $("input[name='title']").val();
    var desc = $("textarea[name='description']").val();
    if (typeof book === "undefined" || typeof title === "undefined" || typeof desc === "undefined" || book =="" || title == "" || desc == "") {
      $(".no-title-desc").html("<i class='text-error-inline'>Empty either Book, Title or Description.</i>");
      event.preventDefault();
      return;
    }
    $(".no-title-desc").html("");
    $(".book-fields").css({"display":"none"});
    $(".upload-title").html(title);
    $(".upload-progress").css({"display":"block"});

  });
</script>
@endsection
@endif
