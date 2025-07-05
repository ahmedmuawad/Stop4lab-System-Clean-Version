
    $('.test_components').append(`
            <tr id="component_` + count_component+ `" num="` + count_component+ `">
                <td><input type="text" class="form-control form-control-sm"
                        value="مكون"></td>
                <td><label class="new-control new-checkbox checkbox-primary">
                    <input type="checkbox" class="new-control-input" name="component[${count_component}][displayed]">
                    <span class="new-control-indicator"></span>Displayed</label>
                </td>

                <td><label class="new-control new-checkbox checkbox-primary">
                        <input type="checkbox" class="new-control-input" name="component[${count_component}][enabled]">
                        <span class="new-control-indicator"></span>Enabled</label>
                </td>
                <td><label class="new-control new-checkbox checkbox-primary">
                        <input type="checkbox" class="new-control-input" name="component[${count_component}][printed]">
                        <span class="new-control-indicator"></span>Printed</label>
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-sm mb-2 mr-2"
                        data-toggle="modal" data-target=".bd-example-modal-xl-${count_component}"><i
                            class="fa fa-edit"></i></button>
                    <button href="" class="btn btn-warning btn-sm mb-2 mr-2 delete_row" type="button">
                        <i class="fa fa-trash"></i></button>
                </td>
            </tr>
            `);

    $('#test_form').append(`

        <div class="modal fade bd-example-modal-xl-${count_component}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">Platelets Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">


                        <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="data-tab_${count_component}" data-toggle="tab" href="#data_${count_component}" role="tab"
                                    aria-controls="home" aria-selected="true">${trans('Details')}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ranges-tab_${count_component}" data-toggle="tab" href="#ranges_${count_component}" role="tab"
                                    aria-controls="contact" aria-selected="false">${ trans('Referance Ranges') }</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="mathematical-calculations-tab_${count_component}" data-toggle="tab"
                                    href="#mathematical-calculations_${count_component}" role="tab"
                                    aria-controls="mathematical-calculations"
                                    aria-selected="false">${ trans('Mathematical Calculations') }</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="simpletabContent_${count_component}">
                            <div class="tab-pane fade show active" id="data_${count_component}" role="tabpanel"
                                aria-labelledby="data-tab">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12">
                                        <label class="control-label">${ trans('Component Name') }</label>
                                        <input type="text" name="component[${count_component}][name]" class="form-control"
                                            value="  مكون Platelets Profile">
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12">
                                        <label class="control-label">${ trans('Unit') }</label>
                                        <div class="input-group">
                                            <input type="text" name="component[${count_component}][unit]" class="form-control" value="g/dl">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12">
                                        <input type="checkbox" id="Sererated" name="component[${count_component}][separated]">

                                        <label class="control-label">${ trans('Separated Price') }</label>
                                        <input type="text" name="component[${count_component}][price]" class="form-control">
                                    </div>

                                </div>

                            </div>
                            <div class="tab-pane fade" id="ranges_${count_component}" role="tabpanel" aria-labelledby="ranges-tab">
                                <button type="button" class="btn btn-warning btn-sm add_range">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <label class="new-control new-checkbox checkbox-primary">
                                    <input type="checkbox" class="new-control-input" name="component[${count_component}][status]">
                                    <span class="new-control-indicator"></span>Display in report</label>
                                </br>
                                <table class="table table-bordered components">
                                    <thead>
                                        <tr>
                                            <th width="10%">Gender</th>
                                            <th width="25%">age</th>
                                            <th width="25%">Input Type</th>
                                            <th width="12.5%">Normal</th>
                                            <th width="15%">Cretical L/H</th>
                                            <th width="15%">Max/Min</th>
                                            <th class="text-center" width="5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="reference_ranges">


                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="mathematical-calculations_${count_component}" role="tabpanel"
                                aria-labelledby="mathematical-calculations-tab">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                            Discard</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
            </div>
        </div>
    </div>

        `)
