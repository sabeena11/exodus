<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\StoreFeature;
use App\Http\Requests\UpdateFeature;
use App\Models\Feature;
use Symfony\Component\HttpKernel\Tests\HttpCache\StoreTest;
use Yajra\DataTables\Facades\DataTables;

class FeatureController extends AdminBaseController
{
     public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.features');
        $this->pageIcon = 'icon-people';
        
    }

    public function index(){
        abort_if(! $this->user->cans('view_features'), 403);

        $this->features = Feature::all();
    
        return view('admin.features.index', $this->data);
    }

    public function create(){
        abort_if(! $this->user->cans('add_features'), 403);

     $this->features = Feature::all();
        return view('admin.features.create', $this->data);
    }

    public function store(StoreFeature $request){
        
        abort_if(! $this->user->cans('add_features'), 403);

        $feature = new Feature();
    
      

        $feature->title = $request->title;
        $feature->icon = $request->icon;
        
 
        

        $feature->save();

      

        return Reply::redirect(route('admin.features.index'), __('menu.features').' '.__('messages.createdSuccessfully'));
    }

    public function edit($id){
        abort_if(! $this->user->cans('edit_features'), 403);
        $this->featureData = Feature::find($id);
     
        return view('admin.features.edit', $this->data);
    }

    
    public function update(UpdateFeature $request, $id){
      

          $feature = Feature::find($id);
     
        
      $feature->title = $request->title;
        $feature->icon = $request->icon;
        
    

       $feature->save();

       


        return Reply::redirect(route('admin.features.index'), __('menu.features').' '.__('app.messages.updatedSuccessfully'));
    }


     public function destroy($id)
    {
        // abort_if(! $this->user->cans('delete_user'), 403);
        abort_if(! $this->user->cans('delete_features'), 403);

     Feature::destroy($id);
    

  
        return Reply::success(__('messages.recordDeleted'));
    }

   public function data()
    {

        $features = Feature::all();

        return DataTables::of($features)
               ->addColumn('action', function ($row) {
            // Actions for features
            $action = '<a href="' . route('admin.features.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                data-toggle="tooltip" onclick="this.blur()" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';

            $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                data-toggle="tooltip" onclick="this.blur()" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';

            return $action;
        })

        ->rawColumns([ 'title','icon','action'])
        ->addIndexColumn()
        ->make(true);

    }

}