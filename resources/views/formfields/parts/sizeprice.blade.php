@php
$default_row = new \stdClass();
$default_row->size = " ";
$default_row->price = " ";
$row = $row ?? $default_row;
$index = $index ?? 0;
@endphp

<div class="row ingredients-row" id="ingredients-row-{{$index}}" data-index="{{$index}}">
    <div class="col-md-2">
        <input type="number" class="form-control ingredients-amount" name="size_price[{{$index}}][price]" required value="{{$row->price}}" />
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control ingredients-units" name="size_price[{{$index}}][size]" required value="{{$row->size}}" />
    </div>
 
    <div class="col-md-1 remove-ingredients-col">
        <button class="btn btn-danger remove-ingredients-row-btn" data-remove-row={{$index}}>
            X
        </button>
    </div>
</div>