<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\StoreOverview;
use App\Http\Requests\UpdateOverview;
use App\Models\Overview;
use Symfony\Component\HttpKernel\Tests\HttpCache\StoreTest;
use Yajra\DataTables\Facades\DataTables;


class OverviewController extends AdminBaseController
{
   public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.overviews');
        $this->pageIcon = 'icon-people';
        
    }

    public function index(){
        abort_if(! $this->user->cans('view_overviews'), 403);

        $this->overviews = Overview::all();
    
        return view('admin.overviews.index', $this->data);
    }

    public function create(){
        abort_if(! $this->user->cans('add_overviews'), 403);

     $this->overviews = Overview::all();
        return view('admin.overviews.create', $this->data);
    }

    public function store(StoreOverview $request){
        
        abort_if(! $this->user->cans('add_overviews'), 403);

        $Overview = new Overview();
    
      

        $Overview->desc = $request->desc;
  
        
 
        

        $Overview->save();

      

        return Reply::redirect(route('admin.overviews.index'), __('menu.overviews').' '.__('messages.createdSuccessfully'));
    }

    public function edit($id){
        abort_if(! $this->user->cans('edit_overviews'), 403);
        $this->overviewData = Overview::find($id);
     
        return view('admin.overviews.edit', $this->data);
    }

    
    public function update(UpdateOverview $request, $id){
      

        $overview = Overview::find($id);
     
        
        $overview->desc = $request->desc;
    

        $overview->save();

       


        return Reply::redirect(route('admin.overviews.index'), __('menu.overviews').' '.__('app.messages.updatedSuccessfully'));
    }


     public function destroy($id)
    {
        // abort_if(! $this->user->cans('delete_user'), 403);
        abort_if(! $this->user->cans('delete_overviews'), 403);

     Overview::destroy($id);
    

  
        return Reply::success(__('messages.recordDeleted'));
    }

   public function data()
    {

        $overviews = Overview::all();

        return DataTables::of($overviews)
               ->addColumn('action', function ($row) {
            // Actions for overviews
            $action = '<a href="' . route('admin.overviews.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                data-toggle="tooltip" onclick="this.blur()" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';

            $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                data-toggle="tooltip" onclick="this.blur()" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';

            return $action;
        })

        ->rawColumns([ 'desc','action'])
        ->addIndexColumn()
        ->make(true);

    }

}
