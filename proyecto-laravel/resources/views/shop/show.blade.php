@extends('layouts.app')

@section('template_title')
    {{ $shop->name ?? 'Show Shop' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Shop</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('shop.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $shop->name }}
                        </div>
                        <div class="form-group">
                            <strong>Address:</strong>
                            {{ $shop->address }}
                        </div>
                        <div class="form-group">
                            <strong>Horario:</strong>
                            {{ $shop->horario }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
