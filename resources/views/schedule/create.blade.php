@extends('layouts.app')

@section('title')
  Lesson Scheduler
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Calendar for selecting a day -->
            <div class="panel panel-default">
                <div class="panel-heading">Select Day</div>
                <div class="panel-body">
                  <div class="col-md-8 col-md-offset-2">
                    <div id="datepicker"></div>
                  </div>
                </div>
            </div>
            <!-- Per hour scheduling -->
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="current-day"></h3></div>
                <div class="panel-body">
                  <div class="col-md-6">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th colspan="2">Morning Schedule</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>6:00 AM to 6:30 AM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>6:30 AM to 7:00 AM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>7:00 AM to 7:30 AM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>7:30 AM to 8:00 AM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>8:00 AM to 8:30 AM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>8:30 AM to 9:00 AM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>9:00 AM to 9:30 AM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>9:30 AM to 10:00 AM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>10:00 AM to 10:30 AM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>10:30 AM to 11:00 AM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>11:00 AM to 11:30 AM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>11:30 AM to 12:00 AM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th colspan="2">Afternoon Schedule</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>12:00 PM to 12:30 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>12:30 PM to 1:00 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>1:00 PM to 1:30 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>1:30 PM to 2:00 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>2:00 PM to 2:30 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>2:30 PM to 3:00 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>3:00 PM to 3:30 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>3:30 PM to 4:00 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>4:00 PM to 4:30 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>4:30 PM to 5:00 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>5:00 PM to 5:30 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>5:30 PM to 6:00 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>6:00 PM to 6:30 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>6:30 PM to 7:00 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>7:00 PM to 7:30 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>7:30 PM to 8:00 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>8:00 PM to 8:30 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>8:30 PM to 9:00 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>9:00 PM to 9:30 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                        <tr>
                          <td>9:30 PM to 10:00 PM</td>
                          <td><button class="btn btn-primary">Reserve</button></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
