@extends('layouts.auth_layouts',['title' => 'Register'])

@section('content')
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="{{ url('img/web/'.webInfo('LOGO')) }}" alt="logo">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Login</h4>
							<form method="POST" action="{{ route('register') }}" class="my-login-validation" novalidate="">
								@csrf

								@if(session()->has('errors'))
									<div class="alert alert-danger mt-2">
										@foreach($errors->all() as $error)
												{{ $error }}<br>
										@endforeach
									</div>   
								@endif

								<div class="form-group">
									<label for="email">Nama Lengkap</label>
									<input id="email" type="email" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
								</div>

								<div class="form-group">
									<label for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password" required data-eye>
								</div>

								<div class="form-group">
									<label for="password">Konfirmasi Password</label>
									<input id="password" type="password" class="form-control" name="password_confirmation" required data-eye>
								</div>

								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="remember" id="remember" class="custom-control-input">
										<label for="remember" class="custom-control-label">Remember Me</label>
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Register
									</button>
								</div>
								<div class="mt-4 text-center">
									Sudah punya akun? login <a href="{{ url('login')}}"> disini</a>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; {{ date('Y') }} &mdash; Artikel Project
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection