@php
    $data = json_decode($dataTypeContent->size_price);
@endphp

<div id="ingredients-container">
    <div class="ingredients-header-row row">
        <div class="voyager-header-col col-md-2">
            <!-- show in add edit -->
            <p class="control-label">
                Price
            </p>
        </div>
        <div class="voyager-header-col col-md-2">
            <p class="control-label">
               Size
            </p>
        </div>
        <!-- <div class="voyager-header-col col-md-8">
            <p class="control-label">
                Name
            </p>
        </div> -->
    </div>

    @if ($data)
        @foreach ($data as $row)
            @include('formfields.parts.sizeprice', ['index' => $loop->index, 'row' => $row])
        @endforeach
    @else
        @include('formfields.parts.sizeprice')
    @endif
</div>
<button type="button" name="add" id="addIngredient" class="btn btn-light">Add Size Price</button>
<script type="text/javascript" src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/ingredients.js') }}"></script>
