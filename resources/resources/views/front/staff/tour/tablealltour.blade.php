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
					<option><?php echo (date_format(date_create($item->startdate), 'd/m/Y')) ?></option>
				<?php endforeach; ?>
			</select>
		</td>
		<td><?php echo number_format($tour->adultprice) . ' đ'; ?></td>
		<td><?= $tour->traffic ?></td>
		<?php $order = \App\Models\Order::where('tourstaff_id')->where('status', 3)->get();?>
		<td>{{count($order)}}</td>
		<td><?= $tour->user->fullname ?></td>
	</tr>
	<?php $i++ ?>
@endforeach