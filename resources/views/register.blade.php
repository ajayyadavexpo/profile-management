@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-sm-6">
			<form method="post">
				<h5 class="text-center">Register</h5>
				<div class="form-group">
					<label for="name">Name</label>
					<input type="name" name="name" class="form-control username">				
				</div>
				<div class="form-group">
					<label for="email">Email Address</label>
					<input type="email" name="email" class="form-control useremail">	
				</div>
				
				<div class="form-group">
					<label for="email">Password</label>
					<input type="password" name="password" class="form-control password">				
				</div>
				<div class="form-group">
					<label for="email">Confirm Password</label>
					<input type="password" name="password_confirmation" class="form-control password_confirmation">				
				</div>
				
				<div class="form-group">
					<button type="button" class="btn btn-primary submitButton">Sign up</button>
				</div>
			</form>
			

		</div>
	</div>
</div>

<script type="text/javascript">
	$('.submitButton').on('click', function (e) {
        e.preventDefault();
        var username = $('.username').val();
        var useremail = $('.useremail').val();
        var password = $('.password').val();
        var password_confirmation = $('.password_confirmation').val();
        $.ajax({
            url: "{{url('/api/register-user')}}",
            type: "POST",
            data: {
            	name: username,
                email: useremail,
                password: password,
                password_confirmation: password_confirmation
            },
            success: function (data) {
            	console.log(data);
                localStorage.setItem('token',data.token);
            	window.location = `{{ url('/home')}}`;
            },
            error: function (error) {
            	alert('try again');
            	console.log(error.responseJSON);
            }
        });
    });
</script>

@endsection