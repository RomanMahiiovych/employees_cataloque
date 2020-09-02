@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 fixed">
                <div class="card">
                    <div class="card-header">

                        <div class="card-group ">
                            <h4>Employee</h4>
                            <div class="ml-auto">
                                <a href="{{route('employees.create')}}" type="button" class="btn btn-secondary">
                                    {{ __('Add Employee') }}
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-secondary" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('errors'))<div class="alert alert-danger" role="alert">
                                 {{ session('errors') }}
                             </div>
                        @endif


                        <table class="table table-responsive" id="table">
                            <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Head</th>
                                <th>Date of employment</th>
                                <th>Phone number</th>
                                <th>Email</th>
                                <th>Salary</th>
                                <th>Action</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    @if($employee->type_photo == 'image')
                                        <td scope="row"><img src="{{ asset('storage/' . $employee->small_photo) }}" alt="{{ $employee->photo }}" class="img-thumbnail"></td>
                                    @else
                                        <td scope="row"><img src="{{ $employee->photo }}" alt="{{ $employee->photo }}"  class="img-thumbnail"></td>
                                    @endif
                                    <td>{{$employee->name}}</td>
                                    <td>{{$employee->position}}</td>
                                    <td>{{$employee->employees()->value('name')}}</td>
                                    <td>{{$employee->date_of_employment}}</td>
                                    <td>{{$employee->phone_number}}</td>
                                    <td>{{$employee->email}}</td>
                                    <td>{{$employee->salary}}</td>
                                    <td>
                                        <a href="{{ route('employees.edit', $employee->id) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <form id="form{{$employee->id}}" action="{{ route('employees.destroy', $employee->id) }}" data-id="{{ $employee->id }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-link remove-user" onclick="confirmDelete('form{{$employee->id}}', '{{$employee->name}}' )"><i class="far fa-trash-alt"></i></button>
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
             $('#table').DataTable();
        })
    </script>
@endsection

@section('delete_confirmation')
    <script>
       function confirmDelete(item_id, employee_id) {
            swal({
                title: "Remove employee",
                text: "Are you sure you want to remove employee " + employee_id + "?",
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
