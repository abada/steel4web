@if ($breadcrumbs)
    <ul class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$breadcrumb->last)
                <li><a href="{{ $breadcrumb->url }}">
					@if (isset($breadcrumb->icon))
						<i class="fa {{ $breadcrumb->icon }}"></i>
					@endif
                 	{{ $breadcrumb->title }}</a>
                 </li>
            @else
                <li class="active">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ul>
@endif