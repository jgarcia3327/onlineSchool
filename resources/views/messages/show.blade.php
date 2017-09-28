@extends('layouts.app')

@section('content')
<?php $isStudent = (Auth::user()->is_student == 1)? true : false; ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  @if (!$isStudent)
                    Recipient:
                  @else
                    Người nhận:
                  @endif
                  <strong>{{ $messages[1]->fname }} {{ $messages[1]->lname }}</strong></div>

                <div class="panel-body">
                  <ul class="list-group">
                    @foreach($messages[0] AS $v)
                    <li class="list-group-item {{ $v->message_from == $auth->id ? "message-owner" : ""  }}">{{ $v->message }} <span class="badge message">{{ $v->create_date->diffForHumans() }}</span></li>
                    @endforeach
                    <li class="list-group-item">
                      <form action="{{ url('/messages') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                          <input type="hidden" name="message_to" value="{{ $messages[1]->user_id }}" />
                          @if (!$isStudent)
                            <textarea class="form-control" name="message" placeholder="Your message"></textarea>
                            <input class="form-control btn btn-success" type="submit" value="Send" />
                          @else
                            <textarea class="form-control" name="message" placeholder="Viết tin nhắn"></textarea>
                            <input class="form-control btn btn-success" type="submit" value="Gửi" />
                          @endif
                        </div>
                      </form>
                    </li>
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
