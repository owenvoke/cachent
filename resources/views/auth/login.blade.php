@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>Log In</h1>
        </div>
        <form action="{{ route('login') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email">Email:</label>
                <input name="email" class="form-control" id="email">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input name="password" type="password" class="form-control" id="password">
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-default btn-primary btn-wide btn-text-left">
                    <span>Log in</span>
                </button>
            </div>
        </form>
    </div>
@endsection