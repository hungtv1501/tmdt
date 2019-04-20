@extends('admin.base')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center">Thêm Sản Phẩm</h3>
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
<form action="{{ route('admin.handleAddProduct') }}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="nameProduct">Tên sản phẩm:</label>
				<input type="text" class="form-control" name="nameProduct" id="nameProduct">
			</div>
			<div class="form-group border-top">
				<p>Danh mục:</p>
				@foreach($cat as $key => $item)
					<label for="cat_{{ $item['id'] }}">{{ $item['name'] }}</label>
					<input type="checkbox" name="categories[]" id="cat_{{ $item['id'] }}" value="{{ $item['id'] }}" multiple="multiple">
				@endforeach
			</div>
			<div class="form-group border-top">
				<p>Màu:</p>
				@foreach($color as $key => $item)
					<label for="color_{{ $item['id'] }}">{{ $item['name_color'] }}</label>
					<input type="checkbox" name="color[]" id="color_{{ $item['id'] }}" value="{{ $item['id'] }}" multiple="multiple">
				@endforeach
			</div>
			<div class="form-group border-top">
				<p>Kích cỡ:</p>
				@foreach($size as $key => $item)
					<label for="size_{{ $item['id'] }}">{{ $item['letter_size'] }}</label>
					<input type="checkbox" name="size[]" id="size_{{ $item['id'] }}" value="{{ $item['id'] }}" multiple="multiple">
				@endforeach
			</div>
			<div class="form-group border-top">
				<label for="brand">Thương hiệu</label>
				<select name="brand" class="form-control">
					@foreach($brand as $key => $item)
						<option value="{{ $item['id'] }}">{{ $item['brand_name'] }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="price">Giá: </label>
				<input type="number" name="price" id="price" class="form-control">
			</div>
			<div class="form-group border-top">
				<label for="qty">Số lượng: </label>
				<input type="number" name="qty" id="qty" class="form-control">
			</div>
			<div class="form-group border-top">
				<label for="image">Hình ảnh: </label>
				<input type="file" name="image[]" id="image" class="form-control" multiple="multiple">
			</div>
			<div class="form-group border-top">
				<label for="sale">Giảm giá: </label>
				<input type="text" name="sale" id="sale" class="form-control">
			</div>
			<div class="form-group border-top">
				<label for="des">Mô tả: </label>
				<textarea class="form-control" id="des" name="des" rows="5"></textarea>
			</div>
		</div>
		<div class="col-md-6 offset-md-3 mt-3 mb-3">
			<button type="submit" class="btn btn-primary btn-block"> Thêm </button>
		</div>
	</div>

</form>
@endsection