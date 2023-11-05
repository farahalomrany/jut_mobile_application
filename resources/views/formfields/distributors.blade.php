@php
    $data = json_decode($dataTypeContent->distributors);
@endphp

<div id="ingredients-containerrr">
    <div class="ingredients-header-row row">
        <div class="voyager-header-col col-md-2">
            <!-- show in add edit -->
            <p class="control-label">
                All Distributors
            </p>
        </div>
    
    </div>

    @if ($data)
        @foreach ($data as $row)
            @include('formfields.parts.distributor', ['index' => $loop->index, 'row' => $row])
        @endforeach
    @else
        @include('formfields.parts.distributor')
    @endif
</div>
<button type="button" name="add" id="addIngredient_three" class="btn btn-light">Add Distributor</button>
<script type="text/javascript" src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/ingredients4.js') }}"></script>
