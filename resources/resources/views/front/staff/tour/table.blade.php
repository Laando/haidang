<?php $i = 1; ?>
@foreach ($tours as $tour)
    <tr >
        <td><?= $i ?></td>
        <td class="text-primary">
            <strong>{!! link_to_route('tour.edit',$tour->title,[$tour->id]) !!}</strong><br>
            {!! HTML::link(asset($tour->slug), $tour->slug, array('class' => 'fast-edit'))!!}
        </td>
        <td>
            <select>
                <option>Khởi Hành</option>
                <?php foreach($tour->activeDates as $item) : ?>
                    <option><?php echo (date_format(date_create($item->startdate), 'd/m/Y')); ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td><?php echo number_format($tour->adultprice) . ' đ'; ?></td>
        <td>{!! link_to_route('tour.edit', trans('back/tours.edit'), [$tour->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
        @if($user->role->slug == 'admin')
            <td>
                {!! Form::open(['method' => 'DELETE', 'route' => ['tour.destroy', $tour->id]]) !!}
                {!! Form::destroy(trans('back/tours.destroy'), trans('back/tours.destroy-warning')) !!}
                {!! Form::close() !!}
            </td>
        @endif
    </tr>
    <?php $i++ ?>
@endforeach