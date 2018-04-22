<?php
// +----------------------------------------------------------------------
// | admail-PHP框架 [ admail ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://admail.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace app\admin\controller;


use think\Cache;
use think\helper\Hash;
use think\Db;
use app\common\builder\ZBuilder;
use app\user\model\User as UserModel;

use app\admin\model\Delivery as DeliveryModel;
/**
 * 后台默认控制器
 * @package app\admin\controller
 */
class Delivery extends Admin
{
    /**
     * 后台首页
     * @author 蔡伟明 <314013107@qq.com>
     * @return string
     */
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 排序
        $order = $this->getOrder('admin_delivery.id desc');
        // 数据列表
        $data_list = DeliveryModel::getAll($map, $order);
        // 分页数据
        $page = $data_list->render();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setPageTitle('物流管理列表') // 设置页面标题
            ->setSearch(['admin_order.order_sn' => '订单号', 'admin_delivery.w_sn' => '物流单号','admin_delivery.z_sn' => '转寄物流单号']) // 设置搜索框
            ->hideCheckbox()
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['order_sn', '订单号'],
                ['w_sn', '物流单号'],
                ['z_sn', '转寄物流单号'],
                ['daihao', '销售代号'],
                ['zhongliang', '重量'],
                ['delivery_price', '单价'],
                ['delivery_money', '运费'],
                ['one_lei', '一级品类'],
                ['two_lei', '二级品类'],
                ['send_now', '是否為現發', 'switch'],
                ['send_now', '站点'],
                ['remark', '备注'],

                ['send_time', '发货时间', 'time', '', 'Y-m-d'],
                ['right_button', '操作', 'btn']
            ])
            ->addOrder(['order_sn' => 'admin_order', 'w_sn' => 'admin_delivery'])
            ->addFilter(['admin_order.order_sn', 'admin_delivery.w_sn'])
            ->addRightButton('edit', ['icon' => 'fa fa-eye', 'title' => '详情', 'href' => url('details', ['id' => '__id__'])])
            ->setRowList($data_list) // 设置表格数据
            ->setPages($page) // 设置分页数据
            ->fetch(); // 渲染模板
    }


    /**
     * 编辑节点
     * @param int $id 节点ID
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function edit($id = 0)
    {
        if ($id === 0) $this->error('缺少参数');

        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post('', null, 'trim');

            // 验证
            $result = $this->validate($data, 'Menu');
            // 验证失败 输出错误信息
            if(true !== $result) $this->error($result);

            // 顶部节点url检查
            if ($data['pid'] == 0 && $data['url_value'] == '' && ($data['url_type'] == 'module_admin' || $data['url_type'] == 'module_home')) {
                $this->error('顶级节点的节点链接不能为空');
            }

            // 设置角色权限
            $this->setRoleMenu($data['id'], isset($data['role']) ? $data['role'] : []);

            // 验证是否更改所属模块，如果是，则该节点的所有子孙节点的模块都要修改
            $map['id'] = $data['id'];
            $map['module'] = $data['module'];
            if (!MenuModel::where($map)->find()) {
                MenuModel::changeModule($data['id'], $data['module']);
            }

            if (MenuModel::update($data)) {
                Cache::clear();
                // 记录行为
                $details = '节点ID('.$id.')';
                action_log('menu_edit', 'admin_menu', $id, UID, $details);
                $this->success('编辑成功', cookie('__forward__'));
            } else {
                $this->error('编辑失败');
            }
        }

        // 获取数据
        $info = MenuModel::get($id);
        // 拥有该节点权限的角色
        $info['role'] = RoleModel::getRoleWithMenu($id);

        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
            ->setPageTitle('编辑节点')
            ->addFormItem('hidden', 'id')
            ->addLinkage('module', '所属模块', '', ModuleModel::getModule(), '', url('ajax/getModuleMenus'), 'pid')
            ->addFormItem('select', 'pid', '所属节点', '所属上级节点', MenuModel::getMenuTree(0, '', $info['module']))
            ->addFormItem('text', 'title', '节点标题')
            ->addFormItem('radio', 'url_type', '链接类型', '', ['module_admin' => '模块链接(后台)', 'module_home' => '模块链接(前台)', 'link' => '普通链接'], 'module_admin')
            ->addFormItem(
                'text',
                'url_value',
                '节点链接',
                "可留空，如果是模块链接，请填写<code>模块/控制器/操作</code>，如：<code>admin/menu/add</code>。如果是普通链接，则直接填写url地址，如：<code>http://www.admail.com</code>"
            )
            ->addText('params', '参数', '如：a=1&b=2')
            ->addSelect('role', '角色', '除超级管理员外，拥有该节点权限的角色', RoleModel::where('id', 'neq', 1)->column('id,name'), '', 'multiple')
            ->addRadio('url_target', '打开方式', '', ['_self' => '当前窗口', '_blank' => '新窗口'], '_self')
            ->addIcon('icon', '图标', '导航图标')
            ->addRadio('online_hide', '网站上线后隐藏', '关闭开发模式后，则隐藏该菜单节点', ['否', '是'])
            ->addText('sort', '排序', '', 100)
            ->setFormData($info)
            ->fetch();
    }
    /**
     * 日志详情
     * @param null $id 日志id
     * @author 蔡伟明 <314013107@qq.com>
     */
    public function details($id = null)
    {
        if ($id === null) $this->error('缺少参数');
        $info = LogModel::getAll(['admin_log.id' => $id]);
        $info = $info[0];
        $info['action_ip'] = long2ip($info['action_ip']);

        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
            ->setPageTitle('编辑') // 设置页面标题
            ->addFormItems([ // 批量添加表单项
                ['hidden', 'id'],
                ['static', 'title', '行为名称'],
                ['static', 'username', '执行者'],
                ['static', 'record_id', '目标ID'],
                ['static', 'action_ip', '执行IP'],
                ['static', 'module_title', '所属模块'],
                ['textarea', 'remark', '备注'],
            ])
            ->hideBtn('submit')
            ->setFormData($info) // 设置表单数据
            ->fetch();
    }


}