@extends('voyager::master')

@section('page_title', __('voyager::generic.view').'Add product')

<!-- PAGE HEADER -->
@section('page_header')

    <h1 class="page-title">
        <i class="voyager-trophy"></i> {{ ucfirst('Add product') }} &nbsp;

@endsection
<!-- PAGE HEADER -->

<!-- PAGE CONTENT -->
@section('content')
            <div class="page-content read container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <br>
                        <div class="" style="margin: 0px 10px;">
                        <div class="" style="margin: 0px 10px;">
                                <form class="form-horizontal" action="{{route('add_product')}}" method="post">
                                    {{csrf_field()}}


                                    <div class="form-group">
                                        <label for="inp-type-1" class=" control-label">Product</label>
                                        <div class="">
                                            <input type="text" class="form-control" id="inp-type-1" name="name" placeholder="Please Enter Name..">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inp-type-1" class=" control-label">Points</label>
                                        <div class="">
                                            <input type="text" class="form-control" id="inp-type-1" name="duration" placeholder="Please Enter Duration..">
                                        </div>
                                    </div>

                                <br>
                                    <div class="col-sm-6 col-sm-offset-4">
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    </div>
                                </form>
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
