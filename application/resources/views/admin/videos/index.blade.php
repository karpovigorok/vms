@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ '/application/assets/admin/css/sweetalert.css' }}">
@endsection

@section('content')

    <div class="admin-section-title">
        <div class="row">
            <div class="col-md-8">
                <h3><i class="entypo-video"></i> <?php echo _i("Videos");?></h3>
                <a href="{{ URL::to('admin/videos/create') }}" class="btn btn-success">
                    <i class="fa fa-plus-circle"></i> <?php echo _i("Add New");?>
                </a>
            </div>
            <div class="col-md-4">
                <form method="get" role="form" class="search-form-full">
                    <div class="form-group"><input type="text" class="form-control" value="<?= Input::get('s'); ?>"
                                                   name="s" id="search-input" placeholder="<?php echo _i("Search...");?>"> <i
                                class="entypo-search"></i></div>
                </form>
            </div>
        </div>
    </div>
    <div class="clear"></div>

    <div class="gallery-env">
        <div class="row">
            @foreach($videos as $video)

                <div class="col-sm-6 col-md-4">

                    <article class="album">

                        <header>

                            <a href="{{ URL::to('video/') . '/' . $video->id }}" target="_blank">
                                <?php if($video->image != ""):?>
                                    <img src="{{ $video->image }}"/>
                                <?php else: ?>
                                    <img src="/application/assets/img/blur-background/2.jpg"/>
                                <?php endif;?>
                            </a>

                            <a href="{{ URL::to('admin/videos/edit') . '/' . $video->id }}" class="album-options">
                                <i class="entypo-pencil"></i>
                                <?php echo _i('Edit');?>
                            </a>
                            <div class="video-status">
                            <?php if($video->type == 'embed'):?>
                                <h3><span class="label label-success"><?php echo _i('Embed');?></span></h3>
                            <?php elseif($video->process_status == -1):?>
                                <h3><span class="label label-danger"><?php echo _i('Converting Error');?></span></h3>
                            <?php elseif($video->process_status != 1):?>
                                <h3><span class="label label-warning"><?php echo _i('Converting In Progress');?></span></h3>
                            <?php endif;?>
                            <?php if($video->active == 1):?>
                                <h3><span class="label label-success"><?php echo _i('Active');?></span></h3>
                            <?php else:?>
                                <h3><span class="label label-danger"><?php echo _i('Disabled');?></span></h3>
                            <?php endif;?>
                            </div>
                        </header>
                        <section class="album-info">
                            <h3>
                                <a href="{{ URL::to('admin/videos/edit') . '/' . $video->id }}"><?php if (strlen($video->title) > 35):
                                        echo mb_substr($video->title, 0, 35) . '...';
                                    else:
                                        echo $video->title;
                                    endif;?></a>
                            </h3>
                            <p>{{ $video->description }}</p>
                        </section>
                        <footer>
                            <div class="album-images-count">
                                <i class="entypo-video"></i>
                            </div>

                            <div class="album-options">
                                <a href="{{ URL::to('admin/videos/edit') . '/' . $video->id }}">
                                    <i class="entypo-pencil"></i>
                                </a>

                                <a href="{{ URL::to('admin/videos/delete') . '/' . $video->id }}" class="delete">
                                    <i class="entypo-trash"></i>
                                </a>
                            </div>
                        </footer>
                    </article>
                </div>
            @endforeach
            <div class="clear"></div>
            <div class="pagination-outter"><?= $videos->appends(Request::only('s'))->render(); ?></div>
        </div>
    </div>
@section('javascript')
    <script src="{{ '/application/assets/admin/js/sweetalert.min.js' }}"></script>
    <script>
        $(document).ready(function () {
            var delete_link = '';

            $('.delete').click(function (e) {
                e.preventDefault();
                delete_link = $(this).attr('href');
                swal({
                    title: "<?php echo _i("Are you sure?");?>",
                    text: "<?php echo _i("Do you want to permanently delete this post?");?>",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "<?php echo _i("Yes, delete it!");?>",
                    closeOnConfirm: false
                }, function () {
                    window.location = delete_link
                });
                return false;
            });
        });

    </script>

@stop

@stop

