<h4>Profile form</h4>

<form id="profile-form"
    @if (!is_null($profile->id))
        action="{{ route('profile.update', ['profile' => $profile]) }}"
    @else
        action="{{ route('profile.create') }}"
    @endif
    method="POST"
>

    @if (!is_null($profile->id))
        @method('put')
    @endif

    <div class="row">
        <div class="col-lg-3">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" value="{{ $profile?->name }}" id="name" name="name" class="form-control">
            </div>
        </div>

        <div class="col-lg-3">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" value="{{ $profile?->email }}" id="email" name="email" class="form-control">
            </div>
        </div>

        <div class="col-lg-3">
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" value="{{ $profile?->phone }}" id="phone" name="phone" class="form-control">
            </div>
        </div>

        <div class="col-lg-3">
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select id="gender" name="gender" class="form-control">
                    <option @checked($profile?->gender == 'male') value="male">Male</option>
                    <option @checked($profile?->gender == 'female') value="female">Female</option>
                </select>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*" />
            </div>
        </div>

        <div class="col-lg-3">
            <div class="mb-3">
                <label for="file" class="form-label">File</label>
                <input type="file" id="file" name="file" class="form-control" accept="application/pdf" />
            </div>
        </div>

        <div class="col-12 mt-2">
            <button type="submit" id="btn-submit" class="btn btn-primary">Submit</button>
            <a href="javascript: void(0)" id="clear-form" class="btn btn-secondery">Cancel</a>
        </div>
    </div>

</form>
