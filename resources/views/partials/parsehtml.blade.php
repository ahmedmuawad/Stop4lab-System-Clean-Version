<div class="text-center">
    <form action="{{ route('admin.autoComments.update_single_comment', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <textarea col="50" row="5" name="comment">{!! $comment->comment!!}</textarea>
    </form>
</div>
