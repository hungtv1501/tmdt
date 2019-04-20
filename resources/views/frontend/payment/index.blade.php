@extends('frontend.base-layout')

@section('content')
<div class="row">
	<div class="col-md-12 col-lg-12">
		<h2 class="text-center">Hóa Đơn</h2>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Tên sản phẩm</th>
					<th>Ảnh sản phẩm</th>
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

				@foreach($cart as $key => $item)
					<tr>
						<td>{{ $i }}</td>
						<td>{{ $item->name }}</td>
						<td>
							<img src="{{ URL::to('/') }}/upload/images/{{ $item->options['images'][0] }}" width="100" height="100">
						</td>
						<td>{{ number_format($item->qty) }}</td>
						<td>{{ number_format($item->price) }}</td>
						<td>{{ $item->options['color'] }}</td>
						<td>{{ $item->options['size'] }}</td>
						<td>{{ number_format($item->price * $item->qty) }}</td>
					</tr>

					@php
						$i++;
						$total += $item->price * $item->qty;
					@endphp

				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">Tổng tiền</td>
					<td>{{ number_format($total) }}</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<div class="col-lg-12 col-md-12 mt-5">
		<h2 class="text-center">Thông tin khách hàng</h2>
		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
		<form action="{{ route('fr.paymentOrder') }}" method="POST">
			@csrf
			<div class="form-group">
				<label for="username">(*) Tên khách hàng</label>
				<input type="text" name="username" id="username" class="form-control">
			</div>
			<div class="form-group">
				<label for="email">(*) Email</label>
				<input type="text" name="email" id="email" class="form-control">
			</div>
			<div class="form-group">
				<label for="sdt">(*) Số điện thoại</label>
				<input type="text" name="sdt" id="sdt" class="form-control">
			</div>
			<div class="form-group">
				<label for="address">(*) Địa chỉ giao hàng</label>
				<textarea class="form-control" name="address" id="address"></textarea>
			</div>
			<div class="form-group">
				<label for="note">Ghi chú</label>
				<textarea class="form-control" name="note" id="note"></textarea>
			</div>
			<button class="btn btn-primary btn-block mb-5" type="submit">Thanh toán</button>
		</form>
	</div>
</div>
@endsection