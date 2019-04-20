@extends('frontend.base-layout')

@section('content')
<div class="card">
	<div class="row">
		<aside class="col-sm-5 border-right">
			<article class="gallery-wrap"> 
			<div class="img-big-wrap">
			  <div>
			  	<a href="#">
			  		<img src="{{ URL::to('/') }}/upload/images/{{ $image[0] }}" style="width: 340px;">
			  </a>
			</div>
			</div>
			<br><br> <!-- slider-product.// -->
			<div class="img-small-wrap">
				@foreach($image as $key => $item)
			  	<div class="item-gallery">
			  		<img src="{{ URL::to('/') }}/upload/images/{{ $item }}" style="width: 65px; height:65px; ">
			  	</div>
			  	@endforeach
			</div> <!-- slider-nav.// -->
			</article> <!-- gallery-wrap .end// -->
					</aside>
					<aside class="col-sm-7">
			<article class="card-body p-5">
				<h3 class="title mb-3">{{ $info['name_product'] }}</h3>

			<p class="price-detail-wrap"> 
				<span class="price h3 text-warning"> 
					<span class="num">{{ number_format($info['price']) }}</span><span class="currency"> VND</span>
				</span> 
			</p> <!-- price-detail-wrap .// -->
			<dl class="item-property">
			  <dt>@lang('common.description')</dt>
			  <dd><p>{{ $info['description'] }}</p></dd>
			</dl>
			{{-- <dl class="param param-feature">
			  <dt>@lang('common.brand')</dt>
			  <dd>12345611</dd>
			</dl> --}}  <!-- item-property-hor .// -->
			<dl class="param param-feature">
			  <dt>@lang('common.color')</dt>
			  <div class="col-sm-7">
				<dl class="param param-inline">
					  <dd>
					  	@foreach($color as $key => $item)
					  	<label class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="inlineRadioOptionsColor" id="color_{{ $item['id'] }}" value="{{ $item['id'] }}">
						  <span class="form-check-label">{{ $item['name_color'] }}</span>
						</label>
						@endforeach
					  </dd>
				</dl>  <!-- item-property .// -->
			</div>
			</dl>  <!-- item-property-hor .// -->
			{{-- <dl class="param param-feature">
			  <dt>Delivery</dt>
			  <dd>Russia, USA, and Europe</dd>
			</dl> --}}  <!-- item-property-hor .// -->

			<hr>
				<div class="row">
					<div class="col-sm-5">
						<dl class="param param-inline">
						  <dt>@lang('common.quantity'): </dt>
						  <dd>
						  	<select class="form-control form-control-sm" style="width:70px;" id="qtyPd">
						  		<option> 1 </option>
						  		<option> 2 </option>
						  		<option> 3 </option>
						  		<option> 4 </option>
						  		<option> 5 </option>
						  		<option> 6 </option>
						  	</select>
						  </dd>
						</dl>  <!-- item-property .// -->
					</div> <!-- col.// -->
					<div class="col-sm-7">
						<dl class="param param-inline">
							  <dt>@lang('common.size'): </dt>
							  <dd>
							  	@foreach($size as $key => $item)
							  	<label class="form-check form-check-inline">
								  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="size_{{ $item['id'] }}" value="{{ $item['id'] }}">
								  <span class="form-check-label">{{ $item['letter_size'] }}</span>
								</label>
								@endforeach
							  </dd>
						</dl>  <!-- item-property .// -->
					</div> <!-- col.// -->
				</div> <!-- row.// -->
				<hr>
				<br>
				<a href="{{ route('fr.product') }}" class="btn btn-lg btn-primary text-uppercase">@lang('common.shopping')</a>
				<button id="addCart" class="btn btn-lg btn-outline-primary text-uppercase" style="margin-left: 50px;">
					<i class="fas fa-shopping-cart"></i> 
					@lang('common.add_to_cart')
				</button>
				<br><br>
				
			</article> <!-- card-body.// -->
		</aside> <!-- col.// -->
	</div> <!-- row.// -->
</div>
<br><br> <!-- card.// -->
@endsection

@push('js')
	<script type="text/javascript">
		$(function() {
			$('#addCart').click(function() {
				let self = $(this);
				let idPd = "{{ $info['id'] }}";
				let qty = $.trim($('#qtyPd').val());

				let textColor = $('input[name="inlineRadioOptionsColor"]:checked').next().text().trim();
				let textSize = $('input[name="inlineRadioOptions"]:checked').next().text().trim();
				// alert(textColor);
				if ($.isNumeric(idPd)) {
					$.ajax({
						url: "{{ route('fr.addCart') }}",
						type: "POST",
						data: {id : idPd, qty : qty, color : textColor, size : textSize},
						beforeSend: function() {
							self.text('Loading...');
						},
						success: function(result) {
							self.text('Thêm vào giỏ');
							result = $.trim(result);
							if (result === 'OK') {
								alert('Thêm vào giỏ hàng thành công');
							}
							else {
								alert('Vui lòng chọn đầy đủ thông tin của sản phẩm');
							}
						}
					});
				}
			});
		});
	</script>
@endpush
