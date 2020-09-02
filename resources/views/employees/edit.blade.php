@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4>{{ __('Edit Employee') }}</h4></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-secondary" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('errors'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('errors') }}
                                </div>
                        @endif

                        <form method="POST" action="{{ route('employees.update', $id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                @if($type_photo == 'image')
                                    <img src="{{ asset('storage/' . $photo) }}" alt="" class="img-thumbnail">
                                @else
                                    <img src="{{ $photo }}" alt="{{ $photo }}">
                                @endif
                                <br>
                                <label for="photo" class="col-md-4 ml-auto">Photo</label>
                                <div class="col-md-12">
                                    <input type="file" id="photo" name="photo" >
                                    @if ($errors->has('photo'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('photo') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 ml-auto">{{ __('Name') }}</label>

                                <div class="col-md-12">
                                    <input id="name" onkeyup="countChar(this)" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$name}}" required autofocus>
                                    <div id="charNum" class="float-right text-gray" ></div>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="col-md-4 ml-auto">{{ __('Phone') }}</label>

                                <div class="col-md-12">
                                    <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ $phone }}" placeholder="+380 (__) ___ __ __"  required autofocus>

                                    <div class="float-right text-gray" >
                                        Required format +380 (xx) XXX XX XX
                                    </div>
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-md-4 ml-auto">{{ __('Email') }}</label>

                                <div class="col-md-12">
                                    <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="position" class="col-md-4 ml-auto">{{ __('Position') }}</label>

                                <div class="col-md-12">

                                    <select id="position" name="position"  class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}" style="width: 100%;" >
                                        @foreach($positions as $position)
                                            <option value="{{$position->name}}">{{$position->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('position'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('position') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="salary" class="col-md-4 ml-auto">{{ __('Salary, $') }}</label>

                                <div class="col-md-12">
                                    <input id="salary" type="text" class="form-control{{ $errors->has('salary') ? ' is-invalid' : '' }}" name="salary" value="{{ $salary }}" required autofocus>

                                    @if ($errors->has('salary'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('salary') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="head" class="col-md-4 ml-auto">{{ __('Head') }}</label>

                                <div class="col-md-12">
                                    <input id="head" type="text" class="form-control{{ $errors->has('head') ? ' is-invalid' : '' }}" name="head" value="{{ $head->name }}" required autofocus>

                                    @if ($errors->has('head'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('head') }}</strong>
                                             </span>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="date_of_employment" class="col-md-4 ml-auto">{{ __('Date of employment') }}</label>

                                <div class="col-md-12">
                                    <input id="date_of_employment" type="text" class="form-control{{ $errors->has('date_of_employment') ? ' is-invalid' : '' }}" data-mask="00.00.00" name="date_of_employment" value="{{ $date_of_employment }}" required autofocus>

                                    @if ($errors->has('date_of_employment'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_of_employment') }}</strong>
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

                            <div class="col-md-12">
                                <a href="{{ route('employees.index') }}">
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

@section('mask')
    <script>

        var phoneMask = IMask(
            document.getElementById('phone'), {
                mask: "+38\\0 (00) 000 00 00"
            });
        var salaryMask = IMask(
            document.getElementById('salary'), {
                mask: 'num',
                maxLength: 6,
                blocks: {
                    num: {
                        // nested masks are available!
                        mask: Number,
                        thousandsSeparator: ', ',
                        max: 500000
                    }
                }
            });

    </script>
@endsection

@section('datepicker')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#date_of_employment" ).datepicker({
                dateFormat: "dd.mm.y"
            });
        } );
    </script>
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

@section('autocomplete')
    <script>
        $(document).ready(function() {
            $('#head').autocomplete({
                source: "{{ url('autocomplete') }}"
            });
        })
    </script>
@endsection
