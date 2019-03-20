@extends('admin.master')

@section('content')

    <div class="admin-section-title">
        <h3><i class="fa fa-plug"></i> Sitemap.xml Plugin</h3>
    </div>
    <form method="POST" action="">
        <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
                <div class="panel-title">Plugin Settings</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
            <div class="panel-body" style="display: block;">
                <p>Number articles per page</p>
                <input type="text" class="form-control" name="sitemap_articles_per_page" value="@if(isset($sitemap_articles_per_page)){{ $sitemap_articles_per_page }}@else{{ ARTICLES_PER_PAGE }}@endif" />
                <br />
            </div>
        </div>
        <input type="submit" class="btn btn-success pull-right" value="Save Settings" />
        <div class="clear"></div>
    </form>
@stop