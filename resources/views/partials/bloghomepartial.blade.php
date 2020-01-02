@foreach($blogs as $index=>$blog)
    @php
        $arrimg = explode(';',$blog->images);
    @endphp
    <div class="col-md-6 col-12 ">
        <div class="media py-2">
            <div class="col-4 pl-0">
                <a href="/tin-tuc/detail/<?= $blog->slug ?>"><img class="img-thumbnail border-0"
                                                                  src="images/thumbnail.png"></a>
            </div>
            <div class="media-body py-2">
                <a href="/tin-tuc/detail/<?= $blog->slug ?>"><strong
                            class="post-summary2 text-dark w-img-100 d-inline-block mb-2 text-primary">{!! $blog->title !!}</strong></a>
                <div class="d-sm-block d-none">
                    <p class="post-summary3">
                        <?= catchu(strip_tags($blog->description), 500) ?>
                    </p>
                </div>
                <p class="mb-0 mt-auto">
                    <small><?php echo date('d', strtotime($blog->created_at)) ?>
                        /<?php echo date('m', strtotime($blog->created_at)) ?>
                        /<?php echo date('Y', strtotime($blog->created_at)) ?></small>
                </p>
            </div>
        </div>
    </div>
@endforeach