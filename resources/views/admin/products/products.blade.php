@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Products <a class="btn btn-primary" href="{{route('new-product')}}"><i class="fas fa-plus-circle"></i></a></div>

                <div class="card-body">
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-4">
                                <div class="alert alert-primary" role="alert">
                                    <h5>{{$product->title}}</h5>
                                    <p>Category:{{(is_object($product->category)) ? $product->category->name:''}}</p>
                                    <p>Price: {{$currency_code}}{{$product->price}}</p>
                                    {!!  (count($product->images) >0)? '<img class="img-thumbnail card-img" src="'.$product->images[0]->url.'">': '' !!}
                                    @if(! is_null($product->options))
                                           <table class="table-bordered table">
                                               @foreach($product->jsonOptions() as $optionsKey=> $options )
                                                   @foreach($options as $option)
                                                       <tr>
                                                           <td>{{$optionsKey}}</td>
                                                           <td>{{$option}}</td>
                                                       </tr>
                                                   @endforeach
                                               @endforeach
                                           </table>
                                        @endif

                                    <a class="btn btn-success mt-2" href="{{route('update-product' , ['id'=>$product->id])}}"> Update Product</a>
                                </div>

                            </div>
                        @endforeach
                    </div>


                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>
    @endsection

@if (Session::has('message'))
    <div class="toast" style="position: absolute;z-index:99999;top:5%;right: 5%;" role="alert" aria-live="assertive"
         aria-atomic="true">
        <div class="toast-header">
            <strong class="mr-auto">Products</strong>
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="toast-body">

            {{Session::get('message')}}
        </div>
    </div>
@endif


@section('scripts')


    @if(Session::has('message'))
        <script>
            $(document).ready(function () {
                var $toast = $('.toast').toast({
                    autohide: false
                });

                $toast.toast('show');


            });


        </script>
    @endif
@endsection



