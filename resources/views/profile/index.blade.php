@extends('layouts.app')

@section('title')
  Profile
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">My Profile
                  @if (Auth::check() && $profiles[0]->user_id === Auth::user()->id)
                  [ <a href="{{url('/profile/'.$profiles[0]->id.'/edit')}}">Edit</a> ]
                  @endif
                </div>

                <div class="panel-body">
                  <ul class="list-group">
                    <li class="list-group-item"><strong>First Name:</strong> {{ $profiles[0]->fname }}</li>
                    <li class="list-group-item"><strong>Last Name:</strong> {{ $profiles[0]->lname }}</li>
                    <li class="list-group-item"><strong>Gender:</strong> {{ $profiles[0]->gender }}</li>
                    <li class="list-group-item"><strong>Skype ID:</strong> {{ $profiles[0]->skype }}</li>
                    <li class="list-group-item"><strong>Contact #:</strong> {{ $profiles[0]->contact }}</li>
                    <li class="list-group-item"><strong>Home Address:</strong> {{ $profiles[0]->address }}</li>
                  </ul>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">History</div>

                <div class="panel-body">
                  <table class="table striped">
                    <thead>
                      <tr>
                        <th>Date/Time</th>
                        <th>Teacher</th>
                        <th>Memo</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $counter=0; ?>
                      @foreach($profiles[1] AS $v)
                      <tr>
                        <td>{{ $common->getFormattedDateTimeRange($v->date_time) }}</td>
                        <td>{{ $v->fname }} {{ $v->lname }}</td>
                        <td>
                          @if ($v->called == null)
                          <i class="text-danger">Missed Session</i>
                          @elseif ($v->memo == null)
                          <i class="text-warning">No Memo provided</i>
                          @else
                          Memo: {{ $v->memo }}<br/>Book: {{ $v->memo_book }}<br/>Next Page: {{ $v->memo_next_page }}
                          @endif
                        </td>
                      </tr>
                      <?php $counter++; ?>
                      @endforeach
                    </tbody>
                  </table>
                  <?php //LOAD MORE TODO ?>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
