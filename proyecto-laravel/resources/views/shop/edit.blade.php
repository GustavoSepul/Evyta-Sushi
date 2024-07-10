@extends('layouts.app')

@section('template_title')
    Update Shop
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Shop</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('shop.update', $shop->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('shop.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
