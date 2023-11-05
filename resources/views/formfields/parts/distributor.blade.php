@php
$default_row = new \stdClass();
$default_row->id = " ";
$row = $row ?? $default_row;
$index = $index ?? 0;
@endphp

<div class="row ingredients-rowww" id="ingredients-rowww-{{$index}}" data-index="{{$index}}">
    <div class="col-md-2">
        <?php
        $distributors = [];
        $dis =  \App\Models\Distributor::all();
        foreach($dis as $distributor){
            $id = $distributor->id;
            $user = $distributor->user;
            // $user = \App\Models\User::where('userable_id',$id)->where('userable_type',"distributor")->first();
            if($user){
                if($user->is_active == 1){
                    $distributors[] = $distributor;
                 }
            }
             
        }
        ?>
        <!-- <input type="number" class="form-control ingredients-amount" name="related_products[{{$index}}][id]" required value="{{$row->id}}" /> -->
        <select class="form-control ingredients-idd" name="distributors[{{$index}}][id]" required value="{{$row->id}}">
        {{$row->id}}
        
        @foreach ($distributors as $distrib)
            @if($distrib->id == $row->id)
            {{$distrib->distributors}}
            <option value="{{$distrib->id}}" selected>
            {{ $distrib->name }}
            </option>    
            @elseif($distrib->id != $row->id)
            <option value="{{$distrib->id}}">
            {{ $distrib->name }}
            </option>
            @endif
        @endforeach
      
        </select>
    </div>
 
    <div class="col-md-1 remove-ingredients-col">
        <button class="btn btn-danger remove-ingredients-rowww-btn" data-remove-row={{$index}}>
            X
        </button>
    </div>
</div>