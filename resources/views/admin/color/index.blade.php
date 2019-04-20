@extends('admin.base')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center">Color !</h3>
		<h3 class="text-center"></h3>
	</div>
</div>
 <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-1 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" id="keyword">
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
		<a href="{{ route('admin.addColor') }}" class="btn btn-primary"> Add color + </a>
		<a href="{{ route('admin.color') }}" class="btn btn-primary">View all</a>
	</div>
</div>
<div class="row mt-3">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th>Ma mau</th>
					<th>Ten mau</th>
					<th>Trang thai</th>
					<th>Mo ta</th>
					<th colspan="2" width="3%" class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($colors as $key => $item)
				<tr id="row_{{ $item['id'] }}">
					<td>{{ $item['id'] }}</td>
					<td>{{ $item['name_color'] }}</td>
					<td>{{ $item['status']==0 ? 'Ngung su dung' : 'Dang su dung' }}</td>
					<td>{{ $item['description'] }}</td>
					
					<td>
						<a href="{{ route('admin.editColor',['id'=> $item['id']]) }}" class="btn btn-info">Edit</a>
					</td>
					<td>
						<button class="btn btn-danger btnDelete" id="{{ $item['id'] }}">Delete</button>
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
				let idCl = self.attr('id');
				if($.isNumeric(idCl)){
					$.ajax({
						url: "{{ route('admin.deleteColor') }}",
						type: "POST",
						data: {id: idCl},
						beforeSend: function(){
							self.text('Loading ...');
						},
						success: function(result){
							self.text('Delete');
							result = $.trim(result);
							if(result === 'OK'){
								alert('Delete successful');
								//window.location.reload(true);
								$('#row_'+idCl).hide();
							} else {
								alert('Delete fail');
							}
							return false; 
						}
					});
				}
			});
		$('#btnSearch').click(function() {
        let keyword = $.trim($('#keyword').val());
        if(keyword.length > 0){
          window.location.href = "{{ route('admin.color') }}" + "?q="+keyword;
        }
      });
		})
	</script>
@endpush