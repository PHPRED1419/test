@extends('backend.auth.master')

@section('auth-content')
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center">
<div class="auth-box" style="border: 2px solid #007bff; border-radius: 8px; background-color: #f8f9fa;">
      
        <div id="">
            <div class="logo">
            @if (!empty($settings->general->logo))
                            <img src="{{ asset('assets/images/logo/' . $settings->general->logo) }}"
                                alt="{{ env('APP_NAME') }}" style="width: 200px;" title="{{ env('APP_NAME') }}"/>
                        @endif
                <h5 class="font-medium m-b-20">Recover Password</h5>
                <span>Enter your Email and instructions will be sent to you!</span>
            </div>
            <div class="row m-t-20">
                <!-- Form -->
                <form class="col-12" action="">
                    <!-- email -->
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control form-control-lg" type="email" required="" placeholder="Username">
                        </div>
                    </div>
                    <!-- pwd -->
                    <div class="row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-block btn-lg btn-danger" type="submit" name="action">Reset</button>
                        </div>
                        <div class="col-12 mt-3 text-right">
                            Or, <a class="btn" href="{{ route('admin.login') }}">Login Now</a>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection
