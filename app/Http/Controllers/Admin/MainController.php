<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use View;

class MainController extends Controller
{
    public function __construct()
    {
        View::share('route_params',$this->route_params);
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function destroy($id,$extra='')
    {
//        return $extra;
        $query_string=property_exists($this,'query_string') ? '&'.$this->query_string : '';
        $model_name=$this->model;
        $row=$model_name::withTrashed()->findOrFail($id);
        if($row->deleted_at==null){
            $message="$this->title  انتخاب شده به سطل زباله انتقال یافت";
            $row->delete();
        }
        else{
            $message="$this->title  انتخاب شده حذف شد";
            $row->forceDelete();
        }
        return redirect('admin/'.$this->route_params([$extra]).'?trashed=true'.$query_string)->with('message',$message);
    }
    public function destroy_items(Request $request)
    {
//        return $request->all();
        $query_string=property_exists($this,'query_string') ? '&'.$this->query_string : '';
        $model_name=$this->model;
        $param_name=$this->route_params.'_id';
        $ids=$request->get($param_name,array());
        foreach ($ids as $key=>$value)
        {
            $row=$model_name::withTrashed()->where('id',$value)->firstOrFail();
            if($row->deleted_at==null){
                $message="$this->title های انتخاب شده به سطل زباله انتقال یافت";
                $row->delete();
            }
            else{
                $message="$this->title های انتخاب شده حذف شد";
                $row->forceDelete();
            }
        }
        return redirect('admin/'.$this->route_params.'?trashed=true'.$query_string)->with('message',$message);
    }
    public function restore_items(Request $request)
    {
        $query_string=property_exists($this,'query_string') ? '&'.$this->query_string : '';
        $model_name=$this->model;
        $param_name=$this->route_params.'_id';
        $ids=$request->get($param_name,array());
        foreach ($ids as $key=>$value)
        {
            $row=$model_name::withTrashed()->where('id',$value)->firstOrFail();
            $row->restore();
        }
        return redirect('admin/'.$this->route_params.'?trashed=true'.$query_string)
            ->with('message',"بازیابی $this->title ها با موفقیت انجام شد");
    }
    public function restore($id,$extra1='')
    {
        $query_string=property_exists($this,'query_string') ? '&'.$this->query_string : '';
        $model_name=$this->model;
        $row=$model_name::withTrashed()->where('id',$id)->firstOrFail();
        $row->restore();
        return redirect('admin/'.$this->route_params([$extra1]).'?trashed=true'.$query_string)->with('message',"بازیابی $this->title  با موفقیت انجام شد");
    }


}
