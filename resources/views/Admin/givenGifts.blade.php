@extends('voyager::master')

@section('page_title', __('voyager::generic.view').'Given Gifts')

<!-- PAGE HEADER -->
@section('page_header')

    <h1 class="page-title">
        <i class="voyager-trophy"></i> {{ ucfirst('View Given Gifts') }} &nbsp;
      

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
                Given Gifts Details
                </h3>

                <br>
                <div class="card" style="margin: 0px 10px;">

                    <table id="table-add-opt" class="table datatable-basic table-striped" style=" margin: 0;">

                        <thead>

                            <tr>
                                <th >Image</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Description</th> 
                            </tr>

                        </thead>

                        <tbody>
                        @foreach($giftNameInxs  as $gift)
                            <tr>
                                <td>
                                    <img width="50px" src="{{ Voyager::image( $gift->image ) }}" class="text-center" />
                                </td>
                                <td class="text-center">{{ $gift->name }}</td>
                                <td class="text-center">{{ $gift->description }}</td>
                             
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
