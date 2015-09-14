<?php

namespace Neyko\Admin\Http\Controller;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdminController extends BaseController {

    public function dashboard()
    {
    	$data['logs']=\Neyko\Admin\Model\AdminLog::orderBy("created_at","DESC")->get();
        $data['module']=\Neyko\Admin\Model\AdminModule::where("name","=","dashboard")->first();
        $data['action']="Home";
        $data['page']='list';
    	$data['administrator']=\Neyko\Admin\Model\Administrator::find(\Session::get("admin"));
        return view("admin::dashboard",$data);
    }

    public function showList($module)
    {

    	$data['module']=\Neyko\Admin\Model\AdminModule::where("name","=",$module)->first();
    	$settings=\Config::get("admin.".$data['module']->name);

    	$data['settings']=$settings['list'];
        $data['action']=\Lang::get("admin::templates.37");
    	$model=$data['module']->model;
        if(isset($settings['single'])){
            $single=$model::first();
            return $this->showEdit($module,$single->id);
        }
        else{
            $data['data']=$model::all();
            $data['add']=true;
            $data['page']='list';
            $data['administrator']=\Neyko\Admin\Model\Administrator::find(\Session::get("admin"));
            return \View::make("admin::list",$data);
        }
    }

    public function showEdit($module,$id){
    	$data['module']=\Neyko\Admin\Model\AdminModule::where("name","=",$module)->first();
    	$settings=\Config::get("admin.".$data['module']->name);
        $data['action']=\Lang::get("admin::templates.39");
    	$model=$data['module']->model;
    	$data['item']=$model::find($id);
        $form=$this->createForm($settings['form'],$data['item']);
        $data['settings']=$form;
    	$data['administrator']=\Neyko\Admin\Model\Administrator::find(\Session::get("admin"));
    	$data['edit']=true;
        $data['page']='form';
        return \View::make("admin::form",$data);
    }

    public function showNew($module){
        $data['module']=\Neyko\Admin\Model\AdminModule::where("name","=",$module)->first();
        $settings=\Config::get("admin.".$data['module']->name);
       
        $data['action']=\Lang::get("admin::templates.64");
        $model=$data['module']->model;
        $data['item']=new $model;
        $form=$this->createForm($settings['form'],$data['item']);
        $data['settings']=$form;
        $data['administrator']=\Neyko\Admin\Model\Administrator::find(\Session::get("admin"));
        $data['edit']=true;
        $data['page']='form';
        return \View::make("admin::form",$data);
    }

    public function uploadPicture(){
        $image=\Input::file("ajax_picture_upload");
        $img = \Image::make($image->getRealPath());
        $directory=public_path().'/files/temp/';
        $name=preg_replace("/[^A-Za-z0-9.]/", "",$image->getClientOriginalName());
        if(!\File::exists($directory)) {
            \File::makeDirectory($directory, 0777, true, true);
        }
        $img->save($directory.$name);
        return json_encode(array("image"=>"/files/temp/".$name,"name"=>$name));
    }

    public function uploadFile(){
        $file=\Input::file("ajax_file_upload");
        $directory=public_path().'/files/temp/';
        $name=$file->getClientOriginalName();
        if(!\File::exists($directory)) {
            \File::makeDirectory($directory, 0777, true, true);
        }
        while(\File::exists($directory.$name)){
            $name=pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).str_random(1).".".pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        }
        \File::copy($file->getRealPath(),$directory.$name);
        return json_encode(array("name"=>$name,"extension"=>pathinfo($name,PATHINFO_EXTENSION),'file'=>'/files/temp/'.$name));
    }

    public function createForm($form,$item){
        foreach($form['fields'] as $key=>$field){
            if ($field['type'] == 'select') {
                if (isset($field['options']['model'])) {
                    $model = $field['options']['model'];
                    $connections = $model::all();

                    $values = array();
                    foreach ($connections as $c) {
                        $value['value']=$c->$field['options']['value'];
                        if(isset($field['options']['function'])){
                            $value['description']= $c->$field['options']['function']();
                        }
                        else if(isset($field['options']['description'])){
                            $value['description']= $c->$field['options']['description'];
                        }
                        if(isset($field['options']['extra_description'])){
                            $value['extra_description']=$c->$field['options']['extra_description'];
                        }
                        $values[]=$value;
                    }
                    $form['fields'][$key]['values'] = $values;
                }
                else {
                    $values = array();
                    foreach ($field['options']['predefined'] as $val => $desc) {
                        $values[] = array(
                            'value'         => $val,
                            'description'   => $desc
                        );
                    }
                    $form['fields'][$key]['values'] = $values;
                }
            }
            if ($field['type'] == 'checkbox') {
                $model = $field['options']['model'];
                $connections = $model::all();

                $values = array();
                foreach ($connections as $c) {
                    $values[] = array(
                        'value'         => $c->$field['options']['value'],
                        'description'   => $c->$field['options']['description']
                    );
                }
                $checked=$item->$field['options']['connector'];
                foreach($checked as $check){
                    foreach($values as &$value){
                        if($value['value']==$check->id){
                            $value['checked']=true;
                        }
                    }
                }
                $form['fields'][$key]['values'] = $values;


            }
            else if ($field['type'] == 'gallery') {
                if($item){
                    $pictures = $item->$field['name'];
                    $form['fields'][$key]['pictures'] = $pictures;
                }
                else{
                    $form['fields'][$key]['pictures'] = array();
                }
            }
            else if ($field['type'] == 'filegallery') {
                $model = $field['model'];
                if($item){
                    $files = $item->$field['name'];
                    $form['fields'][$key]['files'] = $files;
                }
                else{
                    $form['fields'][$key]['files'] = array();
                }
            }
        }
        return $form;
    }

    public function callFunction($module,$function,$id){
        $module=\Neyko\Admin\Model\AdminModule::where("name","=",$module)->first();
        $model=$module->model;
        $item=$model::find($id);
        $message=$item->$function();

        $log=\Neyko\Admin\Model\AdminLog::create(array("username"=>\Neyko\Admin\Model\Administrator::find(\Session::get("admin"))->username,"message"=>"claimed ".$module->singular." <b>".\Input::get($module->main)."</b>"));
        $log->save();
        \Session::flash('message',$message);
        return redirect()->back();
    }

    public function delete($module,$id){
        $module=\Neyko\Admin\Model\AdminModule::where("name","=",$module)->first();
        $model=$module->model;
        $item=$model::find($id);
        $item->delete();

        $log=\Neyko\Admin\Model\AdminLog::create(array("username"=>\Neyko\Admin\Model\Administrator::find(\Session::get("admin"))->username,"message"=>\Lang::get("admin::messages.deleted")." ".$module->singular." <b>".\Input::get($module->main)."</b>"));
        $log->save();
        \Session::flash('message',\Lang::get("admin::messages.successfully_deleted").$module->singular." <b>".$item[$module->main]. "</b>.");
        return redirect()->back();
    }

    public function saveForm($module){
        $module=\Neyko\Admin\Model\AdminModule::where("name","=",$module)->first();
        $settings=\Config::get("admin.".$module->name);
        $model=$module->model;
        $form=$settings['form'];

        if(\Input::get("id")){
            $item=$model::find(\Input::get("id"));
        }
        else{
            $item=new $model;
            $item->save();
        }

        foreach ($form['fields'] as $field) {
            if (in_array($field['type'],array('text','textarea','ckeditor','select','video','date'))){
                $item->$field['name']=\Input::get($field['name']);
            }
            if ($field['type']=="switch"){
                $item->$field['name']=\Input::get($field['name'])?"1":0;
            }
            if ($field['type'] == 'picture') {
                $item->$field['name']=\Input::get($field['name']);
                if(\Input::get($field['name']."-fresh")){
                    $this->processPicture($field,$item,\Input::get($field['name']));
                }
            }
            if ($field['type'] == 'file') {
                $item->$field['name']=\Input::get($field['name']);
                if(\Input::get($field['name']."-fresh")){
                    $this->processFile($field,$item,\Input::get($field['name']));
                }
            }
            if ($field['type'] == 'admin') {
                if(\Input::get("admin_modules")){
                    \Neyko\Admin\Model\AdminAccess::where("id_admin","=",$item->id)->delete();
                    foreach(\Input::get("admin_modules") as $adminmodule){
                        \Neyko\Admin\Model\AdminAccess::create(array("id_admin"=>$item->id,"id_module"=>$adminmodule));
                    }
                }
            }

            if ($field['type'] == 'checkbox'){
                $checked=$item->$field['options']['connector'];
                foreach($checked as $check){
                    $item->$field['options']['connector']()->detach($check->id);
                }

                foreach(\Input::get($field['name']) as $checkbox){
                    $item->$field['options']['connector']()->attach($checkbox);
                }
            }


            else if ($field['type'] == 'gallery' || $field['type'] == 'filegallery') {
                $i = 0;
                $c = 1;
                $existing_ids = array();
                $files = $item->$field['name'];
                $count = (int) \Input::get($field['name'] . '-gcount');
                while ($c <= $count) {

                    if (\Input::has($field['name'].'-'.$i)){

                        $name = \Input::get($field['name'] . '-' . $i);
                        $fresh =\Input::get($field['name'] . '-fresh-' . $i);
                        $position = \Input::get($field['name'] . '-position-' . $i);


                        if ($fresh) {
                            $object = new $field['class'];
                            if( $field['type'] == 'gallery'){
                                $object->picture=$name;
                                $this->processPicture($field,$item,\Input::get($field['name'] . '-' . $i));
                            }
                            elseif( $field['type'] == 'filegallery'){
                                $object->file=$name;
                                $this->processFile($field,$item,\Input::get($field['name'] . '-' . $i));
                            }
                        }
                        else {
                            $file_id = \Input::get($field['name'] . '-id-' . $i);
                            $existing_ids[] = $file_id;
                            $object = $field['class']::find($file_id);
                        }

                        if (isset($field['extrafields'])) {
                            foreach ($field['extrafields'] as $extraname => $extra) {
                                if(isset($extra['lang'])){
                                    foreach(\Config::get("admin/admin.langs") as $lang){
                                        $e = \Input::get($field['name'] . '-extra-' . $extraname . '-' . $i.'_'.$lang);
                                        $object->translate($lang)->$extraname=$e;
                                    }
                                }
                                else{
                                    $e = \Input::get($field['name'] . '-extra-' . $extraname . '-' . $i);
                                    $property = ucfirst(preg_replace('/_/', '', $extraname));
                                    $object->$property=$e;
                                }

                            }
                        }

                        $object->position=$position;
                        $object->$field['id_parent']=$item->id;
                        $object->save();
                        $c++;
                    }
                    $i++;
                }

                foreach ($files as $file) {
                    if (!in_array($file->id, $existing_ids)) {
                        $file->delete();
                    }
                }
            }
        }

        $item->save();

        $main=$module->main;
        if(\Input::get("id")){
            $log=\Neyko\Admin\Model\AdminLog::create(array("username"=>\Neyko\Admin\Model\Administrator::find(\Session::get("admin"))->username,"message"=>\Lang::get("admin::messages.updated").$module->singular." <b>".$item->$main."</b>"));
            $log->save();
        }
        else{
            $log=\Neyko\Admin\Model\AdminLog::create(array("username"=>\Neyko\Admin\Model\Administrator::find(\Session::get("admin"))->username,"message"=>\Lang::get("admin::messages.created").$module->singular." <b>".$item->$main."</b>"));
            $log->save();
        }

        if (\Input::get('submit') == 'update') {
            return redirect("/admin/".$module->name."/edit/".$item->id)->with('message',\Lang::get("admin::messages.successfully_saved").$module->singular." <b>".$item->$main. "</b>.");
        }
        else {
            return redirect("/admin/".$module->name)->with('message',\Lang::get("admin::messages.successfully_saved").$module->singular." <b>".$item[$module->main]. "</b>.");;
        }
    }

    public function processPicture($field,$item,$value) {


        $temp=public_path()."/files/temp/";
        
        $rootpath=public_path()."/files/";
        if(isset($field['prepath'])){
            $rootpath.=$field['prepath']."/".$item->$field['preid']."/";
        }
        $rootpath.=$field['path']."/";
        if(isset($field['subpath'])){
            $rootpath.=$item->id."/";
            if(!empty($field['subpath'])){
                $rootpath.=$field['subpath']."/";
            }
        }
        
        $ext=pathinfo($value, PATHINFO_EXTENSION);
        $fn=pathinfo($value, PATHINFO_FILENAME);
        $newval=$value;        
    
        foreach($field['sizes'] as $size){
            if($size["type"]=="fixed_w"){
                $path=$rootpath.$size["width"]."w/";
                if(!\File::exists($path)){
                    \File::makeDirectory($path, 0777, true, true);
                }
                $image=\Image::make($temp.$value);
                $image->resize(intval($size["width"]), null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $image->save($path.$newval);
            }
            elseif($size["type"]=="fixed_h"){
                $path=$rootpath.$size["height"]."h/";
                if(!\File::exists($path)){
                    \File::makeDirectory($path, 0777, true, true);
                }
                $image=\Image::make($temp.$value);
                $image->resize(null,intval($size["height"]), function ($constraint) {
                    $constraint->aspectRatio();
                });
                $image->save($path.$newval);
        
            }
            elseif($size["type"]=="custom"){
                $path=$rootpath.$size["width"]."x".$size["height"]."/";
                if(!\File::exists($path)){
                    \File::makeDirectory($path, 0777, true, true);
                }
                $image=\Image::make($temp.$value);
                $image->fit(intval($size["width"]),intval($size["height"]));
                $image->save($path.$newval);
            }
        }
        if(!\File::exists($rootpath)){
            \File::makeDirectory($rootpath, 0777, true, true);
        }
        \File::copy($temp.$value,$rootpath.$newval);
    }

    public function processFile($field,$item,$value) {

        $temp=public_path()."/files/temp/";
        if($field['subpath']){
            $path=public_path()."/files/".$field['path'].'/'.$item->id. '/' .$field['subpath'] . '/';
        }
        else{
            $path=public_path()."/files".$field['path'];
        }
        if(!\File::exists($path)){
            \File::makeDirectory($path, 0777, true, true);
        }

        if(\File::exists($path.$value)){
            $ext=pathinfo($value, PATHINFO_EXTENSION);
            $fn=pathinfo($value, PATHINFO_FILENAME);
            $newval=$fn.rand(1000,9999).".".$ext;
            while(\File::exists($path.$newval)){
                $newval=$fn.rand(1000,9999).".".$ext;
            }
        }
        else{
            $ext=pathinfo($value, PATHINFO_EXTENSION);
            $fn=pathinfo($value, PATHINFO_FILENAME);
            $newval=$value;
        }
        \File::copy($temp.$value,$path.$newval);
    }

    public function processSwitch(){
        $module=\Neyko\Admin\Model\AdminModule::where("name","=",\Input::get("module"))->first();
        $model=$module->model;
        $row=$model::find(\Input::get("id"));
        $field=\Input::get("field");
        $row->$field=\Input::get("value");
        $row->save();
        return json_encode(array("success"=>"true"));
    }




}
