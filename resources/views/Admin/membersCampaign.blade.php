@extends('voyager::master')

@section('page_title', __('voyager::generic.view').'Members With Campaigns')

<!-- PAGE HEADER -->
@section('page_header')

    <h1 class="page-title">
        <i class="voyager-trophy"></i> {{ ucfirst('View Members With Campaigns') }} &nbsp;
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
                Members With Points
                </h3>

                <br>
                <div class="card" style="margin: 0px 10px;">

                    <table id="table-add-opt" class="table datatable-basic table-striped" style=" margin: 0;">

                        <thead>

                            <tr>
                                <th class="text-center">Member Name</th>
                                <th class="text-center">Campaigns</th>
                                <th class="text-center">Points</th>
                            </tr>

                        </thead>

                        <tbody>
                        @foreach($members  as $member)

                             @php
                             $campaigns = \App\Models\Campaign::all();
                             $user = $member->user;
                             if($user){
                                 $member_name = $user->fstName;
                             }
                             else{
                                $member_name = "";
                             }
                             @endphp
                            <tr class="row_point">
                                <td class="text-center member"  data-member-id="{{$member->id}}">{{ $member_name }}</td>
                                <td class="text-center">  
                                    <select class="form-control campaign"  name="campaign" >
                                    <option value="" ></option>

                                        @foreach ($campaigns as $campaign)
                                        <option value="{{$campaign->id}}" >
                                        {{ $campaign->start_date }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                              
                                <td class="text-center points" id="points{{$member->id}}"></td>
                                
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

    <script>
            $(".campaign").on("change",function() {
                 
            var member_id = $(this).parent().parent().find(".member").data("member-id");
            var campaign_id = $(this).val();
            
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
           
            $.ajax({
                url:"{{route('set-point')}}",
                method:"POST",
                data: {campaign_id: campaign_id, member_id: member_id},
            
                success: function(resp) {
                    
                    $(`#points${member_id}`).empty();
                    $(`#points${member_id}`).append(resp);
                  
                },
            });
                  
            });
    </script>

    <!-- <script>
        $("#campaign").on("change", function(e) {
           
            e.preventDefault();
            var campaign_id = $(this).data("campaign-id");

            var member_id = document.getElementsByClassName(member);
            alert (member_id);

            var spinner = "";

            var base_url = '{{ env('APP_URL') }}' + '/capability_details/all/';
            // alert(id);
            $.ajax({
                url: base_url + id,
                type: "GET",
                dataType: "html",
                beforeSend: function(ex) {
                    $('.capaloader').css("display", "block");
                },
                success: function(resp) {
                    ()
                    console.log(resp);
                    $('.capaloader').css("display", "none");
                    $('#caparesult').empty();

                    $('#caparesult').append(resp);
                },
            });

        });
    </script> -->
@endsection
