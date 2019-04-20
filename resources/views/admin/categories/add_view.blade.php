@extends('admin.base')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center">Thêm danh mục</h3>
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
@if($message != '')
<div class="alert alert-danger">
	<h3>{{ $message }}</h3>
</div>
@endif
<form action="{{ route('admin.handleAddCat') }}" method="POST">
	@csrf
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="nameCat">Tên danh mục:</label>
				<input type="text" class="form-control" name="nameCat" id="nameCat">
			</div>
			<div class="form-group border-top">
				<p>Danh mục cha:</p>
				<label for="dmg">Danh mục gốc</label>
				<input type="radio" name="cat_parent" value="0" id="dmg">
				@foreach($cat as $key => $item)
					<label for="cat_{{ $item['id'] }}" class="border-left ml-3">{{ $item['name'] }}: </label>
					<input type="radio" name="cat_parent" id="cat_{{ $item['id'] }}" value="{{ $item['id'] }}" multiple>
				@endforeach
			</div>
		<div class="col-md-6 offset-md-3 mt-3 mb-3">
			<button type="submit" class="btn btn-primary btn-block"> Thêm </button>
		</div>
	</div>

</form>
@endsection