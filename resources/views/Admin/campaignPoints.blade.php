@extends('voyager::master')

@section('page_title', __('voyager::generic.view').'Campaigns')

<!-- PAGE HEADER -->
@section('page_header')

    <h1 class="page-title">
        <i class="voyager-trophy"></i> {{ ucfirst('View Campaigns') }} &nbsp;
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
                All Campaigns
                </h3>

                <br>
                <div class="card" style="margin: 0px 10px;">

                    <table id="table-add-opt" class="table datatable-basic table-striped" style=" margin: 0;">

                        <thead>

                            <tr>
                                <th class="text-center">Start Date</th>
                                <th class="text-center">End Date</th>
                                <th class="text-center"></th>
                            </tr>

                        </thead>

                        <tbody>
                        @foreach($campaigns  as $campaign)
                            <tr>
                                <td class="text-center">{{ $campaign->start_date }}</td>
                                <td class="text-center">{{ $campaign->end_date }}</td>

                                <td class="no-sort no-click bread-actions">
                                    <a href="{{url('admin/members-with-points',$campaign->id)}}" title="View" class="btn btn-sm btn-warning pull-right view">
                                        <i class="voyager-eye"></i>
                                        <span class="hidden-xs hidden-sm">Points</span>
                                    </a>
                                </td>
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

    
@endsection
