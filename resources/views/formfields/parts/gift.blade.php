@php
$default_row = new \stdClass();
$default_row->id = " ";
$default_row->points = " ";
$row = $row ?? $default_row;
$index = $index ?? 0;
@endphp

<div class="row ingredients-row" id="ingredients-row-{{$index}}" data-index="{{$index}}">
    <div class="col-md-2">
        <?php
            $gifts =  \App\Models\GiftNameInx::all();
        ?>

        <select class="form-control ingredients-id" name="giftsNames[{{$index}}][id]" required value="{{$row->id}}">
        {{$row->id}}
        @foreach ($gifts as $gift)
            @if($gift->id == $row->id)
            {{$gift->giftsNames}}
                    <option value="{{$gift->id}}" selected>
                        {{ $gift->name }}
                    </option>    
            @elseif($gift->id != $row->id)
                    <option value="{{$gift->id}}" >
                        {{ $gift->name }}
                    </option>
            @endif
        @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <input type="number" class="form-control ingredients-points" name="giftsNames[{{$index}}][points]" required value="{{$row->points}}" />
    </div>
 
    <div class="col-md-1 remove-ingredients-col">
        <button class="btn btn-danger remove-ingredients-row-btn" data-remove-row={{$index}}>
            X
        </button>
    </div>
</div>