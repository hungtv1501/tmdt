@extends('frontend.base-layout')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h2 class="text-center mt-3 mb-5">Giỏ hàng</h2>
		<table class="mb-3 table">
			<thead>
				<tr>
					<th>#</th>
					<th>Tên sản phẩm</th>
					<th>Ảnh sản phẩm</th>
					<th>Số lượng</th>
					<th>Đơn giá</th>
					<th>Màu sắc</th>
					<th>Kích cỡ</th>
					<th>Thành tiền</th>
					<th colspan="2" width="5%">Chuc nang</th>
				</tr>
			</thead>
			<tbody>
				@php
					$i=1;
				@endphp

				@foreach($cart as $key => $item)
					<tr>
						<td>{{ $i }}</td>
						<td>{{ $item->name }}</td>
						<td>
							<img src="{{ URL::to('/') }}/upload/images/{{ $item->options['images'][0] }}" width="100" height="100">
						</td>
						<td>
							<input id="qty_{{ $key }}" type="number" style="width: 50px;" value="{{ $item->qty }}">
						</td>
						<td>{{ number_format($item->price) }}</td>
						<td>{{ $item->options['color'] }}</td>
						<td>{{ $item->options['size'] }}</td>
						<td>{{ number_format($item->price * $item->qty) }}</td>
						<td>
							<button id="{{ $key }}" class="btn btn-danger deleteCart">Xóa</button>
						</td>
						<td>
							<button id="{{ $key }}" class="btn btn-info updateCart">Cập nhật</button>
						</td>
					</tr>

					@php
						$i++;
					@endphp

				@endforeach
			</tbody>
			<tfoot>
				<td colspan="8"></td>
				<td>
					<a href="{{ route('fr.product') }}" class="btn btn-primary">Mua tiếp</a>
				</td>
				<td>
					<a href="{{ route('fr.payment') }}" class="btn btn-success">Thanh toán</a>
				</td>
			</tfoot>
		</table>
	</div>
</div>
@endsection

@push('js')
<script type="text/javascript">
	$(function() {
		$(".deleteCart").click(function() {
			let self = $(this);
			let rowId = self.attr('id').trim();
			// alert(rowId);
			if (rowId) {
				$.ajax({
					url: '{{ route('fr.deleteCart') }}',
					type: "POST",
					data: {id: rowId},
					beforeSend: function() {
						self.text('Loading...');
					},
					success: function(result) {
						self.text('Xóa');
						result = $.trim(result);
						if (result === 'OK') {
							alert("Xóa thành công!");
							window.location.reload(true);
						}
						else {
							alert("Xóa không thành công!");
						}
					}
				});
			}
		});

		$(".updateCart").click(function() {
			let self = $(this);
			let rowId = self.attr('id').trim();
			let qty = $("#qty_"+rowId).val().trim();
			// alert(rowId+qty);
			if (qty) {
				$.ajax({
					url: '{{ route('fr.updateCart') }}',
					type: "POST",
					data: {id: rowId, qty: qty},
					beforeSend: function() {
						self.text('Loading...');
					},
					success: function(result) {
						self.text('Cập nhật');
						result = $.trim(result);
						if (result === 'OK') {
							alert("Cập nhật thành công!");
							window.location.reload(true);
						}
						else {
							alert("Cập nhật lỗi!");
						}
					}
				});
			}
		});
	});
</script>
@endpush