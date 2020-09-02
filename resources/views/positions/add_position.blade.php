@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4>{{ __('Add Position') }}</h4></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('positions.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name" class="col-md-2 ml-auto">{{ __('Name') }}</label>

                                <div class="col-md-12">
                                    <input id="name" onkeyup="countChar(this)" type="text"  class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
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
                                <a href="{{ route('positions.index') }}">
                                    <button type="button" class="btn btn-secondary col-md-3 offset-5">
                                        {{ __('Cancel') }}
                                    </button>
                                </a>

                                <button type="submit" class="btn btn-primary float-right col-md-3">
                                    {{ __('Save') }}
                                </button>
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
