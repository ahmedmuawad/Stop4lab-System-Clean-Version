@php
    $test_settings = json_decode($test['setting'], true);
@endphp

<div class="modal fade" id="setting_modal{{ $test['id'] }}" aria-hidden="true">
    <div class="modal-dialog modal-md" style="max-width:1050px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Report Setting') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
                
                
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                {{ __('Status / Unit / Normal Range ') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="test_title_color">{{ __('Status') }}</label>
                                        <div class="input-group">
                                            <input id="" type="checkbox" class="form-control"
                                                name="test_title[color]"
                                                checked
                                                value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="test_title_color">{{ __('Unit') }}</label>
                                        <div class="input-group">
                                            <input id="" type="checkbox" class="form-control"
                                                name="test_title[color]"
                                                checked
                                                value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="test_title_color">{{ __('Normal Range') }}</label>
                                        <div class="input-group">
                                            <input id="" type="checkbox" class="form-control"
                                                name="test_title[color]"
                                                checked
                                                value="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                {{ __('Test title') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="test_title_color">{{ __('Color') }}</label>
                                        <div class="input-group">
                                            <input id="test_title_color" type="color" class="form-control"
                                                name="test_title[color]"
                                                value="{{ $test_settings['test_title']['color'] }}" required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $test_settings['test_title']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label for="test_title_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="test_title[font-size]"
                                        id="test_title_font_size" min="1"
                                        value="{{ $test_settings['test_title']['font-size'] }}" required>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('Margin top') }}</label>
                                    <input type="number" class="form-control" name="test_title[margin-top]"
                                        id="" min="0"
                                        value="{{ $test_settings['test_title']['margin-top'] }}" required>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('Margin bottom') }}</label>
                                    <input type="number" class="form-control" name="test_title[margin-buttom]"
                                        id="" min="0"
                                        value="{{ $test_settings['test_title']['margin-buttom'] }}" required>
                                </div>
                                {{-- <div class="col-lg-4">
                            <label for="">{{__('Height')}}</label>
                            <input type="number" class="form-control" name="test_title[height]" id="" min="1" value="{{$test_settings['test_title']['height']}}" required>
                          </div> --}}

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                {{ __('Test name') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="test_name_color">{{ __('Color') }}</label>
                                        <div class="input-group">
                                            <input id="test_name_color" type="color" class="form-control"
                                                name="test_name[color]"
                                                value="{{ $test_settings['test_name']['color'] }}" required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $test_settings['test_name']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <label for="test_name_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="test_name[font-size]"
                                        id="test_name_font_size" min="1"
                                        value="{{ $test_settings['test_name']['font-size'] }}" required>
                                </div>
                                <div class="col-lg-3">
                                    <label for="test_name_font_size">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="test_name[height]" id=""
                                        min="1" value="{{ $test_settings['test_name']['height'] }}" required>
                                </div>
                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="test_name[text-align]" id="" required>
                                      <option value="center" @if($test_settings['test_name']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($test_settings['test_name']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($test_settings['test_name']['text-align']=='right') selected @endif>{{__('Right')}}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                {{ __('Test head') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="test_head_color">{{ __('Color') }}</label>
                                        <div class="input-group">
                                            <input id="test_head_color" type="color"
                                                class="form-control" name="test_head[color]"
                                                value="{{ $test_settings['test_head']['color'] }}" required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $test_settings['test_head']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <label for="test_head_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="test_head[font-size]"
                                        id="test_head_font_size" min="1"
                                        value="{{ $test_settings['test_head']['font-size'] }}" required>
                                </div>

                                <div class="col-lg-3">
                                    <label for="test_name_font_size">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="test_head[height]"
                                        id="" min="1"
                                        value="{{ $test_settings['test_head']['height'] }}" required>
                                </div>

                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="test_head[text-align]" id="" required>
                                      <option value="center" @if($test_settings['test_head']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($test_settings['test_head']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($test_settings['test_head']['text-align']=='right') selected @endif>{{__('Right')}}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                {{ __('Result') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="result_color">{{ __('Color') }}</label>
                                        <div class="input-group">
                                            <input id="result_color" type="color" class="form-control"
                                                name="result[color]" value="{{ $test_settings['result']['color'] }}"
                                                required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $test_settings['result']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <label for="result_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="result[font-size]"
                                        id="result_font_size" min="1"
                                        value="{{ $test_settings['result']['font-size'] }}" required>
                                </div>

                                <div class="col-lg-3">
                                    <label for="test_name_font_size">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="result[height]" id=""
                                        min="1" value="{{ $test_settings['result']['height'] }}" required>
                                </div>

                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="result[text-align]" id="" required>
                                      <option value="center" @if($test_settings['result']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($test_settings['result']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($test_settings['result']['text-align']=='right') selected @endif>{{__('Right')}}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                {{ __('Test unit') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="unit_color">{{ __('Color') }}</label>
                                        <div class="input-group">
                                            <input id="unit_color" type="color" class="form-control"
                                                name="unit[color]" value="{{ $test_settings['unit']['color'] }}"
                                                required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $test_settings['unit']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label for="unit_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="unit[font-size]"
                                        id="unit_font_size" min="1"
                                        value="{{ $test_settings['unit']['font-size'] }}" required>
                                </div>

                                <div class="col-lg-3">
                                    <label for="test_name_font_size">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="unit[height]" id=""
                                        min="1" value="{{ $test_settings['unit']['height'] }}" required>
                                </div>

                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="unit[text-align]" id="" required>
                                      <option value="center" @if($test_settings['unit']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($test_settings['unit']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($test_settings['unit']['text-align']=='right') selected @endif>{{__('Right')}}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                {{ __('Test reference range') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="reference_range_color">{{ __('Color') }}</label>
                                        <div class="input-group">
                                            <input id="reference_range_color" type="color"
                                                class="form-control" name="reference_range[color]"
                                                value="{{ $test_settings['reference_range']['color'] }}" required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $test_settings['reference_range']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <label for="reference_range_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="reference_range[font-size]"
                                        id="reference_range_font_size" min="1"
                                        value="{{ $test_settings['reference_range']['font-size'] }}" required>
                                </div>

                                <div class="col-lg-3">
                                    <label for="">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="reference_range[height]"
                                        id="" min="1"
                                        value="{{ $test_settings['reference_range']['height'] }}" required>
                                </div>

                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="reference_range[text-align]" id="" required>
                                      <option value="center" @if($test_settings['reference_range']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($test_settings['reference_range']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($test_settings['reference_range']['text-align']=='right') selected @endif>{{__('Right')}}</option>
                                    </select>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                {{ __('Test status') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="status_color">{{ __('Color') }}</label>
                                        <div class="input-group">
                                            <input id="status_color" type="color" class="form-control"
                                                name="status[color]" value="{{ $test_settings['status']['color'] }}"
                                                required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $test_settings['status']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <label for="status_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="status[font-size]"
                                        id="status_font_size" min="1"
                                        value="{{ $test_settings['status']['font-size'] }}" required>
                                </div>

                                <div class="col-lg-3">
                                    <label for="">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="status[height]" id=""
                                        min="1" value="{{ $test_settings['status']['height'] }}" required>
                                </div>

                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="status[text-align]" id="" required>
                                      <option value="center" @if($test_settings['status']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($test_settings['status']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($test_settings['status']['text-align']=='right') selected @endif>{{__('Right')}}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                {{ __('Test comment') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="comment_color">{{ __('Color') }}</label>
                                        <div class="input-group">
                                            <input id="comment_color" type="color" class="form-control"
                                                name="comment[color]"
                                                value="{{ $test_settings['comment']['color'] }}" required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $test_settings['comment']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label for="comment_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="comment[font-size]"
                                        id="comment_font_size" min="1"
                                        value="{{ $test_settings['comment']['font-size'] }}" required>
                                </div>

                                <div class="col-lg-3">
                                    <label for="">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="comment[height]" id=""
                                        min="1" value="{{ $test_settings['comment']['height'] }}" required>
                                </div>

                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="comment[text-align]" id="" required>
                                      <option value="center" @if($test_settings['comment']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($test_settings['comment']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($test_settings['comment']['text-align']=='right') selected @endif>{{__('Right')}}</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                    <input type="submit" name="setting_test_{{ $test->id }}" class="btn btn-primary" value="{{ __('Save') }}" />
                </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
