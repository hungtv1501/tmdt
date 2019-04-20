
@extends('admin.base')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center"> Thêm size !</h3>
	</div>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif 

<form action="{{ route('admin.handleAddSize') }}" method="POST">
	@csrf
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="letterSize"> Tên size : </label>
				<input type="text" class="form-control" name="letterSize" id="letterSize">
			</div>
			<div class="form-group">
				<label for="numberSize"> Số size  : </label>
				<input type="text" class="form-control" name="numberSize" id="numberSize">
			</div>
			<div class="form-group border-top mt-3">
				<label for="description">Mô tả  :</label>
				<textarea class="form-control" name="description" id="description" rows="5"></textarea>
			</div>
		</div>
		<div class="col-md-6 offset-md-3 mt-3 mb-3">
			<button type="submit" class="btn btn-primary btn-block"> ADD + </button>
		</div>
	</div>
</form>
@endsection