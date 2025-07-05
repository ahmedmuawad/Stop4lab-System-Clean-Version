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
                                {{ __('Status / Unit / Normal Range / Single Page') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="test_title_color">{{ __('Status') }}</label>
                                        <div class="input-group">
                                            <input id="" type="checkbox" class="form-control"
                                                name="show_status"
                                                @if( isset($settings['show_status']) && $settings['show_status'] == false )
                                                @else
                                                    checked
                                                @endif
                                               value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="test_title_color">{{ __('Unit') }}</label>
                                        <div class="input-group">
                                            <input id="" type="checkbox" class="form-control"
                                                name="show_unit"
                                                @if( isset($settings['show_unit']) && $settings['show_unit'] == false )
                                                @else
                                                    checked
                                                @endif
                                                value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="test_title_color">{{ __('Normal Range') }}</label>
                                        <div class="input-group">
                                            <input id="" type="checkbox" class="form-control"
                                                name="show_range"
                                                @if( isset($settings['show_range']) && $settings['show_range'] == false )
                                                @else
                                                    checked
                                                @endif
                                                value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="test_title_color">{{ __('Single Page') }}</label>
                                        <div class="input-group">
                                            <input id="" type="checkbox" class="form-control"
                                                name="new_line"
                                                @if( isset($settings['new_line']) && $settings['new_line'] == true )
                                                    checked                                                  
                                                @endif
                                                value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="test_title_color">{{ __('HighLite') }}</label>
                                        <div class="input-group">
                                            <input id="" type="checkbox" class="form-control"
                                                name="highlite"
                                                @if( isset($settings['highlite']) && $settings['highlite'] == true )
                                                    checked                                                  
                                                @endif
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
                                                value="{{ $settings['test_title']['color'] }}" required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $settings['test_title']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label for="test_title_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="test_title[font-size]"
                                        id="test_title_font_size" 
                                        value="{{ $settings['test_title']['font-size'] }}" required>
                                </div>
                                <div class="col-lg-3">
                                    <label for="test_title_font_size">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="test_title[height]" id=""
                                         value="{{ $settings['test_title']['height'] }}" required>
                                </div>
                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="test_title[text-align]" id="" required>
                                      <option value="center" @if($settings['test_title']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($settings['test_title']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($settings['test_title']['text-align']=='right') selected @endif>{{__('Right')}}</option>
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
                                                value="{{ $settings['test_name']['color'] }}" required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $settings['test_name']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <label for="test_name_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="test_name[font-size]"
                                        id="test_name_font_size" 
                                        value="{{ $settings['test_name']['font-size'] }}" required>
                                </div>
                                <div class="col-lg-3">
                                    <label for="test_name_font_size">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="test_name[height]" id=""
                                         value="{{ $settings['test_name']['height'] }}" required>
                                </div>
                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="test_name[text-align]" id="" required>
                                      <option value="center" @if($settings['test_name']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($settings['test_name']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($settings['test_name']['text-align']=='right') selected @endif>{{__('Right')}}</option>
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
                                                value="{{ $settings['test_head']['color'] }}" required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $settings['test_head']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <label for="test_head_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="test_head[font-size]"
                                        id="test_head_font_size" 
                                        value="{{ $settings['test_head']['font-size'] }}" required>
                                </div>

                                <div class="col-lg-3">
                                    <label for="test_name_font_size">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="test_head[height]"
                                        id="" 
                                        value="{{ $settings['test_head']['height'] }}" required>
                                </div>

                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="test_head[text-align]" id="" required>
                                      <option value="center" @if($settings['test_head']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($settings['test_head']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($settings['test_head']['text-align']=='right') selected @endif>{{__('Right')}}</option>
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
                                                name="result[color]" value="{{ $settings['result']['color'] }}"
                                                required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $settings['result']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <label for="result_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="result[font-size]"
                                        id="result_font_size" 
                                        value="{{ $settings['result']['font-size'] }}" required>
                                </div>

                                <div class="col-lg-3">
                                    <label for="test_name_font_size">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="result[height]" id=""
                                         value="{{ $settings['result']['height'] }}" required>
                                </div>

                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="result[text-align]" id="" required>
                                      <option value="center" @if($settings['result']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($settings['result']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($settings['result']['text-align']=='right') selected @endif>{{__('Right')}}</option>
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
                                                name="unit[color]" value="{{ $settings['unit']['color'] }}"
                                                required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $settings['unit']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label for="unit_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="unit[font-size]"
                                        id="unit_font_size" 
                                        value="{{ $settings['unit']['font-size'] }}" required>
                                </div>

                                <div class="col-lg-3">
                                    <label for="test_name_font_size">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="unit[height]" id=""
                                         value="{{ $settings['unit']['height'] }}" required>
                                </div>

                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="unit[text-align]" id="" required>
                                      <option value="center" @if($settings['unit']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($settings['unit']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($settings['unit']['text-align']=='right') selected @endif>{{__('Right')}}</option>
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
                                                value="{{ $settings['reference_range']['color'] }}" required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $settings['reference_range']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <label for="reference_range_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="reference_range[font-size]"
                                        id="reference_range_font_size" 
                                        value="{{ $settings['reference_range']['font-size'] }}" required>
                                </div>

                                <div class="col-lg-3">
                                    <label for="">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="reference_range[height]"
                                        id="" 
                                        value="{{ $settings['reference_range']['height'] }}" required>
                                </div>

                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="reference_range[text-align]" id="" required>
                                      <option value="center" @if($settings['reference_range']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($settings['reference_range']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($settings['reference_range']['text-align']=='right') selected @endif>{{__('Right')}}</option>
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
                                                name="status[color]" value="{{ $settings['status']['color'] }}"
                                                required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $settings['status']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <label for="status_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="status[font-size]"
                                        id="status_font_size" 
                                        value="{{ $settings['status']['font-size'] }}" required>
                                </div>

                                <div class="col-lg-3">
                                    <label for="">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="status[height]" id=""
                                         value="{{ $settings['status']['height'] }}" required>
                                </div>

                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="status[text-align]" id="" required>
                                      <option value="center" @if($settings['status']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($settings['status']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($settings['status']['text-align']=='right') selected @endif>{{__('Right')}}</option>
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
                                                value="{{ $settings['comment']['color'] }}" required>
                                            <div class="input-group-append color_tool">
                                                <span class="input-group-text"><i class="fas fa-square"
                                                        style="color: {{ $settings['comment']['color'] }}"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <label for="comment_font_size">{{ __('Font size') }}</label>
                                    <input type="number" class="form-control" name="comment[font-size]"
                                        id="comment_font_size" 
                                        value="{{ $settings['comment']['font-size'] }}" required>
                                </div>

                                <div class="col-lg-3">
                                    <label for="">{{ __('Height') }}</label>
                                    <input type="number" class="form-control" name="comment[height]" id=""
                                         value="{{ $settings['comment']['height'] }}" required>
                                </div>

                                <div class="col-lg-2">
                                    <label for="report_header_text_align">{{__('Align')}}</label>
                                    <select class="form-control" name="comment[text-align]" id="" required>
                                      <option value="center" @if($settings['comment']['text-align']=='center') selected @endif>{{__('Center')}}</option>
                                      <option value="left" @if($settings['comment']['text-align']=='left') selected @endif>{{__('Left')}}</option>
                                      <option value="right" @if($settings['comment']['text-align']=='right') selected @endif>{{__('Right')}}</option>
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