@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h3>All Questions</h3>
                        <div class="ml-auto">
                            <a href="{{route('questions.create')}}" class="btn btn-outline-secondary"> Ask Question</a>
                        </div>
                    </div>   
                </div>

                <div class="card-body">
                    @include('layouts._messages')
                  @foreach ($questions as $question)
                      <div class="media">
                          <div class="d-flex flex-column counter">
                              <div class="vote">
                                    <strong>{{$question->votes}}</strong> {{ Str::plural('vote',$question->votes)}}
                              </div>
                            <div class="status {{ $question->status }}">
                                    <strong>{{$question->answers_count}}</strong> {{ Str::plural('answer',$question->answers_count)}}
                              </div>
                              <div class="view">
                                    {{$question->views. " " . Str::plural('view',$question->views)}}
                              </div>
                          </div>
                          <div class="media-body">
                              <div class="d-flex align-items-center">
                                  <h3 class="mt-0"><a href="{{$question->url}}">{{ $question->title }}</a></h3>
                                  <div class="ml-auto">

                                    {{-- @if(Auth::user()->can('update-question',$question)) --}}
                                    @can('update',$question)
                                         <a href="{{route('questions.edit',$question->id)}}" class="btn btn-sm btn-outline-info">Edit</a>
                                    {{-- @endif --}}
                                    @endcan

                                   {{-- @if(Auth::user()->can('delete-question',$question)) --}}
                                   @can('delete',$question)
                                        <form class="form-delete" action="{{route('questions.destroy',$question->id)}}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    @endcan    
                                   {{-- @endif --}}
                                    
                                  </div>
                              </div>
                              <p class="lead">
                                  Ask by
                                <a href="{{ $question->user->url}}">{{ $question->user->name}}</a>
                              <small class="text-muted">{{ $question->createddate}}</small>
                              </p>
                              {{Str::limit($question->body,250)}}
                          </div>
                      </div>
                      <hr>
                  @endforeach
                      
                      {{--Pagination --}}
                      {{ $questions->links()}}
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
