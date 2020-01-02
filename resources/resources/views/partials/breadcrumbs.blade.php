<ol class="breadcrumb">
    <?php
        $last_title = '';
    ?>
    @foreach ($breadcrumbs as $index=>$breadcrumb)
        <?php
        $nextstr = '';
        if(!$breadcrumb->last) {
            $next = $breadcrumbs[$index+1];
        } else {
            $last_title = $breadcrumb->title;
        }
        ?>
        @if (!$breadcrumb->last)
            <li class="{{ $index==(count($breadcrumbs)-2)?'active':'' }}">
                <a href="{!! $breadcrumb->url !!}" class="link {{ $breadcrumb->first?'home':'' }}">
                    {!!$breadcrumb->title!!}
                </a>
            </li>
        @endif
    @endforeach
</ol>
<div class="clearfix"></div>
<h2 class="captions">{{ $last_title }}</h2>