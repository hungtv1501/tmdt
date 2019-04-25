@extends('admin.base')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center"> Cập nhật kích cỡ !</h3>
	</div>
</div>



{{-- <div class="alert alert-danger">
	<h3>{{ $mess }}</h3>
</div> --}}

<form action="{{ route('admin.handleEditSize',['id' => $infor['id']]) }}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="letterSize"> Tên màu: </label>
				<input type="text" class="form-control" name="letterSize" id="letterSize" value="{{ $infor['letter_size'] }}">
			</div>
			<div class="form-group">
				<label for="numberSize"> Số màu: </label>
				<input type="text" class="form-control" name="numberSize" id="numberSize" value="{{ $infor['number_size'] }}">
			</div>
			
			<div class="form-group border-top">
				<label for="status"> Trạng thái </label>	
				<select name="status" class="form-control">
					
						<option
							value="0"
							{{ ($infor['status']==0)? 'selected' : '' }}
						>
							Ngừng sử dụng
						</option>
						<option value="1"
						{{ ($infor['status']==1)? 'selected' : '' }}
						>
							Đang sử dụng
						</option>
					
				</select>
			</div>
		</div>	
			<div class="form-group col-md-12">
				<label for="description">Mô tả</label>
				<textarea class="form-control" name="description" id="description" rows="5">
					{{  $infor['description']   }}
				</textarea>
			</div>

		</div>
		<div class="col-md-6 offset-md-3 mt-3 mb-3">
			<button type="submit" class="btn btn-primary btn-block"> Cập nhật </button>
		</div>
	</div>
</form>
@endsection