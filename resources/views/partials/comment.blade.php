<div class="panel panel-default">
        <div class="panel-body">
            {{ $comment->comment }}
        </div>
        <div class="panel-footer clearfix">
            <span class="pull-right">
                {{ $comment->user->name }}
            </span>
        </div>
</div>