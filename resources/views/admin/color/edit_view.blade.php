@extends('admin.base')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center"> Thêm màu sắc !</h3>
	</div>
</div>



{{-- <div class="alert alert-danger">
	<h3>{{ $mess }}</h3>
</div> --}}

<form action="{{ route('admin.handleEditColor',['id' => $infor['id']]) }}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="nameColor"> Tên màu : </label>
				<input type="text" class="form-control" name="nameColor" id="nameColor" value="{{ $infor['name_color'] }}">
			</div>
			
			
			<div class="form-group border-top">
				<label for="status"> Trạng thái : </label>	
				<select name="status" class="form-control">
					
						<option
							value="0"
							{{ ($infor['status']==0)? 'selected' : '' }}
						>
							Ngưng sử dụng
						</option>
						<option value="1"
						{{ ($infor['status']==1)? 'selected' : '' }}
						>
							Đang sử dụng
						</option>
					
				</select>
			</div>
			<div class="form-group border-top ">
				<label for="description">Mô tả</label>
				<textarea class="form-control" name="description" id="description" rows="5">
					{{  $infor['description']   }}
				</textarea>
			</div>
		</div>	
			

		</div>
		<div class="col-md-6 offset-md-3 mt-3 mb-3">
			<button type="submit" class="btn btn-primary btn-block"> Cập nhật </button>
		</div>
	</div>
</form>
@endsection