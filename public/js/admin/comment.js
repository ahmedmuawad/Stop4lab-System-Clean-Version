(function ($) {
    "use strict";
    //datatable
    table = $("#reports_table").DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, -1],
            [10, 25, 50, 100, 500, 1000, "All"],
        ],
        dom:
            "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        processing: true,
        serverSide: true,
        bSort: true,
        ajax: {
            url: url("admin/get_auto_comments"),
        },
        // orderCellsTop: true,
        fixedHeader: true,
        columns: [
            {
                data: "bulk_checkbox",
                searchable: false,
                sortable: false,
                orderable: false,
            },
            { data: "id", sortable: true, orderable: true },
            { data: "short_comment", sortable: true, orderable: true },
            { data: "comment", sortable: true, orderable: true },
            { data: "action", sortable: true, orderable: true },
        ],
        language: {
            sEmptyTable: trans("No data available in table"),
            sInfo:
                trans("Showing") +
                " _START_ " +
                trans("to") +
                " _END_ " +
                trans("of") +
                " _TOTAL_ " +
                trans("records"),
            sInfoEmpty:
                trans("Showing") +
                " 0 " +
                trans("to") +
                " 0 " +
                trans("of") +
                " 0 " +
                trans("records"),
            sInfoFiltered:
                "(" +
                trans("filtered") +
                " " +
                trans("from") +
                " _MAX_ " +
                trans("total") +
                " " +
                trans("records") +
                ")",
            sInfoPostFix: "",
            sInfoThousands: ",",
            sLengthMenu: trans("Show") + " _MENU_ " + trans("records"),
            sLoadingRecords: trans("Loading..."),
            sProcessing: trans("Processing..."),
            sSearch: trans("Search") + ":",
            sZeroRecords: trans("No matching records found"),
            oPaginate: {
                sFirst: trans("First"),
                sLast: trans("Last"),
                sNext: trans("Next"),
                sPrevious: trans("Previous"),
            },
        },
    });
    $("#add_comment").click(function () {
        let elements = $("#comments .coment-row");
        let lastId = $(elements[elements.length - 1]).data("row");
        var testSelect = "";
        $.ajax({
            url: "/admin/auto_comment/get_new_test_select",
            type: "get",
            success: function (res) {
                testSelect +=
                    '<select id="test" class="form-control" name="comments[' +
                    ++lastId +
                    '][test_id][]">';
                $.each(res.test.components, function (x, y) {
                    testSelect +=
                        '<option class="text-center" value="' +
                        y.id +
                        '">' +
                        y.name +
                        " </option>";
                });
                testSelect += "</select>";

                let operations = [
                    {
                        id: "1",
                        name: "Less Than",
                        operands: "1",
                    },
                    {
                        id: "2",
                        name: "Less Than or Equal",
                        operands: "1",
                    },
                    {
                        id: "3",
                        name: "greater Than",
                        operands: "1",
                    },
                    {
                        id: "4",
                        name: "greater Than or Equal",
                        operands: "1",
                    },
                    {
                        id: "5",
                        name: "between",
                        operands: "2",
                    },
                ];

                let conditions = [
                    {
                        id: "1",
                        name: "C.Low",
                    },
                    {
                        id: "2",
                        name: "Low",
                    },
                    {
                        id: "3",
                        name: "Normal",
                    },
                    {
                        id: "4",
                        name: "High",
                    },
                    {
                        id: "5",
                        name: "C.High",
                    },
                    {
                        id: "6",
                        name: "High Or C.High",
                    },
                    {
                        id: "7",
                        name: "Low Or C.Low",
                    },
                    {
                        id: "8",
                        name: "Abnormal",
                    },
                    {
                        id: "9",
                        name: "Panic",
                    },
                ];
                let content = ``;
                content += `
        <hr/>
        <div class="coment-row" data-row="${lastId}">
        <div class="col-lg-12 d-flex justify-content-center">
        <div class="form-group">
            <label class="form-label"
                 for="Values">${trans("above_op_type")}</label>
            <select class="form-control" name="comments[${lastId}][above_op_type]">
                <option selected value='or'>
                    ${trans("OR")}
                </option>

                <option value='and' selected>
                    ${trans("and")}
                </option>
            </select>

        </div>
    </div>
        <hr/>


        <div class="row">
        <div class="col-lg-4">
        <div class="form-group">
                    <label class="form-label" for="test">${trans(
                        "Test Name"
                    )}</label>
           ${testSelect}
           </div>

        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-label" for="operation">${trans(
                    "Opertion Name"
                )}</label>
                <select onchange="operationSelect(${lastId})"  class="form-control opertionSelect" name="comments[${lastId}][operations][id]">
                <option class="text-center">
                ${trans("No Selection")}
                </option>
                `;
                for (let i = 0; i < operations.length; i++) {
                    content += `<option data-operands="${operations[i].operands}" class="text-center" value="${operations[i].id}">
                            ${operations[i].name}
                            </option>`;
                }
                content += `
                </select>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-label" for="condition">${trans(
                    "condition"
                )}</label>
                <select class="form-control" name="comments[${lastId}][condition]">
                <option class="text-center">
                ${trans("No Selection")}
                </option>
                `;

                for (let i = 0; i < conditions.length; i++)
                    content += `<option value="${conditions[i].id}">
                            ${conditions[i].name}
                        </option>`;
                content += `</select>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-label" for="Values">${trans(
                    "Values"
                )}</label>
                <input type="text" class="form-control" name="comments[${lastId}][Values]">
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-label"
                     for="Values">${trans("Opration_Condition")}</label>
                <select class="form-control" name="comments[${lastId}][Opration_Condition]">
                    <option selected >
                        __
                    </option>
                    <option  value='or'>
                        ${trans("OR")}
                    </option>

                    <option value='and'>
                        ${trans("and")}
                    </option>
                </select>

            </div>
        </div>


        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-label"
                    for="Opration_Values">${trans("Opration_Values")}</label>
                <select class="form-control" name="comments[${lastId}][Opration_Values]">
                <option selected >
                __
            </option>
                <option  value='or'>
                        ${trans("OR")}
                    </option>

                    <option value='and'>
                        ${trans("and")}
                    </option>
                </select>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-label"
                    for="condition_Values">${trans("condition_Values")}</label>
                <select class="form-control" name="comments[${lastId}][condition_Values]">
                <option selected >
                __
            </option>
                <option  value='or'>
                        ${trans("OR")}
                    </option>

                    <option value='and'>
                        ${trans("and")}
                    </option>
                </select>
            </div>
        </div>
                </div>
         <div class="col-md-4">
        <button type="button" onClick="deleteCommentRow()" class="deleteCommentRow btn btn-danger my-2">Delete</button>
    </div>
    </div>


        `;
                $("#comments").append(content);
            },
            error: function (res) {
                console.log(res);
            },
        });
    });
    $(".deleteCommentRow").on("click", function () {
        //Delete

        $(this).parent().parent().remove();
    });
    $(".removePenlaity").on("click", function ($event) {
        // console.log("Hello world Console");
        let parent = $($($event.target).parent()).parent();
        console.log(parent.remove());
        console.log($event);
    });

    $(".ray_comment").summernote({
        height: 200,
    });

    $(".opertionSelect").on("change", operationSelect);

    $(document).on("click", ".delete_comment", function (e) {
        e.preventDefault();
        var el = $(this);
        swal(
            {
                title: trans("Are you sure to delete Comment ?"),
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: trans("Delete"),
                cancelButtonText: trans("Cancel"),
                closeOnConfirm: false,
            },
            function () {
                $(el).parent().submit();
            }
        );
    });
})(jQuery);
function remove() {
    let parent = $($(event.target).parent()).parent();
    parent.remove();
}

function deleteCommentRow() {
    $(event.target).parent().parent().remove();
    // $(event.target)
}

function operationSelect(i = 0) {
    // alert("Hello")
    let id = $(".opertionSelect");
    let row_index;
    let inputs;
    let operands;
    let row = 0;
    if (i == 0) {
        row_index = $($(this).parent()).parent();
        inputs = $($($(this).parent()).parent()).siblings(".values");

        row = $($($($($($(this).parent()).parent())).parent()).parent()).data(
            "row"
        );

        console.log(row);
        operands = $(this).find(":selected").data("operands");
    } else {
        console.log(event.target);
        row_index = $($(event.target).parent()).parent();
        console.log(row_index);
        row = $(
            $($($($($(event.target).parent()).parent())).parent()).parent()
        ).data("row");
        console.log(row);
        inputs = $($($(event.target).parent()).parent()).siblings(".values");
        operands = $(event.target).find(":selected").data("operands");
    }

    inputs.remove();
    let opertionValues = "";
    for (let i = 0; i < Number(operands); i++) {
        opertionValues += `
            <div class="col-lg-4 values">
            <label value="" id="comments['value_${i + 1}]">value_${
            i + 1
        }</label>
            <input class="form-control" type="number" name="comments[${row}][operations][values][]">
        </div>
        `;
    }
    $(opertionValues).insertAfter(row_index);
}
