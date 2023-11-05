@extends('voyager::master')

@section('page_title', __('voyager::generic.view').'Members with points')



<!-- PAGE HEADER -->
@section('page_header')

    <h1 class="page-title">
        <i class="voyager-trophy"></i> {{ ucfirst('View Members') }} &nbsp;
        <!-- <a href="{{ route('voyager.'.'campaigns'.'.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            {{ __('voyager::generic.return_to_list') }}
        </a> -->
   
    </h1>

    @include('voyager::multilingual.language-selector')

@endsection
<!-- PAGE HEADER -->

<!-- PAGE CONTENT -->
@section('content')

    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
            <div class="form-group">
                <a class="btn btn-info" href="{{ url('/admin/exportPdf',$campaign_id) }}">PDF</a>
                <a class="btn btn-info" href="{{ url('/admin/export',$campaign_id) }}">Excel</a>
            </div> 
         
                <h3 class="mb-0 font-weight-semibold">
                All Members
                </h3>

                <br>
                <div class="card" style="margin: 0px 10px;">

                    <table id="table-add-opt" class="table datatable-basic table-striped" style=" margin: 0;">

                        <thead>
                            <tr>
                                <th class="text-center">Member Name</th>
                                <th class="text-center">Member Classification</th>
                                <th class="text-center">Points</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($members  as $member)
                            <tr>
                                <td class="text-center">@if($member->user){{ $member->user->fstName }}@endif</td>
                                <td class="text-center">{{ $member->classification }}</td>
                                <td class="text-center">{{ $member->count_points_for_member_in_campaign($campaign_id, $member->id) }}</td>
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" />

    <script type="text/javascript">

        $(document).ready(function() {
            $('#export_example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            } );
        } );

    </script>
@endsection
