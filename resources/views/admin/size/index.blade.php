@extends('admin.base')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center">Kích cỡ !</h3>
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
		<a href="{{ route('admin.addSize') }}" class="btn btn-primary"> Thêm kích cỡ + </a>
		<a href="{{ route('admin.size') }}" class="btn btn-primary">Tất cả kích cỡ</a>
	</div>
</div>
<div class="row mt-3">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th>Mã kích cỡ</th>
					<th>Tên kích cỡ</th>
					<th>Số kích cỡ</th>
					<th>Trạng thái</th>
					<th>Mô tả</th>
					<th colspan="2" width="3%" class="text-center">Chức năng</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sizes as $key => $item)
				<tr id="row_{{ $item['id'] }}">
					<td>{{ $item['id'] }}</td>
					<td>{{ $item['letter_size'] }}</td>
					<td>{{ $item['number_size'] }}</td>
					<td>{{ $item['status']==0 ? 'Ngung su dung' : 'Dang su dung' }}</td>
					<td>{{ $item['description'] }}</td>
					
					<td>
						<a href="{{ route('admin.editSize',['id'=> $item['id']]) }}" class="btn btn-info">Sửa</a>
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
				let idSz = self.attr('id');
				if($.isNumeric(idSz)){
					$.ajax({
						url: "{{ route('admin.deleteSize') }}",
						type: "POST",
						data: {id: idSz},
						beforeSend: function(){
							self.text('Loading ...');
						},
						success: function(result){
							self.text('Xóa');
							result = $.trim(result);
							if(result === 'OK'){
								alert('Xóa kích cỡ thành công');
								//window.location.reload(true);
								$('#row_'+idSz).hide();
							} else {
								alert('Xóa không thành công');
							}
							return false; 
						}
					});
				}
			});
					 $('#btnSearch').click(function() {
        let keyword = $.trim($('#keyword').val());
        if(keyword.length > 0){
          window.location.href = "{{ route('admin.size') }}" + "?q="+keyword;
				}
			});
		})
	</script>
@endpush