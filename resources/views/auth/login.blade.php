@extends('layouts.app')

@section('title')
  Login
@endsection

@section('content')
  <div class="center-sign">
    <a href="/" class="logo float-start">
      <img src="{{ asset('img/logo.png') }}" height="70" alt="Porto Admin"/>
    </a>

    <div class="panel card-sign">
      <div class="card-title-sign mt-3 text-end">
        <h2 class="title text-uppercase font-weight-bold m-0"><i
              class="bx bx-user-circle me-1 text-6 position-relative top-5"></i> Sign In</h2>
      </div>
      <div class="card-body">
        <form action="{{ route('login.do') }}" method="post">
          @csrf

          @if($errors->all())
            @foreach($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          @endif

          <div class="form-group mb-3">
            <label>Email</label>
            <div class="input-group">
              <input name="email" id="email" type="email" class="form-control form-control-lg"
{{--                     value="{{ old('email') }}"/>--}}
                     value="cris@admin.com"/>
              <span class="input-group-text"><i class="bx bx-user text-4"></i></span>
            </div>
          </div>

          <div class="form-group mb-3">
            <div class="clearfix">
              <label class="float-start">Contraseña</label>
            </div>
            <div class="input-group">
              <input name="password" id="email" type="password" class="form-control form-control-lg" value="cris"/>
              <span class="input-group-text">
										<i class="bx bx-lock text-4"></i>
									</span>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="checkbox-custom checkbox-default">
                <input id="RememberMe" name="rememberme" type="checkbox" disabled/>
                <label for="RememberMe">Remember Me</label>
              </div>
            </div>
            <div class="col-sm-6 text-end">
              <button type="submit" class="btn btn-primary mt-2">Iniciar Sesion</button>
            </div>
          </div>

{{--          <span class="mt-3 mb-3 line-thru text-center text-uppercase">--}}
{{--								<span>or</span>--}}
{{--          </span>--}}
{{--          <p class="text-center">Don't have an account yet? <a href="pages-signup.html">Sign Up!</a></p>--}}
        </form>
      </div>
    </div>
  </div>
@endsection
