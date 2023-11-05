@extends('voyager::master')

@section('page_title', __('voyager::generic.view').'Claims')

<!-- PAGE HEADER -->
@section('page_header')

    <h1 class="page-title">
        <i class="voyager-trophy"></i> {{ ucfirst('View Claims') }} &nbsp;
        <!-- <a href="{{ route('voyager.'.'claims'.'.index') }}" class="btn btn-warning">
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
                <h3 class="mb-0 font-weight-semibold">
                Claims Details
                </h3>

                <br>
                <div class="card" style="margin: 0px 10px;">

                    <table id="table-add-opt" class="table datatable-basic table-striped" style=" margin: 0;">

                        <thead>

                            <tr>
                               
                                <th class="text-center">Campaign</th>
                                <th class="text-center">Member</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                             
                                
                            </tr>

                        </thead>

                        <tbody>
                        @foreach($claims  as $claim)
                            <tr>
                              
                                <td class="text-center">{{ $claim->campaign->start_date  }}</td>
                                <td class="text-center">{{ $claim->member->user->fstName  }}</td>
                                <td class="text-center">{{ $claim->date }}</td>
                                <td class="text-center">{{ $claim->status }}</td>
                                <td class="no-sort no-click bread-actions">
                                    <form method="POST" action="{{url('admin/accept',$claim->id)}}">
                                        @csrf
                                        <button onclick="return confirm('Are you sure you want to accept this claim?')" type="submit" class="btn btn-primary">
                                         Accept
                                        </button>
                                    </form>
                                </td> 

                                <td class="no-sort no-click bread-actions">
                                    <form method="POST" action="{{url('admin/refuse',$claim->id)}}">
                                        @csrf
                                        <button onclick="return confirm('Are you sure you want to refuse this claim?')" type="submit" class="btn btn-primary">
                                        Refuse
                                        </button>
                                     </form>
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
