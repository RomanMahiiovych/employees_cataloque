@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 fixed">
                <div class="card">
                    <div class="card-header">

                        <div class="card-group ">
                            <h4>Position</h4>
                            <div class="ml-auto">
                                    <a href="{{route('positions.create')}}" type="button" class="btn btn-secondary">
                                        {{ __('Add Position') }}
                                    </a>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                            <tr>

                                <th>Name</th>
                                <th>Last update</th>
                                <th>Action</th>
                                <th></th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($positions as $position)
                                <tr>

                                    <td>{{$position->name}}</td>
                                    <td>{{$position->updated_at->format('d-m-y')}}</td>
                                    <td>
                                        <a href="{{ route('positions.edit', $position->id) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <form id="form{{$position->id}}" action="{{ route('positions.destroy', $position->id) }}" data-id="{{ $position->id }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-link remove-user" onclick="confirmDelete('form{{$position->id}}', '{{$position->name}}' )"><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.table').DataTable();
        })
    </script>
@endsection

@section('delete_confirmation')
    <script>
        function confirmDelete(item_id, position_id) {
            swal({
                title: "Remove position",
                text: "Are you sure you want to remove position " + position_id + "?",
                icon: false,
                buttons: ["Cancel", "Remove"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#'+item_id).submit();
                    } else {
                        swal("Cancelled Successfully");
                    }
                });
        }
    </script>
@endsection
