@extends('layouts.app')

@section('title','Home')

@section('titulo-contenido','Principal')

@section('header-class')
<div class="panel-header panel-header-sm">
</div>
@endsection

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Edit Profile</h5>
            </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                You are logged in!
        </div>
    </div>
</div>
@endsection
