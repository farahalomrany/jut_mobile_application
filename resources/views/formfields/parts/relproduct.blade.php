@php
$default_row = new \stdClass();
$default_row->id = " ";
$row = $row ?? $default_row;
$index = $index ?? 0;
@endphp

<div class="row ingredients-roww" id="ingredients-roww-{{$index}}" data-index="{{$index}}">
    <div class="col-md-2">
        <?php
        $products =  \App\Models\Product::all();
       
        ?>
        <select class="form-control ingredients-amountt" name="related_products[{{$index}}][id]"  value="{{$row->id}}">
        {{$row->id}}

        <option value="" selected>
                       
        </option>

        @foreach ($products as $pro)
            @if($pro->id == $row->id)
                    <option value="{{$pro->id}}" selected>
                        {{ $pro->name }}
                    </option>
            @elseif($pro->id != $row->id)
                    <option value="{{$pro->id}}">
                        {{ $pro->name }}
                    </option>
            @endif
        @endforeach
        </select>
    </div>
 
    <div class="col-md-1 remove-ingredients-col">
        <button class="btn btn-danger remove-ingredients-roww-btn" data-remove-row={{$index}}>
            X
        </button>
    </div>
</div>