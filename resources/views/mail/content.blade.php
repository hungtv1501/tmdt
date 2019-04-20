<h2>Cảm ơn bạn đã mua hàng tại TMDT Shop</h2>
<h3>Danh sách sản phẩm đặt mua:</h3>
<table class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>Tên sản phẩm</th>
			<th>Số lượng</th>
			<th>Đơn giá</th>
			<th>Màu sắc</th>
			<th>Kích cỡ</th>
			<th>Tiền</th>
		</tr>
	</thead>
	<tbody>
		@php
			$i=1;
			$total = 0;
		@endphp

		@foreach($infoPd as $key => $item)
			<tr>
				<td>{{ $i }}</td>
				<td>{{ $item['name'] }}</td>
				<td>{{ number_format($item['qty']) }}</td>
				<td>{{ number_format($item['price']) }} VND</td>
				<td>{{ $item['options']['color'] }}</td>
				<td>{{ $item['options']['size'] }}</td>
				<td>{{ number_format($item['price'] * $item['qty']) }}</td>
			</tr>

			@php
				$i++;
				$total += $item['price'] * $item['qty'];
			@endphp

		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">Tổng tiền</td>
			<td>{{ number_format($total) }} VND</td>
		</tr>
	</tfoot>
</table>

<h3>Nhân viên TMDT Shop sẽ sớm liên lạc với bạn! Trân trọng!</h3>