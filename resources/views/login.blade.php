@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-sm-6">
			<form method="post">
				<h5 class="text-center">Login</h5>
				<div class="form-group">
					<label for="email">Email Address</label>
					<input type="email" name="email" class="form-control useremail">
				</div>
				<div class="form-group">
					<label for="email">Password</label>
					<input type="password" name="password" class="form-control password">				
				</div>

				<div class="form-group">
					<button type="button" class="btn btn-primary submitButton">Login</button>
				</div>
			</form>
			
		</div>
	</div>
</div>

<script type="text/javascript">
	$('.submitButton').on('click', function (e) {
        e.preventDefault();
        var email = $('.useremail').val();
        var password = $('.password').val();
        $.ajax({
            url: "{{url('/api/login-user')}}",
            type: "POST",
            data: {
                email: email,
                password: password
            },
            success: function (data) {
            	console.log(data);
                localStorage.setItem('token',data.token);
                window.location = `{{ url('/home')}}`;
            },
            error: function () {
            	alert('try again');
            	console.log(error.responseJSON);
            }
        });
    });
</script>

@endsection