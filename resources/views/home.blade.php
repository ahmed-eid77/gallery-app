@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if(Session::has('success'))
                <p class="alert alert-success" role="alert">{{ Session::get('success') }}</p>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>Images</div>
                            <div>
                                <div class="btn-group bg-primary" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary"><a href="{{ route('home', ['sort' => 'oldest']) }}" style="color: white; text-decoration: 0">Oldest</a></button>
                                    <button type="button" class="btn btn-primary"><a href="{{ route('home', ['sort' => 'latest']) }}" style="color: white; text-decoration: 0">Latest</a></button>

                                  </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-3">
                                <div class="list-group">
                                    <a href="{{ route('home') }}" class="list-group-item list-group-item-action">All</a>
                                    <a href="{{ route('home', ['category' => 'personal']) }}" class="list-group-item list-group-item-action">Personal</a>
                                    <a href="{{ route('home', ['category' => 'friends']) }}" class="list-group-item list-group-item-action">Friends</a>
                                    <a href="{{ route('home', ['category' => 'family']) }}" class="list-group-item list-group-item-action">Family</a>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">

                                        @if ($errors->any())
                                        @foreach ($errors->all() as $error )
                                            <p class="alert alert-danger" role="alert"><strong>ERROR!</strong> : {{ $error }}</p>
                                        @endforeach
                                        @endif

                                        <button data-bs-toggle="collapse" class="btn btn-success" data-bs-target="#demo">Add
                                            Image</button>

                                        <div id="demo" class="collapse">
                                            <form action="{{ route('image-store') }}" method="POST" id="image_upload_form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="caption">Image Caption</label>
                                                    <input type="text" name="caption" class="form-control" placeholder="Enter Caption"
                                                        id="caption">
                                                </div>
                                                <div class="form-group">
                                                    <label for="category">Select Category:</label>
                                                    <select name="category" class="form-control" id="sel1">
                                                        <option value="">Select Category</option>
                                                        <option value="personal">Personal</option>
                                                        <option value="friends">Friends</option>
                                                        <option value="family">Family</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Upload Image</label>
                                                        <div class="preview-zone hidden">
                                                            <div class="box box-solid">
                                                                <div class="box-header with-border">
                                                                    <div><b>Preview</b></div>
                                                                    <div class="box-tools pull-right">
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-xs remove-preview">
                                                                            <i class="fa fa-times"></i> Cancel
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="box-body"></div>
                                                            </div>
                                                        </div>
                                                        <div class="dropzone-wrapper">
                                                            <div class="dropzone-desc">
                                                                <i class="glyphicon glyphicon-download-alt"></i>
                                                                <p>Choose an image file or drag it here.</p>
                                                            </div>
                                                            <input type="file" name="image" class="dropzone">
                                                        </div>
                                                        <div id="image_error"></div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">

                                            @if (count($data['images']))
                                                @foreach ($data['images'] as $item)
                                                    <div class="col-md-3 mt-4">
                                                        <a href="#">
                                                            <img src="{{ asset('user_images/thumbnail') }}/{{ $item->image }}" height="100%"
                                                                width="100%">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @else
                                                    <div class="col-md-12">
                                                        <p>No Images Found</p>
                                                    </div>
                                            @endif

                                            @if (count($data['images']))
                                                    <div class="col-md-12">
                                                        {{ $data['images']->links() }}
                                                    </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
