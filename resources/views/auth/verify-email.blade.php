@extends('layouts.auth_layouts',['title' => 'Verifikasi Email'])

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
						<h4 class="card-title text-center">Verifikasi Email</h4>
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
							<div class="mt-4 text-center">
								<p>Registrasi akun berhasil. Satu langkah lagi akun kamu akan aktif. Silahkan verifikasi melalui link yang sudah kami kirimkan ke email kamu.</p>
								<form method="POST" action="{{ route('verification.send') }}">
									@csrf
									<input name="login" value="Kirim Ulang Email" type="submit" class="btn btn-primary btn-block">
								</form>
							</div>
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