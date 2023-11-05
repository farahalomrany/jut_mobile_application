@extends('voyager::master')

@section('page_title', __('voyager::generic.view').'Gifts')

<!-- PAGE HEADER -->
@section('page_header')

    <h1 class="page-title">
        <i class="voyager-trophy"></i> {{ ucfirst('View Gifts') }} &nbsp;

    <!-- {{-- Single Assign Program  --}} -->
        <a class="btn btn-primary" id="import_btn"><i class="voyager-setting"></i> <span>Assign Gifts</span></a>

        <div class="modal modal-danger fade" tabindex="-1" id="import_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>

                    </div>
                  

                        <h2 align="center">Give gifts for member who has {{$member_points}} points</h2>
                        <td>
                        <form id="program_form" method="POST">
                             {!! csrf_field() !!}
                                 <select id="program" name="program_ids[]" multiple class="form-control" >
                                
                                    @foreach($gifts as $gift)
                                    
                                        <option value="{{$gift->id}}"  >{{$gift->name}} </option>
                                        
                                    @endforeach
                                </select>
                                <input type="hidden" name="claim_id" value="{{$claim_id}}" />
                                <input type="hidden" name="current_campaign_id" value="{{$current_campaign_id}}" />
                               
                            <div class="form-group">
                                <input type="submit" class="btn btn-info"  value="Submit" />
                            </div>
                            
                        </form>
                        </td>

                       

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

       

    </h1>

    @include('voyager::multilingual.language-selector')

@endsection
<!-- PAGE HEADER -->

<!-- PAGE CONTENT -->
@section('content')
    
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

    <script type="text/javascript">

        $(document).ready(function(){

            $('#import_btn').on('click', function (e) {
                
                $('#import_modal').modal('show');
            });


                $('#program').multiselect({
                    nonSelectedText: 'Select gifts',
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    buttonWidth:'400px'
                });
                $('#program_form').on('submit', function(event){
                  
                        //event.preventDefault();
                        var form_data = $(this).serialize();
                        $.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        });
                        $.ajax({
                            url:"{{ route('set-gift') }}",
                            method:"POST",
                            data:form_data,
                        
                            success:function(data)
                                    {
                                        // $('#program option:selected').each(function(){
                                        // $(this).prop('selected', false);
                                        // });
                                           
                                        // $('#program').multiselect('refresh');
                                        $('#import_modal').modal('hide');
                                        // alert('success');
                                    }
                        });
                      
                });

        });

    </script>

@endsection
