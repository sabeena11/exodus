<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\StoreSliderCard;
use App\Http\Requests\UpdateSliderCard;
use App\Models\SliderCard;
use Symfony\Component\HttpKernel\Tests\HttpCache\StoreTest;
use Yajra\DataTables\Facades\DataTables;


class SliderCardController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.slidercards');
        $this->pageIcon = 'icon-people';
        
    }

    public function index(){
        abort_if(! $this->user->cans('view_slidercards'), 403);

        $this->slidercards = SliderCard::all();
    
        return view('admin.slidercards.index', $this->data);
    }

    public function create(){
        abort_if(! $this->user->cans('add_slidercards'), 403);

     $this->slidercards = SliderCard::all();
        return view('admin.slidercards.create', $this->data);
    }

    public function store(StoreSliderCard $request){
        
        abort_if(! $this->user->cans('add_slidercards'), 403);

        $slidercards = new SliderCard();
        $slidercards->title = $request->title;
         $slidercards->icon = $request->icon;

        $slidercards->desc = $request->desc;
  
        
 
      

        $slidercards->save();

      

        return Reply::redirect(route('admin.slidercards.index'), __('menu.slidercards').' '.__('messages.createdSuccessfully'));
    }

    public function edit($id){
        abort_if(! $this->user->cans('edit_slidercards'), 403);

        $this->slidercardData = SliderCard::find($id);
     
        return view('admin.slidercards.edit', $this->data);
    }

    
    public function update(UpdatesliderCard $request, $id){
      

        $slidercards = SliderCard::find($id);
        $slidercards->title = $request->title;
        $slidercards->icon = $request->icon;
        $slidercards->desc = $request->desc;
     
   
 

     

        $slidercards->save();

       


        return Reply::redirect(route('admin.slidercards.index'), __('menu.slidercards').' '.__('app.messages.updatedSuccessfully'));
    }


     public function destroy($id)
    {
        
        // abort_if(! $this->user->cans('delete_user'), 403);
    abort_if(! $this->user->cans('delete_slidercards'), 403);

     SliderCard::destroy($id);
    

  
        return Reply::success(__('messages.recordDeleted'));
    }

   public function data()
    {

        $slidercards = SliderCard::all();

        return DataTables::of($slidercards)
               ->addColumn('action', function ($row) {
            // Actions for slidercards
            $action = '<a href="' . route('admin.slidercards.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                data-toggle="tooltip" onclick="this.blur()" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';

            $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                data-toggle="tooltip" onclick="this.blur()" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';

            return $action;
        })

        ->rawColumns([ 'title','icon','desc','action'])
        ->addIndexColumn()
        ->make(true);

    }

}
