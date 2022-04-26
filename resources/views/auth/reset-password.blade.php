@extends('layouts.auth_layouts',['title' => 'Reset Password'])

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
							<h4 class="card-title">Lupa Password</h4>
							<form method="POST" action="{{ route('password.update') }}" class="my-login-validation" novalidate="">
								@csrf

								@if(session()->has('errors'))
									<div class="alert alert-danger mt-2">
										@foreach($errors->all() as $error)
												{{ $error }}<br>
										@endforeach
									</div>   
								@endif

								@if(session()->has('status'))
									<div class="alert alert-success mt-2">
										{{ session('status') }}
									</div>   
								@endif
                                <div class="form-group">
									<label for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" value="{{ request()->get('email') }}" readonly required autofocus>
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password" required data-eye>
								</div>
								<div class="form-group">
									<label for="password">Konfirmasi Password</label>
									<input id="password" type="password" class="form-control" name="password_confirmation" required data-eye>
								</div>
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Submit
									</button>
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