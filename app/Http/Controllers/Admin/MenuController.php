<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Http\Requests\StoreMenu;
use App\Http\Requests\UpdateMenu;
use Illuminate\Http\Request;
use App\Helper\Reply;
use Yajra\DataTables\Facades\DataTables;
use App\Helper\Files;


class MenuController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.menus');
        $this->pageIcon = 'icon-people';
    }

    public function index()
    {
        abort_if(! $this->user->cans('view_menu'), 403);
        $this->menus = Menu::all();
  
        return view('admin.menu.index', $this->data);

    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(! $this->user->cans('add_menu'), 403);
    
        return view('admin.menu.create',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenu $request)
    {
  

        $data = new Menu;
        $data->title = $request->title;
        $data->link = $request->link;
        $data->position = $request->position;
         $data->section = $request->section;
        $data->save();
        

        return Reply::redirect(route('admin.menu.index'), __('menu.menus').' '.__('messages.createdSuccessfully'));
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        abort_if(! $this->user->cans('edit_menu'), 403);

        $this->menuData = Menu::find($id);
     
        return view('admin.menu.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenu $request, $id){
      

        $menu = Menu::find($id);
     
        $menu->title = $request->title;
        $menu->link = $request->link;
        $menu->section = $request->section;
        $menu->position = $request->position;
    
        $menu->save();

    

        return Reply::redirect(route('admin.menu.index'), __('menu.menus').' '.__('app.messages.updatedSuccessfully'));
    }

    public function destroy($id)
    {
        // abort_if(! $this->user->cans('delete_user'), 403);
        abort_if(! $this->user->cans('delete_menu'), 403);

     Menu::destroy($id);
   
        return Reply::success(__('messages.recordDeleted'));
    }

    
   public function data()
   {

    $menus = Menu::all();

       return DataTables::of($menus)
              ->addColumn('action', function ($row) {
           // Actions for menus
           $action = '<a href="' . route('admin.menu.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
               data-toggle="tooltip" onclick="this.blur()" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';

           $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
               data-toggle="tooltip" onclick="this.blur()" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';

           return $action;
       })

       ->rawColumns(['title','link','position','section','action'])
       ->addIndexColumn()
       ->make(true);

   }
}
