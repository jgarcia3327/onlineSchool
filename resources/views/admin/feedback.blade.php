@extends('layouts.app')

@section('title', "User Feedback - English Hours")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <!-- Site Feedback -->
          @if (Auth::check() && $auth->is_admin === 1)
          <div class="panel panel-default">
              <div class="panel-heading">User Feedback
                @if (!empty(session('successFeedback')))
                <span class="help-block">
                    <strong class="text-success">{{ session('successFeedback') }}</strong>
                </span>
                @endif
              </div>

              <div class="panel-body">
                <!-- List of feedbacks -->
                <ul class="list-group">
                  @foreach($feedback AS $v)
                  <li class="list-group-item"><a href="javascript:void(0)" data-toggle="collapse" data-target="#feedback{{$v->id}}">
                    {{ substr($v->remark,0,60) }}{{strlen($v->remark) > 60? '...' : ''}}</a>  <span class="badge">{{$v->reply !== null? 'Replied: '.$v->modify_date->diffForHumans().' | Feedback: ':' '}}{{ $v->create_date->diffForHumans() }}</span>
                    <div id="feedback{{$v->id}}" class="collapse">
                      <ul class="list-group">
                        <li class="list-group-item">{{ $v->remark }}</li>
                        <li class="list-group-item">
                          {!! $v->reply === null? '<i>No reply yet from '.config('app.name').'</i>' : $v->reply !!}
                          <p>[ <a href="javascript:void(0)" data-toggle="collapse" data-target="#reply-feedback{{$v->id}}">Create/update reply</a> ]</p>
                          <!-- reply-feedback -->
                          <div id="reply-feedback{{$v->id}}" class="collapse">
                            <form class="form-horizontal" action="{{ url('/feedback/'.$v->id) }}" method="post">
                              {{ method_field('PUT') }}
                              {{ csrf_field() }}
                              <div class="form-group">
                                  <label for="feedback-remark" class="col-md-4">Reply</label>
                                  <div class="col-md-12">
                                      <textarea id="feedback-remark" class="form-control" name="reply" required>{{ $v->reply !== null? $v->reply: '' }}</textarea>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label for="password" class="control-label"></label>
                                  <div class="col-md-12">
                                      <input type="submit" class="btn btn-primary" value="Submit Reply" >
                                      <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#create-feedback">Cancel</button>
                                  </div>
                              </div>
                            </form>
                          </div>
                          <!-- End reply-feedback -->
                        </li>
                      </ul>
                    </div>
                  </li>
                  @endforeach
                </ul>
                <!-- end list of feedbacks -->
              </div>
          </div>
          @endif
          <!-- end site feedback -->

        </div>
    </div>
</div>
@endsection
