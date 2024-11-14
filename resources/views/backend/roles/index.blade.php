@extends('backend.layout.master')

@push('styles')
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <a class="btn btn-primary float-right" href="{{ route('roles.create') }}">+ Add Role</a>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a href="{{ route('roles.show', $role->id) }}" class="btn btn-primary"><i
                                        class="fa fa-eye"></i></a>
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary"><i
                                        class="fa fa-edit"></i></a>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
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
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script></script>
@endpush
