@extends('admin.base')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center">Update Product</h3>
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
@if($mes != '')
<div class="alert alert-danger">
	<h3>{{ $mes }}</h3>
</div>
@endif
<form action="{{ route('admin.handleEditProduct',['id' => $info['id']]) }}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="nameProduct">Name Product:</label>
				<input type="text" class="form-control" name="nameProduct" id="nameProduct" value="{{ $info['name_product'] }}">
			</div>
			<div class="form-group border-top">
				<p>Categories:</p>
				@foreach($cat as $key => $item)
					<label for="cat_{{ $item['id'] }}">{{ $item['name'] }}</label>
					<input 
						type="checkbox" 
						name="categories[]" 
						id="cat_{{ $item['id'] }}" 
						value="{{ $item['id'] }}" 
						multiple 
						{{ in_array($item['id'],$infoCat) ? 'checked' : '' }}
					>
				@endforeach
			</div>
			<div class="form-group border-top">
				<p>Colors:</p>
				@foreach($color as $key => $item)
					<label for="color_{{ $item['id'] }}">{{ $item['name_color'] }}</label>
					<input type="checkbox" name="color[]" id="color_{{ $item['id'] }}" value="{{ $item['id'] }}" multiple {{ in_array($item['id'], $infoColor) ? 'checked' : '' }}>
				@endforeach
			</div>
			<div class="form-group border-top">
				<p>Sizes:</p>
				@foreach($size as $key => $item)
					<label for="size_{{ $item['id'] }}">{{ $item['letter_size'] }}</label>
					<input type="checkbox" name="size[]" id="size_{{ $item['id'] }}" value="{{ $item['id'] }}" multiple {{ in_array($item['id'], $infoSize) ? 'checked' : '' }}>
				@endforeach
			</div>
			<div class="form-group border-top">
				<label for="brand">Brands</label>
				<select name="brand" class="form-control">
					@foreach($brand as $key => $item)
						<option 
						value="{{ $item['id'] }}"
						{{ $item['id'] == $info['brands_id'] ? 'selected' : '' }}
					>
						{{ $item['brand_name'] }}
					</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="price">Price: </label>
				<input type="number" name="price" id="price" class="form-control" value="{{ $info['price'] }}">
			</div>
			<div class="form-group border-top">
				<label for="qty">Qty: </label>
				<input type="number" name="qty" id="qty" class="form-control" value="{{ $info['qty'] }}">
			</div>
			<div class="form-group border-top">
				@foreach($infoImages as $key => $item)
					<img src="{{ URL::to('/') }}/upload/images/{{ $item }}" width="100" class="img ml-5">
				@endforeach
			</div>
			<div class="form-group border-top">
				<label for="image">Image: </label>
				<input type="file" name="image[]" id="image" class="form-control" multiple>
			</div>
			<div class="form-group border-top">
				<label for="sale">Sale off: </label>
				<input type="text" name="sale" id="sale" class="form-control" value="{{ $info['sale_off'] }}">
			</div>
			<div class="form-group border-top">
				<label for="des">Description: </label>
				<textarea class="form-control" id="des" name="des" rows="5">{!! $info['description'] !!}</textarea>
			</div>
		</div>
		<div class="col-md-6 offset-md-3 mt-3 mb-3">
			<button type="submit" class="btn btn-primary btn-block"> UPDATE </button>
		</div>
	</div>

</form>
@endsection