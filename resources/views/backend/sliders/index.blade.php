@extends('backend.layout.master')

@push('styles')
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <a class="btn btn-primary float-right" href="{{ route('sliders.create') }}">+ Add Slider</a>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sliders as $slider)
                        <tr>
                            <td>{{ $slider->id }}</td>
                            <td>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch{{ $slider->id }}"
                                        {{ $slider->active ? 'checked' : '' }} data-id="{{ $slider->id }}">
                                    <label class="custom-control-label" for="customSwitch{{ $slider->id }}"></label>
                                </div>
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary view-image-btn" data-toggle="modal"
                                    data-target="#sliderModal" data-image="{{ asset('storage/' . $slider->image) }}">
                                    <i class="fa fa-eye"></i>
                                </button>

                                <form action="{{ route('sliders.destroy', $slider) }}" method="POST"
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

    <!-- Modal -->
    <div class="modal fade" id="sliderModal" tabindex="-1" role="dialog" aria-labelledby="sliderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sliderModalLabel">Slider Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="sliderImage" src="" alt="Slider Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.view-image-btn').click(function() {
                var imageUrl = $(this).data('image');
                $('#sliderImage').attr('src', imageUrl);
            });

            $('.custom-control-input').change(function() {
                var sliderId = $(this).data('id');
                var isActive = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    url: '/sliders/' + sliderId + '/status',
                    method: 'PATCH',
                    data: {
                        id: sliderId,
                        active: isActive,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
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
                            showConfirmButton: true
                        });
                    }
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
        });
    </script>
@endpush
