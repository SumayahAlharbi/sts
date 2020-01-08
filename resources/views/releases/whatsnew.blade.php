@extends('layouts.material')
@section('title', 'Statuses')
@section('content')

<div class = 'container'>

<!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                               <h2>What's new</h2>
                            </div>
                            <div class="card-body">
                                    @foreach($releases as $release)
                                    
                                    <div class="col-lg-12">
                                        <h4 class="card-title">{{$release->release_version}}</h4>
                                        <h6 class="card-subtitle">{{$release->created_at}}</h6>
                                        <p class="text-justify">{!! $release->release_description !!}</p>
                                    </div>
                                    <hr>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

</div>
@endsection
