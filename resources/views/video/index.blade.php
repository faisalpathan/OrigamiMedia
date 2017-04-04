@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Videos</div>

                    <div class="panel-body">
                        @if($videos->count())
                            @foreach($videos as $video)
                                <div class="well">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <a href="{{ url('/videos/' . $video->uid) }}">
                                                <img src="{{ $video->getThumbnail() }}" alt="{{ $video->title }} thumbnail" class="img-responsive img-rounded">
                                            </a>
                                        </div>
                                        <div class="col-sm-9">
                                            <a href="{{ url('/videos/' . $video->uid) }}">{{ $video->title }}</a>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p class="text-muted">
                                                        @if (!$video->isProcessed())
                                                            Processing ({{ $video->processedPercentage() ? $video->processedPercentage() . '%' : 'Starting Up' }})
                                                        @else
                                                            <span>{{ $video->created_at->toDateTimeString() }}</span>
                                                        @endif
                                                    </p>
                                                    <form class="myForm" action="/videos/{{ $video->uid }}" method="post">
                                                        <a href="/videos/{{ $video->uid }}/edit" class="btn btn-info">Edit</a>

                                                        <button type="submit" 
                                                        class="btn btn-danger delete">Delete</button>
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                    </form>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p>{{ ucfirst($video->visibility) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{ $videos->links() }}
                        @else
                            <p>You have no videos.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
<link rel="stylesheet" type="text/css" href="css/sweetalert.css">
<script
  src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
  integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g="
  crossorigin="anonymous"></script>
  <script src="js/sweetalert.min.js"></script>
    <script>
    $('.myForm').on('submit', function(e){
        e.preventDefault();
  swal({   
    title: "Are you sure?",
    text: "You will not be able to recover this lorem ipsum!",         
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, delete it!", 
    closeOnConfirm: false 
  }, 
       function(){   
    $(this).submit();
  });
})
    </script>
@endsection
