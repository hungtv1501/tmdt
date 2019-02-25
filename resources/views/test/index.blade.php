{{-- ke thua file layout --}}
@extends('layout')

@push('css')
	<style type="text/css">
		h2 {
			color: red;
		}
	</style>
@endpush

{{-- truyen ca view conten sang layout view --}}
@section('content')
<div class="row">
	<div class="col-md-12 col-lg-12">
		<div class="container">
			<div class="content" style="min-height: 500px;">
				<h2>This is content</h2>
				<p>My name: {{ $name }}</p>
				<p>My age: {{ $age }}</p>
				<p>Address: {{ $address }}</p>

				<h4>Thong tin sinh vien</h4>
				<table class="table">
					<thead>
						<tr>
							<th>STT</th>
							<th>MSV</th>
							<th>HT</th>
							<th>Tuoi</th>
							<th>Email</th>
							<th>Gioi tinh</th>
							<th>Hoc bong</th>
						</tr>
					</thead>
					<tbody>

						@php
							//khai bao bien ngoai view
							$total = 0;
						@endphp

						@foreach($finfoST as $key => $item)

						@php
							$total += $item['money'];
						@endphp

						<tr>
							<td>{{ $key + 1 }}</td>
							<td>{{ $item['msv'] }}</td>
							<td>{{ $item['name'] }}</td>
							<td>{{ $item['age'] }}</td>
							<td>{{ $item['email'] }}</td>
							{{-- @if($item['gender'] == 1)
							<td>Nam</td>
							@else
							<td>Nu</td>
							@endif --}}

							<td>
								{{ $item['gender'] == 1 ? 'Nam' : 'Nu' }}
							</td>

							<td>{{ $item['money'] }}</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="6">Tong Hoc Bong</td>
							<td>{{ number_format($total) }}</td>
						</tr>
					</tfoot>
				</table>

				<form method="POST" action="{{ route('loginForm') }}">
					@csrf
					<div class="form-group">
						<label for="user">User</label>
						<input type="text" class="form-control" name="user" id="user">
					</div>
					<div class="form-group">
						<label for="pass">Password</label>
						<input type="password" class="form-control" name="pass" id="pass">
					</div>
					<button type="submit" class="btn btn-primary"> Login</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

{{-- se day toan bo code js ra ngoai layout view --}}
@push('js')
	<script type="text/javascript">
		console.log('ABC');
	</script>
@endpush

		