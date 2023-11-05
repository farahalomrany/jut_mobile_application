@extends('voyager::master')

@section('page_title', __('voyager::generic.view').'Gifts')

<!-- PAGE HEADER -->
@section('page_header')

    <h1 class="page-title">
        <i class="voyager-trophy"></i> {{ ucfirst('View Gifts') }} &nbsp;
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
                Gifts Details
                </h3>

                <br>
                <div class="card" style="margin: 0px 10px;">

                    <table id="table-add-opt" class="table datatable-basic table-striped" style=" margin: 0;">

                        <thead>

                            <tr>
                            
                               
                                <th class="text-center">Name</th>
                                <th class="text-center">Points</th>
                          
                            </tr>

                        </thead>

                        <tbody>
                            
                        @foreach(json_decode($giftsNames, true) as $key => $value)
                           <?php
                               $gift_id = $value['id'];
                              
                               if(App\Models\GiftNameInx::where('id',$gift_id)->first()){
                                    $gift= App\Models\GiftNameInx::where('id',$gift_id)->first();
                                    $point = $value['points'];
                                
                                }
                           ?>
                           
                            <tr>
                               
                                <td class="text-center">{{ $gift->name }}</td>
                                <td class="text-center">{{ $point }}</td>
                          
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
