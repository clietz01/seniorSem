<li class="comment">
    <div class="comment-content">
        <div class="comment-header">
            <p>Created by</p> 
            <p class="display-name">{{ $anonymousUsername }}</p>
            <img src="{{ $reply->profilePicture }}" alt="User's Profile Picture" style="width: 40px; height: 40px; border-radius: 50%;">
        </div>
        <div id="comment-body-container">
            <div class="comment-body">
                <p>{{ $reply->content }}</p>
            </div>
            <div id="timestamp">
                <p>{{ $reply->created_at }}</p>
            </div>
            @if (auth()->check() && $reply->user_id == auth()->user()->id)
                <button class="edit-reply-button" data-edit-id="{{ $reply->id }}">Edit Reply</button>
            @else
                <button class="reply-reply-button" data-reply-id="{{ $reply->id }}">Reply</button>
            @endif
        </div>
    </div>

    <!-- Nested Replies -->
    @if ($reply->replies->isNotEmpty())
        <ul>
            @foreach ($reply->replies as $nestedReply)
                @include('partials.replies', ['reply' => $nestedReply, 'anonymousUsername' => $nestedReply->anonymousUsername])
            @endforeach
        </ul>
    @endif
</li>
