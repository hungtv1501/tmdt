@extends('admin.base')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center"> Update Brand !</h3>
	</div>
</div>



{{-- <div class="alert alert-danger">
	<h3>{{ $mess }}</h3>
</div> --}}

<form action="{{ route('admin.handleEditBrand',['id' => $infor['id']]) }}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="nameBrand"> Ten : </label>
				<input type="text" class="form-control" name="nameBrand" id="nameBrand" value="{{ $infor['brand_name'] }}">
			</div>
			<div class="form-group">
				<label for="address"> Dia chi : </label>
				<input type="text" class="form-control" name="address" id="address" value="{{ $infor['address'] }}">
			</div>
			
			<div class="form-group border-top">
				<label for="status"> Trang thai </label>	
				<select name="status" class="form-control">
					
						<option
							value="0"
							{{ ($infor['status']==0)? 'selected' : '' }}
						>
							Ngung su dung
						</option>
						<option value="1"
						{{ ($infor['status']==1)? 'selected' : '' }}
						>
							Dang su dung
						</option>
					
				</select>
			</div>
		</div>	
			<div class="form-group border-top ">
				<label for="description">Description</label>
				<textarea class="form-control" name="description" id="description" rows="5">
					{{  $infor['description']   }}
				</textarea>
			</div>

		</div>
		<div class="col-md-6 offset-md-3 mt-3 mb-3">
			<button type="submit" class="btn btn-primary btn-block"> UPDATE </button>
		</div>
	</div>
</form>
@endsection