@extends('admin.base')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center">Danh mục</h3>
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
{{-- @if($message != '')
<div class="alert alert-danger">
	<h3>{{ $message }}</h3>
</div>
@endif --}}
@if($message != '')
<div class="alert alert-danger">
	<h3>{{ $message }}</h3>
</div>
@endif
<div class="row">
	<div class="col-md-12">
		<a href="{{ route('admin.addCat') }}" class="btn btn-primary">Thêm Danh Mục</a>
		<a href="{{ route('admin.categories') }}" class="btn btn-primary">Tất cả Danh Mục</a>
	</div>
</div>
<div class="row mt-3">
	<div class="col-md-12">
		<table class="table text-center">
			<thead>
				<tr>
					<th>Mã Danh Mục</th>
					<th>Tên Danh Mục</th>
					<th>Danh Mục Cha</th>
					<th>Trạng Thái</th>
					<th colspan="2">Chức năng</th>
				</tr>
			</thead>
			<tbody>
				@foreach($cat as $key => $item)
				<tr id="row_{{ $item['id'] }}">
					<td>{{ $item['id'] }}</td>
					<td>{{ $item['name'] }}</td>
					<td>{{ $item['parent_id'] }}</td>
					<td>{{ ($item['status'] === 1) ? 'Đang sử dụng' : 'Ngưng sử dụng' }}</td>
					<td>
						<a href="{{ route('admin.editCat',['id' => $item['id']]) }}" class="btn btn-info">Sửa</a>
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
				let idCat = self.attr('id');
				if ($.isNumeric(idCat)) {
					$.ajax({
						url:"{{ route("admin.deleteCat") }}",
						type:"POST",
						data:{id:idCat},
						beforeSend: function() {
							self.text("Loading ...");
						},
						success: function(result) {
							// alert(result);
							self.text("Xóa");
							result = $.trim(result);
							if (result === "OK") {
								alert("Xóa danh mục thành công");
								// window.location.reload(true);
								$("#row_"+idCat).hide();
							}
							else if(result === "FAIL") {
								alert("Xóa không thành công");
							}
							else {
								alert("Tồn tại danh mục con. Vui lòng xóa danh mục con trước!");
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
          			window.location.href = "{{ route('admin.categories') }}" + "?q=" + keyword;
        		}
      		});
		});
	</script>
@endpush