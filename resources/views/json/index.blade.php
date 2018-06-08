@extends('frontend.layouts.app')

@section('title', app_name())

@section('content')
    <div class="row">
        <div class="col">
            <h3>{{$status}}</h3>
            <div class="alert alert-info">{{$message}}</div>
            <pre>
            {{ json_encode($result, JSON_PRETTY_PRINT) }}
            </pre>
        </div><!--col-->
    </div><!--row-->
@endsection
