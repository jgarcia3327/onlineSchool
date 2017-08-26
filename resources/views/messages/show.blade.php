@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Recipient: <strong>{{ $messages[1]->fname }} {{ $messages[1]->lname }}</strong></div>

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
                          <textarea class="form-control" name="message" placeholder="Your message"></textarea>
                          <input class="form-control btn btn-success" type="submit" value="Send" />
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
