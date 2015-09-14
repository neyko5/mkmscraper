<?php

namespace Neyko\Admin\Http\Controller;


use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdministratorController extends BaseController {
   
    public function logout(){
        \Session::forget('admin');
        return redirect('/admin/login')->with('message', 'You have been successfully logged out.')->withCookie(\Cookie::forget('neyko_admin_remember_token'));
    }

    public function showLogin(){
        return \View::make("admin::login",array("page"=>"login","login"=>true));
    }

    public function login(){
        $admin=\Neyko\Admin\Model\Administrator::where("username","=",\Input::get('username'))->first();
        if($admin){
            if (\Hash::check(\Input::get('password'),$admin->password)){
                \Session::put('admin',$admin->id);
                if(\Input::get("remember_me")=="on"){
                    $admin->remember_token=str_random(100);
                    $admin->save();
                    return redirect('/admin')->with('message', 'You have successfully logged in.')->withCookie(\Cookie::forever('neyko_admin_remember_token',$admin->remember_token));
                }
                else{
                    return redirect('/admin')->with('message', 'You have successfully logged in.');
                }
            }
            else{
                return redirect('/admin/login')->with('message', 'You have failed to login.');
            }
        }
        else{
            return redirect('/admin/login')->with('message', 'You have failed to login.');
        }
    }

    public function changePassword(){
        if(\Input::get('oldpassword')&&\Input::get('newpassword')&&\Input::get('passwordrepeat')){
            
            $admin=\Neyko\Admin\Model\Administrator::find(\Session::get("admin"));
            if(\Hash::check(\Input::get('oldpassword'),$admin->password)){
                if(\Input::get('newpassword')==\Input::get('passwordrepeat')){
                    $admin->password=\Hash::make(\Input::get('newpassword'));
                    $admin->save();
                    $log=\Neyko\Admin\Model\AdminLog::create(array("username"=>\Neyko\Admin\Model\Administrator::find(\Session::get("admin"))->username,"message"=>\Lang::get("admin::messages.changedpassword")));
                    $log->save();                     
                    return redirect('/admin')->with("message",\Lang::get("admin::messages.successchangepassword"));
                }
                else{
                    return redirect('/admin')->with("message",\Lang::get("admin::messages.passwordsnotmatch"));
                }
            }
            else{
                return redirect('/admin')->with("message",\Lang::get("admin::messages.oldpasswordwrong"));
            }
        }
        else{
            return redirect('/admin')->with("message",\Lang::get("admin::messages.enterallfields"));
        }
    }

    public function createAdmin(){
        if(\Input::get("password")==\Input::get("passwordrepeat")){
            if(\Neyko\Admin\Model\Administrator::where("username","=",\Input::get("username"))->orWhere("email","=",\Input::get("email"))->count()<1){
                $admin=\Neyko\Admin\Model\Administrator::create(array("username"=>\Input::get("username"),"password"=>\Hash::make(\Input::get("password")),"email"=>\Input::get("email"),"lang"=>\Input::get("language")));
                $admin->save();
                $log=\Neyko\Admin\Model\AdminLog::create(array("username"=>\Neyko\Admin\Model\Administrator::find(\Session::get("admin"))->username,"message"=>\Lang::get("admin::messages.createdadmin")));
                $log->save();  
                return redirect('/admin')->with("message",\Lang::get("admin::messages.successcreateadmin"));
            }
            else{
                return redirect('/admin')->with("message",\Lang::get("admin::messages.adminexist"));
            }
        }
        else{
            return redirect('/admin')->with("message",\Lang::get("admin::messages.passwordsnotmatch"));
        }
    }



}
