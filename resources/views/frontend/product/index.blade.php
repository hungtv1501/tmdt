@extends('frontend.base-layout')

@section('content')
  <div class="col-lg-12 col-md-12 mt-3 mb-5">
    <h2 class="text-center">Danh sách sản phẩm</h2>
  </div>
 <div class="row">
  @foreach($listPd as $key => $item)
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card h-99">
        <a href="{{ route('fr.detailPd',['id' => $item['id']]) }}"><img class="card-img-top" src="{{ URL::to('/') }}/upload/images/{{ $item['image_product'][0] }}" height="250" alt=""></a>
        <div class="card-body">
          <h4 class="card-title">
            <a href="{{ route('fr.detailPd',['id' => $item['id']]) }}">{{ $item['name_product'] }}</a>
          </h4>
          <h5>{{ number_format($item['price']) }}</h5>
          <p class="card-text">{{ $item['description'] }}</p>
        </div>
       {{--  <div class="card-footer">
          <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
        </div> --}}
      </div>
    </div>
  @endforeach
  </div>
  <div class="row" style="margin-left: 300px;">
    <div class="col-md-12">
      {{ $link->appends(request()->query())->links() }}
    </div>
  </div>
@endsection