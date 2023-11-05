@php
$default_row = new \stdClass();
$default_row->size = " ";
$default_row->silver = " ";
$default_row->gold = " ";
$default_row->platinum = " ";
$row = $row ?? $default_row;
$index = $index ?? 0;
@endphp

<div class="row ingredients-row" id="ingredients-row-{{$index}}" data-index="{{$index}}">
    <div class="col-md-2">
        <input type="text" class="form-control ingredients-size" name="points[{{$index}}][size]" required value="{{$row->size}}" />
    </div>
    <div class="col-md-2">
        <input type="number" class="form-control ingredients-silver" name="points[{{$index}}][silver]" required value="{{$row->silver}}" />
    </div>
    <div class="col-md-2">
        <input type="number" class="form-control ingredients-gold" name="points[{{$index}}][gold]" required value="{{$row->gold}}" />
    </div>
    <div class="col-md-2">
        <input type="number" class="form-control ingredients-platinum" name="points[{{$index}}][platinum]" required value="{{$row->platinum}}" />
    </div>
 
    <div class="col-md-1 remove-ingredients-col">
        <button class="btn btn-danger remove-ingredients-row-btn" data-remove-row={{$index}}>
            X
        </button>
    </div>
</div>