@extends('backend.layout.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <a class="btn btn-primary float-right" data-toggle="modal" data-target="#createBookTypeModal">+ Add Book Type</a>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type Name</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($booktypes as $key => $booktype)
                        <tr>
                            <td>{{ $booktype->id }}</td>
                            <td>{{ $booktype->name }}</td>
                            <td>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch{{ $booktype->id }}"
                                        {{ $booktype->active ? 'checked' : '' }} data-id="{{ $booktype->id }}">
                                    <label class="custom-control-label" for="customSwitch{{ $booktype->id }}"></label>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('booktypes.edit', $booktype) }}" class="btn btn-primary"
                                    data-toggle="modal" data-target="#editBookTypeModal"><i class="fa fa-edit"></i></a>

                                <form action="{{ route('booktypes.destroy', $booktype) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Type Name</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="modal fade" id="createBookTypeModal" tabindex="-1" role="dialog"
        aria-labelledby="createBookTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('booktypes.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createBookTypeModalLabel">Add Book Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Type Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Book Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editBookTypeModal" tabindex="-1" role="dialog" aria-labelledby="editBookTypeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('booktypes.update', $booktype->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBookTypeModalLabel">Add Book Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Type Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $booktype->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="customSwitchActive">Active</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitchActive" name="active"
                                    value="1">
                                <label class="custom-control-label" for="customSwitchActive"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Book Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.custom-control-input').on('change', function() {
                const bookTypeId = $(this).data('id');
                const isActive = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    url: `/booktypes/${bookTypeId}/update-active`, // Update with the correct route
                    method: 'PATCH',
                    data: {
                        active: isActive,
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            text: 'Status updated successfully!',
                            showConfirmButton: false,
                            timer: 2000,
                            toast: true,
                            position: 'top-end'
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            text: 'Error updating status!',
                            showConfirmButton: false,
                            timer: 2000,
                            toast: true,
                            position: 'top-end'
                        });
                    }
                });
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end'
            });
        @endif
    </script>
@endpush
