<?php
namespace lai;
/**
 * 视图
 */
class View{
    //模板的文件夹
    protected $view = 'view';
    //模板变量
    protected $data = array();
    
    
    /**
     * 模板变量赋值
     * @access public
     * @param mixed $name  变量名
     * @param mixed $value 变量值
     */
    public function assign($name, $value = ''){
        if (is_array($name)) {
            $this->data = array_merge($this->data, $name);
        } else {
            $this->data[$name] = $value;
        }
    }

    /**
     * 解析和获取模板内容 用于输出
     * @param string $template 模板文件名
     * @return string
     */
    public function fetch($template=''){
        //返回mvc
        $urlvar = Route::urlvar();
        
        $module_var = $urlvar['module_var'];            //模块
        $controller_var = $urlvar['controller_var'];    //控制器
        $action_var = $urlvar['action_var'];            //操作
        
        //判断是否有模板文件名
        if (empty($template)){
            
            //组合模板路径
            $url = APP_PATH.$module_var.DS.$this->view.DS.$controller_var.DS.$action_var.'.php';
        }
        
        //判断是否有这个模板
        if(is_file($url)){
            //判断是否有传进变量
            if(count($this->data)){
                //将关联数组拆分
                extract($this->data);
            }
            
            //载入模板
            include $url;
        }else{
            trigger_error('文件不存在 '.$url,E_USER_NOTICE);
        }
    }

    /**
     * 渲染内容输出
     * @access public
     * @param string $template 模板文件名
     * @return string
     */
    public function display($template=''){
        return $this->fetch($template);
    }

    /**
     * 模板变量赋值
     * @access public
     * @param string $name  变量名
     * @param mixed $value 变量值
     */
    public function __set($name, $value){
        $this->data[$name] = $value;
    }

    /**
     * 取得模板显示变量的值
     * @access protected
     * @param string $name 模板变量
     * @return mixed
     */
    public function __get($name){
        return $this->data[$name];
    }

    /**
     * 检测模板变量是否设置
     * @access public
     * @param string $name 模板变量名
     * @return bool
     */
    public function __isset($name){
        return isset($this->data[$name]);
    }
}
