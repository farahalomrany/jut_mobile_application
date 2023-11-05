@php
    $data = json_decode($dataTypeContent->receivers);
@endphp

<div id="ingredients-containerrrrr">
    <div class="ingredients-header-row row">
        <div class="voyager-header-col col-md-2">
            <!-- show in add edit -->
            <p class="control-label">
            
            </p>
        </div>
    </div>

    @if ($data)
        @foreach ($data as $row)
            @include('formfields.parts.receiver', ['index' => $loop->index, 'row' => $row])
        @endforeach
    @else
        @include('formfields.parts.receiver')
    @endif
</div>
<button type="button" name="add" id="addIngredientttt" class="btn btn-light">Add Receivers</button>
<script type="text/javascript" src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/ingredients6.js') }}"></script>
<script>
    let selectOne = document.querySelector("#select-1"), 
    selectTwo = document.querySelector("#select-2"), 
    selectThree = document.querySelector("#select-3"),
    base = document.querySelector("#base");
    selectOne.disabled = true;
    selectTwo.disabled = true;
    selectThree.disabled = true;
    base.addEventListener("change", () => {
    if (base.value == "members") {
        selectOne.disabled = false;
        selectTwo.disabled = true;
        selectThree.disabled = true;
    } else if(base.value == "observers"){
        selectOne.disabled = true;
        selectTwo.disabled = false;
        selectThree.disabled = true;
    }else if(base.value == "distributors"){
        selectOne.disabled = true;
        selectTwo.disabled = true;
        selectThree.disabled = false;
    }
    })
  
</script>