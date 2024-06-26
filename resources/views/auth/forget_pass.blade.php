@extends('layout/app')
@section('title','Forget Password')
@section('content')

<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <a href="#" class="logo d-flex align-items-center w-auto">
                                <img src="{{asset('public/img/logo.png')}}" alt="">
                                <span class="d-none d-lg-block">Blog</span>
                            </a>
                        </div><!-- End Logo -->

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Forget Password</h5>

                                </div>
                                {{-- message --}}
                                @session('status')
                                <div class="alert alert-success" role="alert">
                                    {{$value}}
                                </div>
                                @endsession
                                {{-- message --}}
                                {{-- error msg --}}
                                @session('error')
                                <div class="alert alert-danger" role="alert">
                                    {{$value}}
                                </div>
                                @endsession
                                {{-- erromsg end --}}

                                <form class="row g-3" action="{{route('forget_password_create')}}" method="post">
                                    @csrf
                                    <div class="col-12">
                                        <label for="email" class="form-label"> Email</label>
                                        <input type="email" name="email" class="form-control" id="email">
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Forget Password</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Don't have account? <a href="{{route('register')}}">Create
                                                an account</a></p>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Already have an account? <a href="{{route('login')}}">Log
                                                in</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
</main><!-- End #main -->
@endsection