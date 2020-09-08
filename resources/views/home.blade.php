@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-sm-4">
			<img src="" id="selectedImage"  height="150">
			<hr />
			<label for="image">Select Image</label>
			<input type="file" onchange="changeImage(this)" name="file" id="file" class="form-control">

			<button type="button" id="submit"  class="btn btn-info mt-3">Upload</button>
			<p class="text-success mt-2 success_message float-right">Successfully uploaded</p>
			<p class="text-danger mt-2 error_message float-right">Try again</p>

		</div>
		<div class="col-sm-8">
			<form id="formupdate">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label>Name</label>
							<input type="text" name="name" class="name form-control">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Phone</label>
							<input type="number" name="phone" class="phone form-control">
						</div>						
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Profile</label>
							<input type="file" name="profile_image" class="form-control">
						</div>						
					</div>
					

					<div class="col-sm-4">
						<div class="form-group">
							<label>Father Name</label>
							<input type="text" name="father" class="father form-control">
						</div>						
					</div>

					<div class="col-sm-4">
						<div class="form-group">
							<label>Mother Name</label>
							<input type="text" name="mother" class="mother form-control">
						</div>						
					</div>

					<div class="col-sm-4">
						<div class="form-group">
							<label>Wife Name</label>
							<input type="text" name="wife" class="wife form-control">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Child Name</label>
							<input type="text" name="child" class="child form-control">
						</div>
					</div>

					<div class="col-sm-4">
						<div class="form-group">
							<label>House Address </label>
							<input type="text" name="address" class="address form-control">
						</div>						
					</div>

					<div class="col-sm-4">
						<div class="form-group">
							<label>Country </label>
							<input type="text" name="country" class="country form-control">
						</div>						
					</div>

					<div class="col-sm-4">
						<div class="form-group">
							<label>City </label>
							<input type="text" name="city" class="city form-control">
						</div>						
					</div>

					<div class="col-sm-4">
						<div class="form-group">
							<label>State </label>
							<input type="text" name="state" class="state form-control">
						</div>						
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Zip Code </label>
							<input type="text" name="zip_code" class="zip_code form-control">
						</div>						
					</div>
				</div>
				<div class="row justify-content-center mt-3">
					<div class="col-sm-4">
						<button type="button" class="btn btn-primary submitButton">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<script type="text/javascript">

    $.ajax({
        url: "{{url('/api/user')}}",
        type: "get",
        headers: {
		    "Authorization": "Bearer " + localStorage.getItem('token')
		},
        success: function (data) {
        	let user = data.user;
        	let detail = user.detail;
        	$('.name').val(user.name);
        	$('#selectedImage').attr('src', '/image/'+user.profile_image);
        	$('.phone').val(user.phone);
        	$('.father').val(detail.father);
        	$('.mother').val(detail.mother);
        	$('.wife').val(detail.wife);
        	$('.child').val(detail.child);
        	$('.address').val(detail.address);
        	$('.city').val(detail.city);
        	$('.country').val(detail.country);
        	$('.state').val(detail.state);
        	$('.zip_code').val(detail.zip_code);
        },
        error: function (error) {
        	console.log(error.responseJSON);
        }
    });



    $('.submitButton').on('click', function (e) {
        e.preventDefault();
        var form = $('#formupdate').serialize();

        $.ajax({
            url: "{{url('/api/update-user')}}",
            type: "POST",
            headers: {
			    "Authorization": "Bearer " + localStorage.getItem('token')
			},
            data: form,
            success: function (data) {
            	console.log(data);
            	alert('updated');
            },
            error: function (error) {
            	console.log(error.responseJSON);
            }
        });
    });
    

 $(".success_message").hide();	
$(".error_message").hide();

$(document).ready(function (e) {
 $("#submit").on('click',(function(e) {
  e.preventDefault();
    var image_file = $('#selectedImage').attr('src'); // getting file
    if(image_file != ''){ // check if image is selected
	  $.ajax({
	   url: "/api/update-profile",
	   type: "POST",
	   headers: {
		    "Authorization": "Bearer " + localStorage.getItem('token')
		},

	   data: {file:image_file},
	   success: function(data){
	    	console.log(data);
	    	if(data=='error'){
	    		console.log('error');
	    	}else{
	    		$(".success_message").fadeIn(1000);
	    		$(".error_message").hide();	
	    	}
	    },
	    error: function(e){
	      console.log(e);
	    }          
	    });
    }else{
    	$(".error_message").fadeIn(1000);
    }
    }));
});






function changeImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#selectedImage').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection