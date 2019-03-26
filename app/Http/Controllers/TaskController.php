<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Task;
use App\Category;
use Alert;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexT()
    {
        $task = Task::all();
        $cats = Category::all();
        return view('task', ["cats" => $cats,'task'=>$task]);

    }
    public function index()
    {

        $cats = Category::all();
        if (!empty($_GET['category'])){
            $currentCategory = Category::where('id', $_GET['category'])->first();
            //task is a function from Category model
            $currentTask = $currentCategory->task ?? null;
        }
        return view('task', ["cats" => $cats,'task'=>$currentTask ?? null, 'current_category'=>$currentCategory ?? null]);

    }

    // public function index()
    // {
    //     $cats = Category::all();
    //     return view('task', ["cats" => $cats]);

    // }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeCat(Request $request)
    {
        $request->validate([
            'category'=>'required|string',


        ]);

        $cats = new Category();
        $cats->id = $request->id;
        $cats->name= $request->category;

        $cats->save();
        Alert::Success('Success Message','Category saved Successfully');
            return back();
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'taskname'=>'required|string',
            'category'=>'required|string'


        ]);
        $task = new Task();
        $task->name= $request->taskname;
        $task->category_id = $request->category;
        $task->save();    
        Alert::Success('Success Message','Task saved Successfully');

            return back();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $task = Task::all();
        return view("task",["task"=>$task]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
      
    }

    public function checkFunction(Request $request)
    {
        

        $task = Task::findOrFail($request->taskId);


        if($task->completed == 0)
        {
            $task->completed  = 1;
            $task->save();
        }
        else
        {
            $task->completed = 0;
            $task->save();

        }

        return $task;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
            $task = Task::find($id);
            $task-> delete();
            Alert::Success('Success Message','Task Deleted Successfully');

                return back();
         
    
        
    }

}
