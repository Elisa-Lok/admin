<?php

namespace app\admin\controller;
use app\admin\model\UserType;
use org\Verify;
use think\Controller;
use think\Db;

class Login extends Controller{

    /**
     * 登录页面
     * @return
     */
    public function index($urlkey=''){
        $this->assign('verify_type', config('verify_type'));
        if (! isset ( $_SESSION ['adminuid'] )) {
            if (ADMIN_KEY && ($urlkey != ADMIN_KEY)) {
                $this->redirect('/');
            }else{
                session('loginkeys',$urlkey);
                return $this->fetch('/login');

            }
        }else{
             return $this->fetch('/login');
        }

    }


    /**
     * 登录操作
     * @return
     */
    public function doLogin(){
        $username = input("param.username");
        $password = input("param.password");

        if (config('verify_type') == 1) {
            $code = input("param.code");
        }

        $result = $this->validate(compact('username', 'password'), 'AdminValidate');
        if(true !== $result){
            return json(['code' => -5, 'url' => '', 'msg' => $result]);
        }
        $verify = new Verify();
        if (config('verify_type') == 1) {
            if (!$code) {
                return json(['code' => -4, 'url' => '', 'msg' => '请输入验证码']);
            }
            if (!$verify->check($code)) {
                return json(['code' => -4, 'url' => '', 'msg' => '验证码错误']);
            }
        }

        $hasUser = Db::name('admin')->where('username', $username)->find();
        if(empty($hasUser)){
            return json(['code' => -1, 'url' => '', 'msg' => '管理员不存在']);
        }
        if(md5(md5($password) . config('auth_key')) != $hasUser['password']){
            writelog($hasUser['id'],$username,'用户【'.$username.'】登录失败：密码错误',2);
            return json(['code' => -2, 'url' => '', 'msg' => '账号或密码错误']);
        }

        if(1 != $hasUser['status']){
            writelog($hasUser['id'],$username,'用户【'.$username.'】登录失败：该账号被禁用',2);
            return json(['code' => -6, 'url' => '', 'msg' => '该账号被禁用']);
        }


        //获取该管理员的角色信息
        $user = new UserType();
        $info = $user->getRoleInfo($hasUser['groupid']);

        session('adminuid', $hasUser['id']);         //用户ID
        session('username', $hasUser['username']);  //用户名
        session('portrait', $hasUser['portrait']); //用户头像
        session('rolename', $info['title']);    //角色名
        session('rule', $info['rules']);        //角色节点
        session('name', $info['name']);         //角色权限

        //更新管理员状态
        $param = [
            'loginnum' => $hasUser['loginnum'] + 1,
            'last_login_ip' => request()->ip(),
            'last_login_time' => time(),
            'token' => md5($hasUser['username'] . $hasUser['password'])
        ];

        Db::name('admin')->where('id', $hasUser['id'])->update($param);
        writelog($hasUser['id'],session('username'),'用户【'.session('username').'】登录成功',1);
        return json(['code' => 1, 'url' => url('index/index'), 'msg' => '登录成功！']);
    }


    /**
     * 验证码
     * @return
     */
    public function checkVerify(){
        $verify = new Verify();
        $verify->imageH = 32;
        $verify->imageW = 100;
		    $verify->codeSet = '123456789';
        $verify->length = 4;
        $verify->useNoise = false;
        $verify->fontSize = 14;
        return $verify->entry();
    }


    /**
     * 退出登录
     * @return
     */
    public function loginOut(){
        //session(null);
		session('adminuid', null);         //用户ID
        session('username', null);  //用户名
        session('portrait', null); //用户头像
        session('rolename', null);    //角色名
        session('rule', null);        //角色节点
        session('name', null);         //角色权限
        //cache('db_config_data',null);//清除缓存中网站配置信息
        $this->redirect('login/index');
    }
}
