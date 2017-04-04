@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Channel Settings</div>

                    <div class="panel-body">
                        
                    <form action="/channel/{{ $channel->slug }}/edit" method="POST" enctype="multipart/form-data" class="editChannelDetails">
                    

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                <label for="name">Name</label>
                    
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ?  old('name') : $channel->name }}" required >

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                        </div>

                        <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">

                                <label for="slug">Slug</label>
                        
                                <div class="input-group">

                                    <div class="input-group-addon">{{ config('app.url') }}/Channel/ </div>
                                    <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug') ?  old('slug') : $channel->slug }}" required >

                                </div>
                                    @if ($errors->has('slug'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('slug') }}</strong>
                                        </span>
                                    @endif
                        </div>


                         <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                                <label for="description">Description</label>
                    
                                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') ?  old('description') : $channel->description }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                        </div>

                        <label for="image">Channel Image</label>
                         <div class="form-group">

                                {{-- <label for="image">Channel Image</label> --}}
                                {{-- <input type="file" name="image" id="image"> --}}
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 150px; height: 120px;"></div>
                                <div><br/>
                                <span class="btn btn-default btn-file">
                                <span class="fileinput-new">Select Channel image</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="image" id="image" accept="image/*">
                                </span>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                        </div>              
                                    
                        </div>




                        <button class="btn btn-info" type="submit">Update</button>
                        <a href="/channel/{{ $channel->slug }}">
                                <button class="btn btn-default" type="button">Back</button>
                        </a>
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}



                    </form>
                    </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
