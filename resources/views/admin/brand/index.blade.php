@extends('admin.base')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center">Thương Hiệu</h3>
		<h3 class="text-center"></h3>
	</div>
</div>
<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
	<div class="input-group">
  		<input type="text" class="form-control bg-light border-1 small" placeholder="Tìm kiếm..." aria-label="Search" aria-describedby="basic-addon2" id="keyword">
  		<div class="input-group-append">
    		<button id="btnSearch" class="btn btn-primary" type="button">
      			<i class="fas fa-search fa-sm"></i>
    		</button>
  		</div>
	</div>
</form>
<br><br>
<div class="row">
	<div class="col-md-12">
		<a href="{{ route('admin.addBrand') }}" class="btn btn-primary">Thêm thương hiệu</a>
		<a href="{{ route('admin.brand') }}" class="btn btn-primary">Tất cả thương hiệu</a>
	</div>
</div>
<div class="row mt-3">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th>Mã Thương Hiệu</th>
					<th>Tên Thương Hiệu</th>
					<th>Địa Chỉ</th>
					<th>Trạng Thái</th>
					<th>Mô tả</th>
					<th colspan="2" width="3%" class="text-center">Chức năng</th>
				</tr>
			</thead>
			<tbody>
				@foreach($brands as $key => $item)
				<tr id="row_{{ $item['id'] }}">
					<td>{{ $item['id'] }}</td>
					<td>{{ $item['brand_name'] }}</td>
					<td>{{ $item['address'] }}</td>
					<td>{{ $item['status']==0 ? 'Ngung su dung' : 'Dang su dung' }}</td>
					<td>{{ $item['description'] }}</td>
					
					<td>
						<a href="{{ route('admin.editBrand',['id'=> $item['id']]) }}" class="btn btn-info">Sửa</a>
					</td>
					<td>
						<button class="btn btn-danger btnDelete" id="{{ $item['id'] }}">Xóa</button>
					</td>
				</tr>
				@endforeach
			</tbody>
			
		</table>
		{{ $link->links() }}
		{{-- phan trang va tim kiem --}}
		
	</div>
</div>
@endsection
@push('js')
	<script type="text/javascript">
		$(function(){
			$('.btnDelete').click(function() {
				let self = $(this);
				let idBr = self.attr('id');
				if($.isNumeric(idBr)){
					$.ajax({
						url: "{{ route('admin.deleteBrand') }}",
						type: "POST",
						data: {id: idBr},
						beforeSend: function(){
							self.text('Loading ...');
						},
						success: function(result){
							self.text('Xóa');
							result = $.trim(result);
							if(result === 'OK'){
								alert('Xóa thương hiệu thành công');
								//window.location.reload(true);
								$('#row_'+idBr).hide();
							} else {
								alert('Xóa thương hiệu thất bại');
							}
							return false; 
						}
					});
				}
			});
					 $('#btnSearch').click(function() {
        let keyword = $.trim($('#keyword').val());
        if(keyword.length > 0){
          window.location.href = "{{ route('admin.brand') }}" + "?q="+keyword;
				}
			});
		})
	</script>
@endpush