<!-- Overview of a profile -->

@extends('layouts.app')


@section('content')
<div class="container">


  <div class="container">

    <div class="row">
      <!--  <div class="col-md-2 col-sm-2">
      <img src="/user-placeholder.png" class="img img-responsive img-circle" />
    </div> -->
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="col-md-12 col-sm-12">
          <h1 style="font-weight: 800;">{{Auth::user()->name}}</h1>
          <hr/>
        </div>

        <div class="col-md-1 col-sm-1">
          @unless ($id == Auth::user()->id)
          <meta name="_token" content="{!! csrf_token() !!}" />
          <p>
            <form method="POST" onsubmit="return false;" action="{{ URL::route('subscriptionToggle') }}">
              @if ($canSub)
              <input type="submit" id="subscribe-toggle" class="btn btn-primary" onclick="subscribeTo({{Auth::user()->id}}, {{$id}})" value="Subscribe">
              @else
              <input type="submit" id="subscribe-toggle" class="btn btn-danger" onclick="subscribeTo({{Auth::user()->id}}, {{$id}})" value="Unsubscribe">
              @endif
              <input type="hidden" name="follower_id" value="{{Auth::user()->id}}">
              <input type="hidden" name="followed_id" value="{{$id}}">
              <input type="hidden" name="nojs" value="forthesakeofprogressivenhancement">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
          </p>
          @endunless
        </div>
      </div>


      <div class="row stat-row text-center">
        <div class="col-md-3 col-sm-3 col-xs-6">
          <h1>{{$user->films->count()}}</h1>
          <h2>watched movies</h2>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-6">
          <h1>{{$user->notes->count()}}</h1>
          <h2>reviews</h2>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-6">
          <h1>{{$user->followedUsers->count()}}</h1>
          <h2>followers</h2>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-6">
          <h1>{{$user->followingUsers->count()}}</h1>
          <h2>following</h2>
        </div>
        <p>
          &nbsp; <!-- yess I am ugly -->
        </p>
      </div>
    </div>

  </div>

  <div class="row">
    <div class="panel panel-default">
      <div class="panel-body">

        <h2 style="font-weight: 800;">Films watched</h2>
        <hr/>


        <div class="row">
          @forelse ($user->films as $film)
          <div class="col-md-3 col-sm-4 col-xs-12 watched-movie-case">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="col-md-12 col-xs-12 vcenter">
                  <img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/{{$film->poster_path}}" class="img img-responsive">
                  <p class="text-center movie-card-name">
                    <a href="/film/{{$film->id}}">{{str_limit($film->name, $limit = 20, $end = '...')}}</a>
                  </p>
                </div>
              </div>
              <!-- <div class="panel-footer text-center">
              <div class="star-note">
              @for($j = 0; $j <5; $j++)
              <i class="fa fa-star"></i>
              @endfor
            </div>
          </div>-->
        </div>
      </div>


      @if ($loop->last)


      <div class="col-md-12">
        <a href="/user/{{$user->id}}/films" class="btn btn-default" ><i class="fa fa-film"></i>&nbsp; See developed list</a>
      </div>


      @endif

      @empty

      <div class="col-md-6 col-md-offset-3">

        <div class="panel panel-default text-center">
          <div class="panel-body">
            <br/>
            <i class="fa fa-film" style="font-size: 8em; color: #888;"></i>
            <h1>Whatch some stuff !</h1>
            <p>Your watch list is empty.</p>
            <p>
            </p>
            <p><b>Type the name of a movie you watched in the search bar ;)</b></p>
          </div>
        </div>

      </div>
      @endforelse
    </div>
  </div>
</div>

</div>


<!--

<h2>Notes</h2>
<table>
<tr>
<th>Film's id</th>
<th>Comment</th>
<th>Stars</th>
</tr>
@foreach ($user->notes as $note)
<tr>
<td>{{$note->id}}</td>
<td>{{$note->comment}}</td>
<td>{{$note->stars}}</td>
</tr>
@endforeach
</table>
-->

<div class="row">

  <div class="panel panel-default">
    <div class="panel-body">

      <h2 style="font-weight: 800;">People following {{Auth::user()->name}}</h2>
      <hr/>

      @forelse ($user->followedUsers as $user)
      <div class="col-md-2 col-xs-2 text-center">
        <div class="panel panel-default">
          <div class="panel-body">
            <img src="/user-placeholder.png" class="img img-responsive img-circle" /><br/>
            <p class="user-card-name">
              <a href="/user/{{$user->id}}">{{str_limit($user->name, $limit = 8, $end = '...')}}</a>
            </p>
          </div>
        </div>
      </div>
      @empty

      <div class="col-md-6 col-md-offset-3">

        <div class="panel panel-default text-center">
          <div class="panel-body">
            <br/>
            <i class="fa fa-users" style="font-size: 8em; color: #888;"></i>
            <h1>Be interesting !</h1>
            <p>Add watched movies and review them !</p>
            <p>
          </p>
            <p><b>Type the name of a movie you watched in the search bar ;)</b></p>
          </div>
        </div>

      </div>

      @endforelse
    </div>
  </div>
</div>


<div class="row">

  <div class="panel panel-default">
    <div class="panel-body">

      <h2 style="font-weight: 800;">People followed by {{Auth::user()->name}}</h2>
      <hr/>

      @forelse ($user->followingUsers as $user)
      @if ($user->id != Auth::user()->id)
      <div class="col-md-2 col-xs-2 text-center">
        <div class="panel panel-default">
          <div class="panel-body">
            <img src="/user-placeholder.png" class="img img-responsive img-circle" /><br/>
            <p class="user-card-name">
              <a href="/user/{{$user->id}}">{{str_limit($user->name, $limit = 8, $end = '...')}}</a>
            </p>
          </div>
        </div>
      </div>
      @endif
      @empty

      <div class="col-md-6 col-md-offset-3">

        <div class="panel panel-default text-center">
          <div class="panel-body">
            <br/>
            <i class="fa fa-plus" style="font-size: 8em; color: #888;"></i>
            <h1>Follow some people !</h1>
            <p>You need a few friends to feed your feed.</p>
            <p>
            <a href="{{url('users')}}" class="btn btn-danger">List of Whatching users</a>
          </p>
            <p><b>Or you can search a user in the search bar starting with @</b></p>
          </div>
        </div>

      </div>

      @endforelse
    </div>

  </div>
</div>

</div>

</div>

@endsection
