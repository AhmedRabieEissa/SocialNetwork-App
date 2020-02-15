@extends('layouts.master')
@section('content')
    <div class="row">
         <div class="col-md-12">
             @include('includes.error-block')
         </div>
    </div>
    <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
            <header>
                <h3>What Do You Want To Say ? </h3>
            </header>
            <form action="{{ route('create.post') }}" method="post">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="body" id="new-post" rows="5" placeholder="Your Post.."></textarea>
                </div>
                <button class="btn btn-primary" type="submit"> Create Post</button>
            </form>
        </div>
    </section>
    <section class="row posts">
        <div class="col-md-6 col-md-offset-4">
            <header><h3>What Other People Say..</h3></header>
            @foreach($post as $post)
                <article class="post" data-postid="{{ $post->id }}">
                    <p> {{ $post->body }} </p>
                    <div class="info">
                        {{ $post->user->name }} on {{ $post->created_at}}
                    </div>
                    <div class="interactions">
                        <a href="#" >Like</a> |
                        <a href="#">Dislike</a>
                        @if(Auth::USer() == $post->user)
                            |
                            <a href="#" class="edit">Edit</a> |
                            <a href="{{ route('post.delete',['post_id'=>$post->id]) }}">Delete</a> |
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    <div class="modal" tabindex="-1" role="dialog" id="edit-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="post-body">Edit Your Post</label>
                            <textarea class="form-control" name="post-body" rows="5" id="post-body"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
