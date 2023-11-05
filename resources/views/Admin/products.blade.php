@extends('voyager::master')

@section('page_title', __('voyager::generic.view').'Products')

<!-- PAGE HEADER -->
@section('page_header')

    <h1 class="page-title">
        <i class="voyager-trophy"></i> {{ ucfirst('View Products') }} &nbsp;
        <a href="{{ route('voyager.'.'campaigns'.'.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            {{ __('voyager::generic.return_to_list') }}
        </a>

    </h1>

    @include('voyager::multilingual.language-selector')

@endsection
<!-- PAGE HEADER -->

<!-- PAGE CONTENT -->
@section('content')
    <div class="page-content read container-fluid">

        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-0 font-weight-semibold">
                Products Details
                </h3>

                <br>
                <div class="card" style="margin: 0px 10px;">

                    <table id="table-add-opt" class="table datatable-basic table-striped" style=" margin: 0;">

                        <thead>

                            <tr>
                                <th >Image</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">category</th>
                                <th class="text-center">Size and Price</th>
                                <th class="text-center">Brochure</th>
                                <th class="text-center">Is New</th>
                                <th class="text-center">Is Super</th>
                                <th class="text-center">Points</th>
                                
                            </tr>

                        </thead>

                        <tbody>
                        @foreach($products  as $product)
                            <tr>
                                <td>
                                    <img width="50px" src="{{ Voyager::image( $product->image ) }}" class="text-center" />
                                </td>
                                <td class="text-center">{{ $product->name }}</td>
                                <td class="text-center">{{ $product->category_id }}</td>
                                <td class="text-center">{{ $product->size_price }}</td>
                                <td class="text-center">{{ $product->brochure }}</td>
                                <td class="text-center">{{ $product->is_new }}</td>
                                <td class="text-center">{{ $product->is_super }}</td>
                                <td class="text-center">{{ $points }}</td>
                                <!-- <td class="text-center"></td> -->
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <style>
    .breadcrumb {
        display: none;
    }

    </style>
    {{-- Single delete_modal  --}}
    <!-- /.modal -->
@endsection
<!-- PAGE CONTENT -->

@section('javascript')
    <script type="text/javascript">

    </script>
@endsection
