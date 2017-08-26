@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <div class="panel panel-default">
              <div class="panel-heading">Create Message</div>
              <div class="panel-body">
                <form action="{{ url('/messages') }}" method="POST">
                  {{ csrf_field() }}
                  <div class="form-group">
                    <div class="form-group">
                      <select class="form-control" id="message_to" name="message_to" required>
                        <option value=""></option>
                        <?php
                          $others = $auth->is_student == 1? $common->getActiveTeachers() : $common->getActiveStudents();
                        ?>
                        @foreach($others AS $v)
                          @if (empty($v->fname) && empty($v->tfname))
                            <!-- empty name -->
                          @else
                            <option value="{{ $v->id }}">{{ $v->fname }} {{ $v->lname }}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                    <textarea class="form-control" name="message" placeholder="Your message"></textarea>
                    <input class="form-control btn btn-primary" type="submit" value="Send" />
                  </div>
                </form>
              </div>
          </div>

            <div class="panel panel-default">
                <div class="panel-heading">Messages</div>
                <div class="panel-body">
                  <ul class="list-group">
                    @if($messages == null || count($messages) <= 0)
                      <li class="list-group-item"><span class="badge">0</span> No Message Found </li>
                    @else
                      @foreach($messages AS $v)
                        <li class="list-group-item">
                          <span class="badge">{{ $v->msgcount }}</span>
                          <a href="{{ url('/messages/'.$v->uid) }}" >{{ $v->fname }} {{ $v->lname }}</a>
                        </li>
                      @endforeach
                    @endif
                  </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
