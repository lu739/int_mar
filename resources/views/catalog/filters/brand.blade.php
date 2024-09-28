<div>
    <h5 class="mb-4 text-sm 2xl:text-md font-bold">{{$filter->title()}}</h5>
    @foreach($filter->values() as $id => $brand)
        <div class="form-checkbox">
            <input name="{{$filter->name($id)}}"
                   value="{{$id}}"
                   @checked($filter->requestValue($id) ?? false)
                   type="checkbox"
                   id="{{$id}}">
            <label for="{{$id}}" class="form-checkbox-label">{{$brand}}</label>
        </div>
    @endforeach
</div>
