<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <input type="file" name="image1" class="form-control" required>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <input type="file" name="image2" class="form-control" required>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <input type="file" name="image3" class="form-control" required>
        </div>
    </div>
</div>

@if (isset($group->images))
    @if (isset($group->images[0]))
        <div class="row">
            <div class="col-lg-4">
                <img src="{{ url('uploads/semen/' . $group->images[0]->image_name) }}"
                    style="height: 150px; width: 270px; ">
            </div>
    @endif
    @if (isset($group->images[1]))
        <div class="col-lg-4">
            <img src="{{ url('uploads/semen/' . $group->images[1]->image_name) }}"
                style="height: 150px; width: 270px; ">
        </div>
    @endif
    @if (isset($group->images[2]))
        <div class="col-lg-4">
            <img src="{{ url('uploads/semen/' . $group->images[2]->image_name) }}"
                style="height: 150px; width: 270px; ">
        </div>
    @endif
    </div>
@endif
