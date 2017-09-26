@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <div class="panel panel-default">
              <div class="panel-heading">
                @if (Auth::user()->is_student == 1)
                  Tạo tin nhắn
                @else
                  CREATE MESSAGE
                @endif
              </div>
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
                    @if (Auth::user()->is_student == 1)
                      <textarea class="form-control" name="message" placeholder="Viết tin nhắn"></textarea>
                      <input class="form-control btn btn-primary" type="submit" value="Gửi" />
                    @else
                      <textarea class="form-control" name="message" placeholder="Write your message"></textarea>
                      <input class="form-control btn btn-primary" type="submit" value="Send" />
                    @endif
                  </div>
                </form>
              </div>
          </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                  @if (Auth::user()->is_student == 1)
                    Hộp thư
                  @else
                    MY MESSAGES
                  @endif
                </div>
                <div class="panel-body">
                  <ul class="list-group">
                    @if($messages == null || count($messages) <= 0)
                      <li class="list-group-item"><span class="badge">0</span>
                        @if (Auth::user()->is_student == 1)
                          Không có tin nhắn nào
                        @else
                          No messages found.
                        @endif
                      </li>
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
