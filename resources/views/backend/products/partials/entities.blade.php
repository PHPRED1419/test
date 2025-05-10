<div class="row">
    
    @if(!empty($sizes))
        <div class="col-md-6">
            <div class="form-group">
            <label class="control-label" for="brand">Product Sizes<span class="optional">(optional)</span></label>
            <div style="height:150px; overflow-x:hidden; overflow-y:scroll; border: 1px solid #CCC;">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                    @foreach($sizes as $val)
                    @php                    
                    $sizeIds = explode(',', $product->product_size_ids);
                    @endphp
                    <tr  class="border-bottom">
                        <td style="padding:7px 0px 0px 3px;" width="95%"> 
                        <label style="font-weight: inherit !important;"><input type="checkbox" name="size_id[]" id="size_id" style="margin-left:3px;" value="{{ $val->size_id }}" @if(in_array($val->size_id, $sizeIds)) checked @endif> {{ $val->size_name }} </label>
                        </td>
                    </tr>                    
                    @endforeach
                    </tbody>
                </table>
              </div>
            </div>
        </div>
    @endif

    @if(!empty($colors))
    <div class="col-md-6">
            <div class="form-group">
            <label class="control-label" for="brand">Product Colors<span class="optional">(optional)</span></label>
            <div style="height:150px; overflow-x:hidden; overflow-y:scroll; border: 1px solid #CCC;">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                    @foreach($colors as $val)
                    @php                    
                    $colorIds = explode(',', $product->product_color_ids);
                    @endphp
                    <tr class="border-bottom" style="background-color:{{ $val->color_code }};">
                        <td style="padding:7px 0px 0px 3px;" width="95%"> 
                        <label style="font-weight: inherit !important;"><input type="checkbox" name="color_id[]" id="color_id" style="margin-left:3px;" value="{{ $val->color_id }}" @if(in_array($val->color_id, $colorIds)) checked @endif> {{ $val->color_name }} </label>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
              </div>
            </div>
        </div>
    @endif

    @if(!empty($brands))
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="brand">Brand<span class="optional">(optional)</span></label>
                <select  id="brand_id" name="brand_id" class="form-control">
                    <option value="">Select</option>
                    @foreach($brands as $val)
                        <option value="{{ $val->brand_id }}" {{ $val->brand_id == $product->brand_id ? 'selected' : '' }}>{{ $val->brand_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    @if(!empty($models))
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="brand">Model<span class="optional">(optional)</span></label>
                <select  id="part_id" name="part_id" class="form-control">
                    <option value="">Select</option>
                    @foreach($models as $val)
                        <option value="{{ $val->part_id }}" {{ $val->part_id == $product->part_id ? 'selected' : '' }}>{{ $val->part_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    
</div>
