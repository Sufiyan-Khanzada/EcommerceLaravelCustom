

@extends('layouts.main')
@section('content')
    

  
<section id="page-title" class="background-overlay" data-parallax-image="{{ asset('images/banner/banner.jpg') }}">
    <div class="container">
        <div class="page-title">
            <h1 class="text-uppercase text-medium">Add Image</h1>
        </div>
    </div>
</section>

<section class="custom-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel">
                    <div class="panel-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('add-image-post') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group m-b-5">
                                <label>Title</label>
                                <input type="text" name="title" placeholder="title" class="form-control" value="{{ old('title') }}">
                            </div>
                            <div class="form-group m-b-5">
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-default" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
@section('css')
<style type="text/css">

</style>
@endsection

@section('js')
<script type="text/javascript">
(()=>{
    
})()
</script>
@endsection