@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {!! !is_null($product) ? 'Update Product <span class="product-header-title">'.$product->title :' New Product' !!}
                </div>

                <div class="card-body">
                    <form action="{{route('new-product')}}" method="post" class="row">
                        @csrf
                        @if(! is_null($product)  )
                            <input type="hidden" name="_method" value="PUT"/>
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                        @endif

                        <div class="form-group col-md-12 ">
                            <label for="product_title">Product Title</label>
                            <input type="text" class="form-control" id="product_title" name="product_title"
                                   placeholder="Product title" required
                                   value="{{(!is_null($product)) ? $product->title : '' }}">
                        </div>


                        <div class="form-group col-md-12 ">
                            <label for="product_description">Product Description</label>
                            <textarea required class="form-control" name="product_unit" id="product_unit" cols="30"
                                      rows="10">
                                {{(! is_null($product))? $product->description :''}}
                            </textarea>
                        </div>
                        <div class="form-group col-md-12 ">
                            <label for="product_category">Product Category</label>
                            <select class="form-control" name="product_category" id="product_category" required>
                                <option value="">Select Category</option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{$category->id}}" {{(! is_null($product) && $product->category->id===$category->id ) ? 'selected' :''}}>{{$category->name}}
                                    </option>

                                @endforeach


                            </select>
                        </div>

                        <div class="form-group col-md-12 ">
                            <label for="product_unit">Product Unit</label>
                            <select class="form-control" name="product_unit" id="product_unit" required>
                                <option>Select Unit</option>


                                @foreach($units as $unit)

                                    <option value="{{$unit->id}}"
                                        {{(! is_null($product) && $product->hasUnit->id===$unit->id ) ? 'selected' :''}}>{{$unit->formatted()}}
                                    </option>

                                @endforeach


                            </select>
                        </div>
                        <div class="form-group col-md-6 ">
                            <label for="product_price">Product Price</label>
                            <input type="number" class="form-control" id="product_price" name="product_price"
                                   placeholder="Product price" required
                                   value="{{(!is_null($product)) ? $product->price : '' }}">
                        </div>

                        <div class="form-group col-md-6 ">
                            <label for="product_discount">Product Discount</label>
                            <input type="number" class="form-control" id="product_discount" name="product_discount"
                                   placeholder="Product Discount" required
                                   value="{{(!is_null($product)) ? $product->discount : '' }}">
                        </div>
                        <div class="form-group col-md-12 ">
                            <label for="product_total">Product Total</label>
                            <input type="number" class="form-control" id="product_total" name="product_total"
                                   placeholder="Product total" required
                                   value="{{(!is_null($product)) ? $product->total : '' }}">
                        </div>


                        {{--                        Options--}}

                        <div class="form-group col-md-12 ">
                            <a class="btn btn-info add-option-btn" href="#">
                                Add Options
                            </a>

                        </div>

                        {{--                        /options--}}
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal options-window" tabindex="-1" role="dialog" id="options-window">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Option</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body row" >

                    <div class="form-group col-md-6 ">
                        <label for="option_name">Option Name</label>
                        <input type="text" class="form-control" id="option_name" name="option_name"
                               placeholder="option Name" required>
                    </div>
                    <div class="form-group col-md-6 ">
                        <label for="option_value">Option</label>
                        <input type="text" class="form-control" id="option_value" name="option_value"
                               placeholder="Option value" required>
                    </div>

                    <input type="hidden" name="unit_id" id="edit_unit_id">
                    <input type="hidden" name="_method" value="put"/>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary">ADD OPTION</button>
                </div>

            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script>
        $(document).ready(function () {
            var $optionWindow=$('#options-window');
            var addOptionBtn=$('.add-option-btn');

            addOptionBtn.on('click' ,function (e) {
                e.preventDefault();
                $optionWindow.modal('show');
            })

        })
    </script>


@endsection
