@extends('admin.base')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center">Sản Phẩm</h3>
	</div>
</div>
<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
	<div class="input-group">
  		<input type="text" class="form-control bg-light border-1 small" placeholder="Tìm kiếm ..." aria-label="Search" aria-describedby="basic-addon2" id="keyword">
  		<div class="input-group-append">
    		<button id="btnSearch" class="btn btn-primary" type="button">
      			<i class="fas fa-search fa-sm"></i>
    		</button>
  		</div>
	</div>
</form>
<br><br>
@if($message != '')
<div class="alert alert-danger">
	<h3>{{ $message }}</h3>
</div>
@endif
@if($mes != '')
<div class="alert alert-danger">
	<h3>{{ $mes }}</h3>
</div>
@endif
<div class="row">
	<div class="col-md-12">
		<a href="{{ route('admin.addProduct') }}" class="btn btn-primary">Thêm Sản Phẩm</a>
		<a href="{{ route('admin.products') }}" class="btn btn-primary">Tất cả Sản Phẩm</a>
	</div>
</div>
<div class="row mt-3">
	<div class="col-md-12">
		<table class="table text-center">
			<thead>
				<tr>
					<th>Mã SP</th>
					<th>Tên SP</th>
					<th>Ảnh</th>
					<th>Danh mục</th>
					<th>Màu sắc</th>
					<th>Kích cỡ</th>
					<th>Thương hiệu</th>
					<th>Đơn giá</th>
					<th>Số lượng</th>
					<th colspan="2">Chức năng</th>
				</tr>
			</thead>
			<tbody>
				@foreach($products as $key => $item)
				<tr id="row_{{ $item['id'] }}">
					<td>{{ $item['id'] }}</td>
					<td>{{ $item['name_product'] }}</td>
					<td>
						<img src="{{ URL::to('/') }}/upload/images/{{ $item['image_product'][0] }}" alt="{{ $item['name_product'] }}" width="100" height="100">
					</td>
					<td>
						<p>
							@foreach($item['categories_id']['name_cat'] as $name_cat)
								{{ $name_cat.',' }}
							@endforeach
						</p>
					</td>
					<td>
						<p>
							@foreach($item['colors_id']['name_color'] as $name_color)
								{{ $name_color.',' }}
							@endforeach
						</p>
					</td>
					<td>
						<p>
							@foreach($item['sizes_id']['name_size'] as $name_size)
								{{ $name_size.',' }}
							@endforeach
						</p>
					</td>
					<td>{{ $item['brand_name'] }}</td>
					<td>{{ $item['price'] }}</td>
					<td>{{ $item['qty'] }}</td>
					<td>
						<a href="{{ route('admin.editProduct', ['id' => $item['id'] ]) }}" class="btn btn-info">Sửa</a>
					</td>
					<td>
						<button class="btn btn-danger btnDelete" id="{{ $item['id'] }}">Xóa</button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{-- {{ $link->links() }} --}}
		<div style="margin-left: 500px;">
			{{ $link->appends(request()->query())->links() }}
		</div>
	</div>
</div>
@endsection

@push('js')
	<script type="text/javascript">
		$(function () {
			$(".btnDelete").click(function() {
				let self = $(this);
				let idPd = self.attr('id');
				// alert(idPd);
				if ($.isNumeric(idPd)) {
					$.ajax({
						url:"{{ route("admin.deleteProduct") }}",
						type:"POST",
						data:{id:idPd},
						beforeSend: function() {
							self.text("Loading ...");
						},
						success: function(result) {
							self.text("Xóa");
							result = $.trim(result);
							if (result === "OK") {
								alert("Xóa sản phẩm thành công");
								// window.location.reload(true);
								$("#row_"+idPd).hide();
							}
							else {
								alert("Xóa không thành công");
							}
							return false;
						},
					});
				}
			});

			$('#btnSearch').click(function() {
        		let keyword = $.trim($('#keyword').val());
        		// alert(keyword);
        		if (keyword.length > 0) {
          			window.location.href = "{{ route('admin.products') }}" + "?q=" + keyword;
        		}
      		});
		});
	</script>
@endpush