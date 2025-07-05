<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\AutoComment;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Test;
use App\Models\Operation;
use App\Models\Condition;
use App\Models\CommentOperation;
use App\Models\commentComponet;
use Session;
use Illuminate\Support\HtmlString;
use Config;
use Illuminate\Support\Facades\DB;

class AutoCommentController extends Controller
{
    public function index($id)
    {
        Session::put('id', $id);

        return view('admin.Auto_Comment.index');
    }

    public function ajax(Request $request)
    {
        $id = Session::get('id');
        $condiotns = Config::get('conditions');
        $model = AutoComment::query()->where('test_id', $id);
        Log::Info($model->get());
        return DataTables::eloquent($model)
            ->addColumn('action', function ($comment) {
                return view('admin.Auto_Comment._action', compact('comment'));
            })

            ->addColumn('test_id', function (AutoComment $comment) {
                return $comment->id;
            })


            ->editColumn('comment', function (AutoComment $comment) {
                return view('partials.parsehtml', compact('comment'));
            })

            ->addColumn('bulk_checkbox', function ($item) {
                return view('partials._bulk_checkbox', compact('item'));
            })
            ->toJson();
    }

    public function create()
    {
        $id = Session::get('id');
        $test = Test::where('id', $id)->with('components')->first();
        $operations = Operation::all();
        $conditions = Condition::all();
        return view('admin.Auto_Comment.create')->with(['test' => $test, 'operations' => $operations, 'conditions' => $conditions]);
    }

    public function store(Request $request)
    {

        // return $request;
        $index = 0;
        $tests_ids = $request['comments'][0]['test_id'];
        $id = Session::get('id');
        //
        // return $request;
        $Inertedcomment = null;
        if ($request->has('comment')) {
            $Inertedcomment = AutoComment::create([
                'comment' => $request->comment,
                'short_comment' => $request->short_comment,
                "test_id" => $id,
            ]);
        }
        $unique = uniqid();
        foreach ($request['comments'] as $comment) {
            if (isset($comment['operations']) && $comment['operations'] != null) {
                $inseredComment = commentComponet::create([
                    'test_id' => $id,
                    "component_id" => $comment['test_id'][0],
                    "comment_id" => $Inertedcomment->id,
                    "condition_id" => $comment['condition'] == '__' ? null : $comment['condition'],
                    "operation_condition_type" => $comment['Opration_Condition'] != '__' ? $comment['Opration_Condition'] : null,
                    "condition_values_type" => $comment['condition_Values'] != '__' ? $comment['condition_Values'] : null,
                    "operation_values_type" => $comment['Opration_Values'] != '__' ? $comment['Opration_Values'] : null,
                    "values" => $comment['Values'],
                    "above_op_type" => isset($comment['above_op_type']) ? $comment['above_op_type'] : null,
                    'unique' =>  count($request['comments']) > 1 ? $unique : null,
                ]);

                CommentOperation::create([
                    'test_id' => $comment['test_id'][0],
                    "comment_id" => $Inertedcomment->id,
                    'operation_id' => $comment['operations']['id'],
                    'value1' => isset($comment['operations']['values']) && count($comment['operations']['values']) > 0 ? $comment['operations']['values'][0] : '',
                    'value2' => isset($comment['operations']['values']) && count($comment['operations']['values']) > 1 ? $comment['operations']['values'][1] : '',
                ]);
            }
            $index++;
        }

        $commentComponet = commentComponet::where('comment_id', $Inertedcomment->id)->with('operationComments', 'comment')->get();

        $end_condiotn = ''; //here we will start add condtions ☺
        foreach ($commentComponet as $comment_Componet) {
            if ($comment_Componet->unique == null) {
                $update_AutoComment = AutoComment::find($Inertedcomment->id);
                $operation = '';

                //operations
                switch ($comment_Componet->operationComments['operation_id']) {
                    case 1:
                        $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] <' . $update_AutoComment->operationComments['value1'];
                        break;
                    case 2:
                        $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] <=' . $update_AutoComment->operationComments['value1'];
                        break;
                    case 3:
                        $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] >' . $update_AutoComment->operationComments['value1'];
                        break;
                    case 4:
                        $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] >=' . $update_AutoComment->operationComments['value1'];
                        break;
                    case 5:
                        $operation = '($data[' . $comment_Componet->component_id . ']["' . "values" . '"] >' . $update_AutoComment->operationComments['value1'] . '&& $data[' . $comment_Componet->component_id . ']["' . "values" . '"] <' . $update_AutoComment->operationComments['value2'] . ')';
                        break;
                    default:
                        $operation = '';
                        break;
                }
                $end_condiotn .= $operation;
                //return $operation;

                //condetion 1
                //operation_condition_type
                switch ($comment_Componet['condition_id']) {
                    case 1:
                        $condition_text = '"C.Low"';
                        break;
                    case 2:
                        $condition_text = '"Low"';
                        break;
                    case 3:
                        $condition_text = '"Normal"';
                        break;
                    case 4:
                        $condition_text = '"High"';
                        break;
                    case 5:
                        $condition_text = '"C.High"';
                        break;
                    case 6:
                        $condition_text = '"High"';
                        break;
                    case 7:
                        $condition_text = '"Low"';
                        break;
                    case 8:
                        $condition_text = '"Abnormal"';
                        break;
                    case 9:
                        $condition_text = '"Panic"';
                        break;
                    default:
                        $condition_text = '';
                        break;
                }
                $condiotn1 = '';
                if ($condition_text != '') {
                    if ($update_AutoComment->operationComments['value1'] != null) {
                        if ($comment_Componet->operation_condition_type == 'and') {
                            $condiotn1 = '&& $data[' . $comment_Componet->component_id . ']["' . "status" . '"] ==' . $condition_text;
                        } else {
                            $condiotn1 = '|| $data[' . $comment_Componet->component_id . ']["' . "status" . '"] ==' . $condition_text;
                        }
                    } else {
                        $condiotn1 = '$data[' . $comment_Componet->component_id . ']["' . "status" . '"] ==' . $condition_text;
                    }
                } else {
                    $condiotn1 = '';
                }
                $end_condiotn .= $condiotn1;
                //return $condiotn1;

                //condetion 2
                //operation_values_type
                $condiotn2 = '';
                if ($comment_Componet->values != null) {
                    if ($update_AutoComment->operationComments['value1'] != null) {
                        if ($comment_Componet->operation_values_type == 'and') {
                            $condiotn2 = '&& $data[' . $comment_Componet->component_id . ']["' . "values" . '"] == "' . $comment_Componet->values . '"';
                        } else {
                            $condiotn2 = '|| $data[' . $comment_Componet->component_id . ']["' . "values" . '"] == "' . $comment_Componet->values . '"';
                        }
                    } else {
                        $condiotn2 = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] == "' . $comment_Componet->values . '"';
                    }
                } else {
                    $condiotn2 = '';
                }
                $end_condiotn .= $condiotn2;
                // $data[4]["values"] <=10|| $data[4]["status"] =="Low"|| $data[4]["values"] == "Absent"
                $end_condiotn = 'if(' . $end_condiotn. ' ){
                    array_push($comments,"' . $update_AutoComment->comment . '");
                }';
                $update_AutoComment->condetion = $end_condiotn;
                $update_AutoComment->save();

            } else {
                $multi_comment_Componet = commentComponet::where("unique", $unique)->with('operationComments', 'comment')->orderBy("above_op_type", "desc")->orderBy("component_id", "desc")->get();
                $operation = '';
                //operations
                $end_condiotn = 'if(';
                // return $multi_comment_Componet;
                foreach ($multi_comment_Componet as $comment_Componet) {
                    $update_AutoComment = AutoComment::find($Inertedcomment->id);
                    $sub_end_condiotn = '';

                    $operation = '';
                    //operations
                    switch ($comment_Componet->operationComments['operation_id']) {
                        case 1:
                            $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] <' . $comment_Componet->operationComments['value1'];
                            break;
                        case 2:
                            $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] <=' . $comment_Componet->operationComments['value1'];
                            break;
                        case 3:
                            $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] >' . $comment_Componet->operationComments['value1'];
                            break;
                        case 4:
                            $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] >=' . $comment_Componet->operationComments['value1'];
                            break;
                        case 5:
                            $operation = '($data[' . $comment_Componet->component_id . ']["' . "values" . '"] >' . $comment_Componet->operationComments['value1'] . '&& $data[' . $comment_Componet->component_id . ']["' . "values" . '"] <' . $comment_Componet->operationComments['value2'] . ')';
                            // return $operation;
                            break;
                        default:
                            $operation = '';
                            break;
                    }
                    $sub_end_condiotn .= $operation;
                    // ($data[6]["values"] >1&& $data[6]["values"] <10)
                    //return $operation;
                    // ($data[6]["values"] >1&& $data[6]["values"] <10)
                    //condetion 1
                    //operation_condition_type
                    switch ($comment_Componet['condition_id']) {
                        case 1:
                            $condition_text = '"C.Low"';
                            break;
                        case 2:
                            $condition_text = '"Low"';
                            break;
                        case 3:
                            $condition_text = '"Normal"';
                            break;
                        case 4:
                            $condition_text = '"High"';
                            break;
                        case 5:
                            $condition_text = '"C.High"';
                            break;
                        case 6:
                            $condition_text = '"High"';
                            break;
                        case 7:
                            $condition_text = '"Low"';
                            break;
                        case 8:
                            $condition_text = '"Abnormal"';
                            break;
                        case 9:
                            $condition_text = '"Panic"';
                            break;
                        default:
                            $condition_text = '';
                            break;
                    }
                    $condiotn1 = '';
                    if ($condition_text != '') {
                        if ($update_AutoComment->operationComments['value1'] != null) {
                            if ($comment_Componet->operation_condition_type == 'and') {
                                $condiotn1 = '&& $data[' . $comment_Componet->component_id . ']["' . "status" . '"] ==' . $condition_text;
                            } else {
                                $condiotn1 = '|| $data[' . $comment_Componet->component_id . ']["' . "status" . '"] ==' . $condition_text;
                            }
                        } else {
                            $condiotn1 = '$data[' . $comment_Componet->component_id . ']["' . "status" . '"] ==' . $condition_text;
                        }
                    } else {
                        $condiotn1 = '';
                    }
                    $sub_end_condiotn .= $condiotn1;
                    //return $condiotn1;

                    //condetion 2
                    //operation_values_type
                    $condiotn2 = '';
                    if ($comment_Componet->values != null) {
                        if ($update_AutoComment->operationComments['value1'] != null) {
                            if ($comment_Componet->operation_values_type == 'and') {
                                $condiotn2 = '&& $data[' . $comment_Componet->component_id . ']["' . "values" . '"] == "' . $comment_Componet->values . '"';
                            } else {
                                $condiotn2 = '|| $data[' . $comment_Componet->component_id . ']["' . "values" . '"] == "' . $comment_Componet->values . '"';
                            }
                        } else {
                            $condiotn2 = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] == "' . $comment_Componet->values . '"';
                        }
                    } else {
                        $condiotn2 = '';
                    }
                    $sub_end_condiotn .= $condiotn2;

                    if ($comment_Componet->above_op_type == "and") {
                        $cndi = '&&';
                    } elseif ($comment_Componet->above_op_type == "or") {
                        $cndi = '||';
                    } else {
                        $cndi = '';
                    }

                    // return $condiotn;
                    $end_condiotn .= '(' . $sub_end_condiotn . ')' . $cndi;
                }
                $end_condiotn .=  ')                {
                    array_push($comments,"' . $update_AutoComment->comment . '");
                }';
                $update_AutoComment->condetion = $end_condiotn;
                $update_AutoComment->save();
                // return $end_condiotn;

            }
        }
        return  redirect()->route('admin.autoComments.index', [$id]);
    }

    public function edit(Request $request, $id)
    {
        $comment = commentComponet::where('comment_id', $id)->with('test', 'comment')->get();
        $coms = CommentOperation::where("comment_id",$id)->get();
        // return $comment;
        foreach($coms  as $key=>$com_oper){
            foreach($comment  as $key_com=>$val_com){
                if($com_oper->test_id == $val_com['test']['id']){
                    $comment[$key]['operationComments'] = $com_oper;
                }
            }
        }
        // $comment[0]['operationComments'] = CommentOperation::where("comment_id",$id)->first();
        // return $comment;
        $operations = Operation::all();
        $conditions = Condition::all();
        $test = Test::where('id', $comment[0]->test_id)->with('components')->first();
        return view('admin.Auto_Comment.edit')->with(['comment' => $comment, 'test' => $test, 'operations' => $operations, 'conditions' => $conditions]);
    }
    public function update(Request $request, $id)
    {
        $test_id = Session::get('id');
        $comment = commentComponet::where('comment_id', $id)->delete();
        if ($comment) {
            CommentOperation::where('comment_id', $id)->delete();
            AutoComment::where('id', $id)->delete();
            // return "aaa";
        }
        $index = 0;
        $tests_ids = $request['comments'][0]['test_id'];
        $id = Session::get('id');
        //
        // return $request;
        $Inertedcomment = null;
        if ($request->has('comment')) {
            $Inertedcomment = AutoComment::create([
                'comment' => $request->comment,
                'short_comment' => $request->short_comment,
                "test_id" => $id,
            ]);
        }
        $unique = uniqid();
        foreach ($request['comments'] as $comment) {
            if (isset($comment['operations']) && $comment['operations'] != null) {
                $inseredComment = commentComponet::create([
                    'test_id' => $id,
                    "component_id" => $comment['test_id'][0],
                    "comment_id" => $Inertedcomment->id,
                    "condition_id" => $comment['condition'] == '__' ? null : $comment['condition'],
                    "operation_condition_type" => $comment['Opration_Condition'] != '__' ? $comment['Opration_Condition'] : null,
                    "condition_values_type" => $comment['condition_Values'] != '__' ? $comment['condition_Values'] : null,
                    "operation_values_type" => $comment['Opration_Values'] != '__' ? $comment['Opration_Values'] : null,
                    "values" => $comment['Values'],
                    "above_op_type" => isset($comment['above_op_type']) ? $comment['above_op_type'] : null,
                    'unique' =>  count($request['comments']) > 1 ? $unique : null,
                ]);

                CommentOperation::create([
                    'test_id' => $comment['test_id'][0],
                    "comment_id" => $Inertedcomment->id,
                    'operation_id' => $comment['operations']['id'],
                    'value1' => isset($comment['operations']['values']) && count($comment['operations']['values']) > 0 ? $comment['operations']['values'][0] : '',
                    'value2' => isset($comment['operations']['values']) && count($comment['operations']['values']) > 1 ? $comment['operations']['values'][1] : '',
                ]);
            }
            $index++;
        }

        $commentComponet = commentComponet::where('comment_id', $Inertedcomment->id)->with('operationComments', 'comment')->get();

        $end_condiotn = ''; //here we will start add condtions ☺
        foreach ($commentComponet as $comment_Componet) {
            if ($comment_Componet->unique == null) {
                $update_AutoComment = AutoComment::find($Inertedcomment->id);
                $operation = '';

                //operations
                switch ($comment_Componet->operationComments['operation_id']) {
                    case 1:
                        $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] <' . $update_AutoComment->operationComments['value1'];
                        break;
                    case 2:
                        $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] <=' . $update_AutoComment->operationComments['value1'];
                        break;
                    case 3:
                        $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] >' . $update_AutoComment->operationComments['value1'];
                        break;
                    case 4:
                        $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] >=' . $update_AutoComment->operationComments['value1'];
                        break;
                    case 5:
                        $operation = '($data[' . $comment_Componet->component_id . ']["' . "values" . '"] >' . $update_AutoComment->operationComments['value1'] . '&& $data[' . $comment_Componet->component_id . ']["' . "values" . '"] <' . $update_AutoComment->operationComments['value2'] . ')';
                        break;
                    default:
                        $operation = '';
                        break;
                }
                $end_condiotn .= $operation;
                //return $operation;

                //condetion 1
                //operation_condition_type
                switch ($comment_Componet['condition_id']) {
                    case 1:
                        $condition_text = '"C.Low"';
                        break;
                    case 2:
                        $condition_text = '"Low"';
                        break;
                    case 3:
                        $condition_text = '"Normal"';
                        break;
                    case 4:
                        $condition_text = '"High"';
                        break;
                    case 5:
                        $condition_text = '"C.High"';
                        break;
                    case 6:
                        $condition_text = '"High"';
                        break;
                    case 7:
                        $condition_text = '"Low"';
                        break;
                    case 8:
                        $condition_text = '"Abnormal"';
                        break;
                    case 9:
                        $condition_text = '"Panic"';
                        break;
                    default:
                        $condition_text = '';
                        break;
                }
                $condiotn1 = '';
                if ($condition_text != '') {
                    if ($update_AutoComment->operationComments['value1'] != null) {
                        if ($comment_Componet->operation_condition_type == 'and') {
                            $condiotn1 = '&& $data[' . $comment_Componet->component_id . ']["' . "status" . '"] ==' . $condition_text;
                        } else {
                            $condiotn1 = '|| $data[' . $comment_Componet->component_id . ']["' . "status" . '"] ==' . $condition_text;
                        }
                    } else {
                        $condiotn1 = '$data[' . $comment_Componet->component_id . ']["' . "status" . '"] ==' . $condition_text;
                    }
                } else {
                    $condiotn1 = '';
                }
                $end_condiotn .= $condiotn1;
                //return $condiotn1;

                //condetion 2
                //operation_values_type
                $condiotn2 = '';
                if ($comment_Componet->values != null) {
                    if ($update_AutoComment->operationComments['value1'] != null) {
                        if ($comment_Componet->operation_values_type == 'and') {
                            $condiotn2 = '&& $data[' . $comment_Componet->component_id . ']["' . "values" . '"] == "' . $comment_Componet->values . '"';
                        } else {
                            $condiotn2 = '|| $data[' . $comment_Componet->component_id . ']["' . "values" . '"] == "' . $comment_Componet->values . '"';
                        }
                    } else {
                        $condiotn2 = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] == "' . $comment_Componet->values . '"';
                    }
                } else {
                    $condiotn2 = '';
                }
                $end_condiotn .= $condiotn2;
                // $data[4]["values"] <=10|| $data[4]["status"] =="Low"|| $data[4]["values"] == "Absent"
                $end_condiotn = 'if(' . $end_condiotn. ' ){
                    array_push($comments,"' . $update_AutoComment->comment . '");
                }';
                $update_AutoComment->condetion = $end_condiotn;
                $update_AutoComment->save();

            } else {
                $multi_comment_Componet = commentComponet::where("unique", $unique)->with('operationComments', 'comment')->orderBy("above_op_type", "desc")->orderBy("component_id", "desc")->get();
                $operation = '';
                //operations
                $end_condiotn = 'if(';
                // return $multi_comment_Componet;
                foreach ($multi_comment_Componet as $comment_Componet) {
                    $update_AutoComment = AutoComment::find($Inertedcomment->id);
                    $sub_end_condiotn = '';

                    $operation = '';
                    //operations
                    switch ($comment_Componet->operationComments['operation_id']) {
                        case 1:
                            $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] <' . $comment_Componet->operationComments['value1'];
                            break;
                        case 2:
                            $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] <=' . $comment_Componet->operationComments['value1'];
                            break;
                        case 3:
                            $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] >' . $comment_Componet->operationComments['value1'];
                            break;
                        case 4:
                            $operation = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] >=' . $comment_Componet->operationComments['value1'];
                            break;
                        case 5:
                            $operation = '($data[' . $comment_Componet->component_id . ']["' . "values" . '"] >' . $comment_Componet->operationComments['value1'] . '&& $data[' . $comment_Componet->component_id . ']["' . "values" . '"] <' . $comment_Componet->operationComments['value2'] . ')';
                            // return $operation;
                            break;
                        default:
                            $operation = '';
                            break;
                    }
                    $sub_end_condiotn .= $operation;
                    // ($data[6]["values"] >1&& $data[6]["values"] <10)
                    //return $operation;
                    // ($data[6]["values"] >1&& $data[6]["values"] <10)
                    //condetion 1
                    //operation_condition_type
                    switch ($comment_Componet['condition_id']) {
                        case 1:
                            $condition_text = '"C.Low"';
                            break;
                        case 2:
                            $condition_text = '"Low"';
                            break;
                        case 3:
                            $condition_text = '"Normal"';
                            break;
                        case 4:
                            $condition_text = '"High"';
                            break;
                        case 5:
                            $condition_text = '"C.High"';
                            break;
                        case 6:
                            $condition_text = '"High"';
                            break;
                        case 7:
                            $condition_text = '"Low"';
                            break;
                        case 8:
                            $condition_text = '"Abnormal"';
                            break;
                        case 9:
                            $condition_text = '"Panic"';
                            break;
                        default:
                            $condition_text = '';
                            break;
                    }
                    $condiotn1 = '';
                    if ($condition_text != '') {
                        if ($comment_Componet->operationComments['value1'] != null) {
                            if ($comment_Componet->operation_condition_type == 'and') {
                                $condiotn1 = '&& $data[' . $comment_Componet->component_id . ']["' . "status" . '"] ==' . $condition_text;
                            } else {
                                $condiotn1 = '|| $data[' . $comment_Componet->component_id . ']["' . "status" . '"] ==' . $condition_text;
                            }
                        } else {
                            $condiotn1 = '$data[' . $comment_Componet->component_id . ']["' . "status" . '"] ==' . $condition_text;
                        }
                    } else {
                        $condiotn1 = '';
                    }
                    $sub_end_condiotn .= $condiotn1;
                    //return $condiotn1;

                    //condetion 2
                    //operation_values_type
                    $condiotn2 = '';
                    if ($comment_Componet->values != null) {
                        if ($comment_Componet->operationComments['value1'] != null) {
                            if ($comment_Componet->operation_values_type == 'and') {
                                $condiotn2 = '&& $data[' . $comment_Componet->component_id . ']["' . "values" . '"] == "' . $comment_Componet->values . '"';
                            } else {
                                $condiotn2 = '|| $data[' . $comment_Componet->component_id . ']["' . "values" . '"] == "' . $comment_Componet->values . '"';
                            }
                        } else {
                            $condiotn2 = '$data[' . $comment_Componet->component_id . ']["' . "values" . '"] == "' . $comment_Componet->values . '"';
                        }
                    } else {
                        $condiotn2 = '';
                    }
                    $sub_end_condiotn .= $condiotn2;

                    if ($comment_Componet->above_op_type == "and") {
                        $cndi = '&&';
                    } elseif ($comment_Componet->above_op_type == "or") {
                        $cndi = '||';
                    } else {
                        $cndi = '';
                    }

                    // return $condiotn;
                    $end_condiotn .= '(' . $sub_end_condiotn . ')' . $cndi;
                }
                $end_condiotn .=  ')                {
                    array_push($comments,"' . $update_AutoComment->comment . '");
                }';
                $update_AutoComment->condetion = $end_condiotn;
                $update_AutoComment->save();
                // return $end_condiotn;

            }
        }

        return  redirect()->route('admin.autoComments.index', [$test_id]);
    }


    public function destroy(Request $request, $id, $comp_id)
    {
        $test_id = Session::get('id');
        $comment = commentComponet::where('comment_id', $id)->delete();
        if ($comment) {
            CommentOperation::where('comment_id', $id)->delete();
            AutoComment::where('id', $id)->delete();
        }
        return  redirect()->route('admin.autoComments.index', [$test_id]);
    }
    public function bulk_delete(Request $request)
    {
        // return $request;

        $test_id = Session::get('id');
        foreach ($request['ids'] as $id) {
            $comment = commentComponet::where('comment_id', $id)->delete();
            CommentOperation::where('comment_id', $id)->delete();
            AutoComment::where('id', $id)->delete();
        }
        // return $comment;

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->back();
    }
    public function show($id)
    {
        // dd($id);
        $comment = commentComponet::query()->where('comment_id', $id)->with('test', 'operationComments', 'comment')->get();
        // return $comment;
        // dd($comment[2]->operationComments);
        return view('admin.Auto_Comment.details')->with(['comment' => $comment]);
    }
    public function update_single_comment(Request $request, $id)
    {
        // dd($id);
        $comment = AutoComment::find($id);
        $comment->comment = $request->comment;
        $comment->save();
        return redirect()->back();
    }
    public function get_new_test_select()
    {
        $id = Session::get('id');
        $test = Test::where('id', $id)->with('components')->first();
        $operations = Operation::all();
        $conditions = Condition::all();
        // return "Aaaaaaaaaa";
        return response()->json(
            [
                'test' => $test,
                'operations' => $operations,
                'conditions' => $conditions,
            ]
        );
    }
}
