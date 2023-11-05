@php
$default_row = new \stdClass();
$default_row->id = " ";
$row = $row ?? $default_row;
$index = $index ?? 0;
@endphp

    <div class="row inrow" id="inrow-{{$index}}" data-index="{{$index}}" >
        <div class="col-md-2">
         
            <select class="form-control inid members" name="receivers[{{$index}}][id]"  value="{{$row->id}}" id="select-1">

                    <?php
                     
                        $members = [];
                        $members[0] = "Silver";
                        $members[1] = "Gold";
                        $members[3] = "Platinum";
                        $members[4] = "Unclassified";
                    
                    ?>
                <option value=""></option> 
                <option value="All">
                   All
                </option>
             
                @foreach ($members as $key => $member)
            
                <option value="{{$member}}">
                {{$member}}
                </option>
              
                @endforeach
            </select>

            <select class="form-control inid observers" name="receivers[{{$index}}][id]"  value="{{$row->id}}" id="select-2">

                <?php
                  
                    $members =  \App\Models\User::where('userable_type',"observer")->get();

                ?>
                    <option value=""></option> 

                    <option value="All">
                    All
                    </option>

                    @foreach ($members as $key => $member)

                    <option value="{{$member->fstName}}">
                    {{$member->fstName}}
                    </option>

                    @endforeach
            </select>

            <select class="form-control inid distributors" name="receivers[{{$index}}][id]"  value="{{$row->id}}" id="select-3">

                <?php
                   
                    $members2 =  \App\Models\CityInx::all();

                ?>
                <option value=""></option> 

                <option value="All">
                All
                </option>

                @foreach ($members2 as $key => $member)

                <option value="{{$member->name}}">
                {{$member->name}}
                </option>

                @endforeach
            </select>

        </div>
    
        <div class="col-md-1 remove-ingredients-col">
            <button class="btn btn-danger remove-inrow-btn" data-remove-row={{$index}}>
                X
            </button>
        </div>
    </div>

