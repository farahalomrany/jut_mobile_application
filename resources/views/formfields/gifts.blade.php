@php
    $data = json_decode($dataTypeContent->giftsNames);
@endphp

<div id="ingredients-container">
    <div class="ingredients-header-row row">
        <div class="voyager-header-col col-md-2">
            <!-- show in add edit -->
            <p class="control-label">
              Gift
            </p>
        </div>
        <div class="voyager-header-col col-md-2">
            <p class="control-label">
               Points
            </p>
        </div>
    </div>

    @if ($data)
        @foreach ($data as $row)
            @include('formfields.parts.gift', ['index' => $loop->index, 'row' => $row])
        @endforeach
    @else
        @include('formfields.parts.gift')
    @endif
</div>
<button type="button" name="add" id="addIngredient" class="btn btn-light">Add Gift</button>
<script type="text/javascript" src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/ingredients5.js') }}"></script>
