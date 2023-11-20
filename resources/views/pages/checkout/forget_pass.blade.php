@extends('layout')
@section('content')

	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Lấy lại mật khẩu</h2>
						<form action="{{URL::to('/login-customer')}}" method="POST">
							{{csrf_field()}}
							<input type="text" name="email_account" placeholder="Tài khoản" />
							<input type="password" name="password_account" placeholder="Password" />
							<button type="submit" class="btn btn-default">Gửi</button>
						</form>
					</div><!--/login form-->
				</div>
			</div>
		</div>
	</section><!--/form-->

@endsection