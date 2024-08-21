<?php

namespace App\Http\Controllers\Admin;


use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\StoreSlider;
use App\Http\Requests\UpdateSlider;
use App\Models\Slider;
use Symfony\Component\HttpKernel\Tests\HttpCache\StoreTest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.sliders');
        $this->pageIcon = 'icon-people';
        
    }

    public function index(){
        abort_if(! $this->user->cans('view_sliders'), 403);

        $this->sliders = Slider::all();
    
        return view('admin.sliders.index', $this->data);
    }

    public function create(){
        abort_if(! $this->user->cans('add_sliders'), 403);

     $this->sliders = Slider::all();
        return view('admin.sliders.create', $this->data);
    }

    public function store(StoreSlider $request){
        
        abort_if(! $this->user->cans('add_sliders'), 403);

        $slider = new Slider();
        $slider->title = $request->title;
      

        $slider->desc = $request->desc;
  
        
 
        if ($request->hasFile('image')) {
            $slider->image = Files::uploadLocalOrS3($request->image,'sliders');
        }

        $slider->save();

      

        return Reply::redirect(route('admin.sliders.index'), __('menu.sliders').' '.__('messages.createdSuccessfully'));
    }

    public function edit($id){
        abort_if(! $this->user->cans('edit_sliders'), 403);
        $this->sliderData = Slider::find($id);
     
        return view('admin.sliders.edit', $this->data);
    }

    
    public function update(Updateslider $request, $id){
      

        $slider = Slider::find($id);
        $slider->title = $request->title;
        
        $slider->desc = $request->desc;
     
   
 

        if ($request->hasFile('image')) {
            $slider->image = Files::uploadLocalOrS3($request->image,'sliders');
        }/*else{
            Files::deleteFile($slider->image, 'profile');
           $slider->image = null;
        }*/

        $slider->save();

       


        return Reply::redirect(route('admin.sliders.index'), __('menu.sliders').' '.__('app.messages.updatedSuccessfully'));
    }


     public function destroy($id)
    {
        // abort_if(! $this->user->cans('delete_user'), 403);
        abort_if(! $this->user->cans('delete_sliders'), 403);

     Slider::destroy($id);
    

  
        return Reply::success(__('messages.recordDeleted'));
    }

   public function data()
    {

        $sliders = Slider::all();

        return DataTables::of($sliders)
               ->addColumn('action', function ($row) {
            // Actions for sliders
            $action = '<a href="' . route('admin.sliders.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                data-toggle="tooltip" onclick="this.blur()" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';

            $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                data-toggle="tooltip" onclick="this.blur()" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';

            return $action;
        })

        ->rawColumns([ 'image','title','desc','action'])
        ->addIndexColumn()
        ->make(true);

    }

}
