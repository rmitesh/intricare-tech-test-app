@forelse ($profiles as $profile)
    <tr>
        <td>{{ $profile->name }}</td>
        <td>{{ $profile->email }}</td>
        <td>{{ $profile->phone }}</td>
        <td>{{ $profile->gender?->getLabel() }}</td>
        <td><img src="{{ asset("storage/$profile->image") }}" width="50"></td>
        <td><a href="{{ asset("storage/$profile->file") }}" target="_blank">Download</a></td>
        <td>
            <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $profile->id }}">Edit</button>
            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $profile->id }}">Delete</button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" align="center">No records found.</td>
    </tr>
@endforelse
