@php
    $data = json_decode($dataTypeContent->related_products);
@endphp

<div id="ingredients-containerr">
    <div class="ingredients-header-row row">
        <div class="voyager-header-col col-md-2">
            <!-- show in add edit -->
            <p class="control-label">
                All Products
            </p>
        </div>
    </div>

    @if ($data)
        @foreach ($data as $row)
            @include('formfields.parts.relproduct', ['index' => $loop->index, 'row' => $row])
        @endforeach
    @else
        @include('formfields.parts.relproduct')
    @endif
</div>
<button type="button" name="add" id="addIngredient_two" class="btn btn-light">Add Related Product</button>
<script type="text/javascript" src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/ingredients2.js') }}"></script>
