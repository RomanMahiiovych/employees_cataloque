@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4>{{ __('Position edit') }}</h4></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('positions.update', $id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name" class="col-md-2 ml-auto">{{ __('Name') }}</label>

                                <div class="col-md-12">
                                    <input id="name" onkeyup="countChar(this)" type="text"  class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $name }}" required autofocus>
                                    <div id="charNum" class="float-right text-gray" ></div>
                                    <br>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="created_at" class="col-md-6 ">
                                        {{ __('Created_at:') }}  <span>{{$created_at}}</span>
                                    </label>

                                    <label for="updated_at" class="col-md-6 float-right">
                                        {{ __('Updated at:') }} <span>{{ $updated_at }}</span>
                                    </label>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="created_at" class="col-md-6 ">
                                        {{ __('Admin created ID:') }} <span>{{ $admin_created_id }}</span>
                                    </label>

                                    <label for="updated_at" class="col-md-6 float-right">
                                        {{ __('Admin updated ID:') }} <span>{{ $admin_updated_id }}</span>
                                    </label>

                                </div>
                            </div>

                            <div class="form-group row col-md-12">
                                <div class="col-md-3 offset-6">
                                    <a href="{{ route('positions.index') }}">
                                        <button type="button" class="btn btn-secondary btn-block">
                                            {{ __('Cancel') }}
                                        </button>
                                    </a>
                                </div>
                                <div class="col-md-3 ml-auto">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('count_of_chars')
    <script>
        function countChar(val) {
            var len = val.value.length;
            var max = 256;
            if (len >= max) {
                val.value = val.value.substring(0, max);
            } else {
                $('#charNum').text(len + "/" + max);
            }
        }
    </script>
@endsection
