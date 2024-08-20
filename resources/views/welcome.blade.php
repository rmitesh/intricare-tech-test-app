<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
<div class="container mt-5">
    <h2>Profile CRUD with AJAX</h2>

	<section class="mt-5" id="profile-section" style="display: none;"></section>
	
    <section class="mt-5" style="display: none;" id="filter">
		<h4>Filter records</h4>
		<div class="row">
			<div class="col-lg-4">
				<div>
					<label for="search-name" class="form-label">Search by Name</label>
					<input type="text" id="search-name" class="form-control" placeholder="Search Name">
				</div>
			</div>

			<div class="col-lg-4">
				<div>
					<label for="search-email" class="form-label">Search by Email</label>
					<input type="email" id="search-email" class="form-control" placeholder="Search Email">
				</div>
			</div>

			<div class="col-lg-4">
				<div>
					<label for="search-gender" class="form-label">Search by Gender</label>
					<select id="search-gender" class="form-control">
						<option value="">Select Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				</div>
			</div>

			<div class="col-12 mt-2">
				<button id="btn-search" class="btn btn-primary">Search</button>
			</div>
		</div>
		
	</section>


    <div class="mt-5">
		<div class="d-flex justify-content-between align-items-center">
			<h3>Profiles</h3>
			<div class="">
				<a href="javascript: void(0);" id="toggle-filter" class="btn btn-primary">Filter</a>
				<a href="javascript: void(0);" id="toggle-profile-form" class="btn btn-primary ms-2">Create</a>
			</div>
		</div>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Image</th>
                <th>File</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="profile-list">
                <!-- Profiles will be loaded here via AJAX -->
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
	});

    $(document).ready(function () {
        // Load profiles initially
        loadProfiles();

        // Handle form submission
        $(document).on('click', '#btn-submit', function (e) {
            e.preventDefault();
			let form = $(this).parents('form');
			// console.log('form',form.attr('action'), form[0]);
			// return false;
			
			let formData = new FormData(form[0]);
            $.ajax({
                url: `${form.attr('action')}`,
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#profile-section').slideToggle();
					$('#profile-section').html('');

                    loadProfiles();
                },
                error: function (xhr) {
                    alert(Object.values(xhr.responseJSON.errors)[0][0]);
                }
            });
        });

		$(document).on('click', '#toggle-filter', function () {
			$('#filter').slideToggle();
		});

		$(document).on('click', '#clear-form', function () {
			$('#profile-section').slideToggle();
			$('#profile-section').html('');
		})

		// toggle form
		$(document).on('click', '#toggle-profile-form', function () {
			$.get(`/profiles/create`, function (response) {
				if (response.status) {
					$('#profile-section').html(response.data.view);
					$('#profile-section').slideToggle();
					scrollToTop($("#profile-section"));
				}
			});

		});

        // Search profiles
        $('#btn-search').on('click', function () {
            loadProfiles();
        });

        // Function to load profiles via AJAX
        function loadProfiles() {
            let name = $('#search-name').val();
            let email = $('#search-email').val();
            let gender = $('#search-gender').val();
            $.ajax({
                url: '/',
                type: 'GET',
                data: {name: name, email: email, gender: gender},
                success: function (profiles) {
                    $('#profile-list').html(profiles.data.view);
                }
            });
        }

		function scrollToTop(element) {
			$('html, body').animate({
				scrollTop: element.offset().top
			}, 800);
		}

        // Edit profile
        $(document).on('click', '.btn-edit', function () {
            let id = $(this).data('id');
            $.get(`/profiles/${id}/edit`, function (response) {
				if (response.status) {
					$('#profile-section').html(response.data.view);
					$('#profile-section').slideToggle();
					scrollToTop($("#profile-section"));
				}
			});
        });

        // Delete profile
        $(document).on('click', '.btn-delete', function () {
			if (confirm('Are you sure you want to delete?')) {
				let id = $(this).data('id');
				$.ajax({
					url: `/profiles/${id}`,
					type: 'DELETE',
					success: function () {
						loadProfiles();
					}
				});
			}
        });
    });
</script>
</body>
</html>
