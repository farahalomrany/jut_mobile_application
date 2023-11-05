@extends('voyager::master')

@section('page_title', __('voyager::generic.view').'My Messages')

<!-- PAGE HEADER -->
@section('page_header')

    <h1 class="page-title">
        <i class="voyager-trophy"></i> {{ ucfirst('View Messages') }} &nbsp;
       

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
                Messages Details
                </h3>

                <br>
                <div class="card" style="margin: 0px 10px;">

                    <table id="table-add-opt" class="table datatable-basic table-striped" style=" margin: 0;">

                        <thead>

                            <tr>
                               
                                <th class="text-center">Date</th>
                                <th class="text-center">Destination</th>
                                <th class="text-center">Receivers</th>
                                <th class="text-center">Text</th>
                                <th class="text-center">Admin</th>
                                <th class="text-center"></th>
                         
                                
                            </tr>

                        </thead>

                        <tbody>
                        @foreach($messages  as $message)
                            <tr>
                                
                                <td class="text-center">{{ $message->date }}</td>
                                <td class="text-center">{{ $message->destination }}</td>
                                <td class="text-center">{{ $message->receivers }}</td>
                                <td class="text-center">{{ $message->text }}</td>
                                <td class="text-center">{{ $message->admin_id  }}</td>

                                 <td class="no-sort no-click bread-actions">
                                    <a href="{{route('view-message',$message->id)}}" title="View" class="btn btn-sm btn-warning pull-right view">
                                        <i class="voyager-eye"></i>
                                        <span class="hidden-xs hidden-sm">View </span>
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
    <script type="text/javascript">

    </script>
@endsection
