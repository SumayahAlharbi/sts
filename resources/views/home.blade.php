@extends('layouts.material')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    There will be an amazing Dashboard here in 2021 😂 (يمكن)
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
