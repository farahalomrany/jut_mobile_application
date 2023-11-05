@php
    $data = json_decode($dataTypeContent->points);
@endphp

<div id="ingredients-container">
    <div class="ingredients-header-row row">
        <div class="voyager-header-col col-md-2">
            <!-- show in add edit -->
            <p class="control-label">
                Size
            </p>
        </div>
        <div class="voyager-header-col col-md-2">
            <p class="control-label">
               Silver
            </p>
        </div>
        <div class="voyager-header-col col-md-2">
            <p class="control-label">
                Gold
            </p>
        </div>

        <div class="voyager-header-col col-md-2">
            <p class="control-label">
                Platinum
            </p>
        </div>
    </div>

    @if ($data)
        @foreach ($data as $row)
            @include('formfields.parts.point', ['index' => $loop->index, 'row' => $row])
        @endforeach
    @else
        @include('formfields.parts.point')
    @endif
</div>
<button type="button" name="add" id="addIngredient" class="btn btn-light">Add Point</button>
<script type="text/javascript" src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/ingredients3.js') }}"></script>
