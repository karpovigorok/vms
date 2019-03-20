@extends('admin.master')

@section('content')
    <div class="admin-section-title">
        <div class="row">
            <div class="col-md-8">
                <h3><i class="entypo-comment"></i> <?php echo _i("Comments");?></h3>
            </div>
            <!--div class="col-md-4">
                <form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
            </div-->
        </div>
    </div>
    <div class="clear"></div>
    <table class="table table-striped pages-table">
        <tr class="table-header">
            <th><?php echo _i("Date Add");?></th>
            <th width="70%"><?php echo _i("Comment");?></th>
            <th><?php echo _i("Type");?></th>
            <th><?php echo _i("Status");?></th>
            <th><?php echo _i("User");?></th>
            <th><?php echo _i("Actions");?></th>
        </tr>
            @foreach($comments as $comment)
        <tr>
            <td><p>{{ $comment->created_at }}</p></td>
            <td>
                <a href="{{ URL::to('page') . '/' . $comment->id }}" target="_blank">{{ $comment->comment }}</span></a>
            </td>
            <td><p>{{ $comment->commentable_type }}</p></td>
            <td><p>{{ $comment->approved }}</p></td>
            <td><p>
                <?php if (!is_null($comment->anonymous_username)):?>
                    <?php echo $comment->anonymous_username; ?>
                <?php else:?>
                    <a href="{{ URL::to('admin/user/edit') . '/' . $comment->user->id  }}">{{ $comment->user->username }}</a>
                <?php endif;?>
                </p></td>
            <td>
                <p>
                    <a href="{{ URL::to('admin/comments/delete') . '/' . $comment->id }}" class="btn btn-xs btn-danger delete"><span class="fa fa-trash"></span> <?php echo _i("Delete");?></a>
                </p>
            </td>
        </tr>
        @endforeach
    </table>
    <div class="clear"></div>
    <div class="pagination-outter"><?php echo $comments->render(); ?></div>
@stop