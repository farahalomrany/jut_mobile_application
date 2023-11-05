@php
$default_row = new \stdClass();
$default_row->name = " ";
$row = $row ?? $default_row;
$index = $index ?? 0;
@endphp

    <div class="row ingredients-row" id="ingredients-row-{{$index}}" data-index="{{$index}}" >
        <div class="col-md-2">
         
            <select class="form-control ingredients-destination" name="destination[{{$index}}][name]" required value="{{$row->name}}" id="base">

                    <?php
                     
                        $users = [];
                        $users[0] = "members";
                        $users[1] = "observers";
                        $users[3] = "distributors";
                        
                    ?>
                <option value="">

                </option>    
                @foreach ($users as $key => $user)
            
                <option value="{{$user}}">
                {{$user}}
                </option>
              
                @endforeach
            </select>

        </div>
    
        <!-- <div class="col-md-1 remove-ingredients-col">
            <button class="btn btn-danger remove-ingredients-row-btn" data-remove-row={{$index}}>
                X
            </button>
        </div> -->
    </div>

