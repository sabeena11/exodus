<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientsOverview;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClientsOverview;
use App\Http\Requests\UpdateClientsOverview;
use App\Helper\Reply;
use Yajra\DataTables\Facades\DataTables;
use App\Helper\Files;

class ClientsOverviewController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.clientsoverview');
        $this->pageIcon = 'icon-people';
    }

    public function index()
    {
        abort_if(! $this->user->cans('view_clientsoverview'), 403);
        $this->clientsoverview = ClientsOverview::all();
  
        return view('admin.clientsoverview.index', $this->data);

    }
    public function create()
    {
        abort_if(! $this->user->cans('add_clientsoverview'), 403);
    
        return view('admin.clientsoverview.create',$this->data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientsOverview $request)
    {
  

        $data = new ClientsOverview();
        $data->desc = $request->desc;
        $data->name =$request->name;
        $data->designation =$request->designation;
        $data->rating_star = $request->rating_star;
        
        if ($request->hasFile('image')) {
            $data->image = Files::uploadLocalOrS3($request->image,'clientsoverview');
        }
        
        $data->save();
        

        return Reply::redirect(route('admin.clientsoverview.index'), __('menu.clientsoverview').' '.__('messages.createdSuccessfully'));
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientsOverview  $clientsOverview
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        abort_if(! $this->user->cans('edit_clientsoverview'), 403);

        $this->clientsoverviewData = ClientsOverview::find($id);
     
        return view('admin.clientsoverview.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientsOverview $request, $id){
      

        $clientsoverview = ClientsOverview::find($id);
     
        $clientsoverview->desc = $request->desc;
        $clientsoverview->name =$request->name;
        $clientsoverview->designation =$request->designation;
        $clientsoverview->rating_star = $request->rating_star;

        if ($request->hasFile('image')) {
            $clientsoverview->image = Files::uploadLocalOrS3($request->image,'clientsoverview');
        }
    
        $clientsoverview->save();

    

        return Reply::redirect(route('admin.clientsoverview.index'), __('menu.clientsoverview').' '.__('app.messages.updatedSuccessfully'));
    }

    public function destroy($id)
    {
        // abort_if(! $this->user->cans('delete_user'), 403);
        abort_if(! $this->user->cans('delete_clientsoverview'), 403);

     ClientsOverview::destroy($id);
   
        return Reply::success(__('messages.recordDeleted'));
    }

    
   public function data()
   {

    $clientsoverviews = ClientsOverview::all();
       return DataTables::of($clientsoverviews)
              ->addColumn('action', function ($row) {
           // Actions for clientsoverviews
           $action = '<a href="' . route('admin.clientsoverview.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
               data-toggle="tooltip" onclick="this.blur()" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';

           $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
               data-toggle="tooltip" onclick="this.blur()" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';

           return $action;
       })

       ->rawColumns(['desc','name','designation
       ','rating_star','image','action'])
       ->addIndexColumn()
       ->make(true);

   }
}
