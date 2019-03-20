@if (count($breadcrumbs))

<ul class="breadcrumbs">
    @foreach ($breadcrumbs as $breadcrumb)
    <li>
        @if ($breadcrumb->url && !$loop->last)
            <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
        @else
            <span class="show-for-sr">Current: </span> {{ $breadcrumb->title }}
        @endif
    </li>
    @endforeach
</ul>
@endif