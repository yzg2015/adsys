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
use app\admin\model\Cate as CateModel;
/**
 * 后台默认控制器
 * @package app\admin\controller
 */
class Cate extends Admin
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
        $order = $this->getOrder('admin_cate.sort desc');
        // 数据列表
        $data_list = CateModel::getAll($map, $order);
        // 分页数据
        $page = $data_list->render();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setPageTitle('分类管理') // 设置页面标题
            ->setSearch(['admin_cate.title' => '分类名称']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['pid', '父类ID'],
                ['title', '分类名称'],
                ['pic', '分类图标'],
                ['status', '前台显示状态', 'switch'],
                ['sort', '排序号（越大排在前）'],
                ['right_button', '操作', 'btn']
            ])
            ->addOrder(['id' => 'admin_cate'])
            ->addFilter(['admin_cate.title'])
            ->addRightButtons('edit,delete')
           ->setRowList($data_list) // 设置表格数据
            ->addTopButtons('add,enable,delete,disable')
            ->setPages($page) // 设置分页数据
            ->fetch(); // 渲染模板
    }
    /**yang
     * @param int $id
     * @return mixed
     */
    public function edit($id = 0)
    {
        if ($id === 0) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post('', null, 'trim');
            // 验证
            $result = $this->validate($data, 'cate');
            // 验证失败 输出错误信息
            if(true !== $result) $this->error($result);
            // 验证是否更改所属模块，如果是，则该节点的所有子孙节点的模块都要修改
            $map['id'] = $data['id'];
            if (CateModel::update($data)) {
                // 记录行为
                $this->success('编辑成功', cookie('__forward__'));
            } else {
                $this->error('编辑失败');
            }
        }

        $info = CateModel::get($id);
        $list_status = ['0' => '禁用', '1' => '开启'];
        return ZBuilder::make('form')
            ->setUrl(url('save'))
            ->setPageTitle('编辑分类名称')
            ->addFormItems([
                ['hidden','id'],
                ['select','pid','父类','',  CateModel::getTreeList($id)],
                ['text','title','分类名称'],
                ['image','pic','分类图标'],
                ['number','sort','排序号（越大越排在前）'],
            ])
            ->setFormData($info)
            ->addRadio('status', '启用与否', '', $list_status,0)
            ->fetch();


    }


    public function save()
    {        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if(!empty($data['id'])){
                if (false !==CateModel::where('id', $data['id'])->update($data)) {
                    $this->success('保存成功','index');
                } else {

                    $this->error('保存失败，请重试');
                }
            }else{

                if (false !== CateModel::create($data)) {
                    $this->success('新增成功','index');
                } else {
                    $this->error('新增失败，请重试');
                }
            }

        }
    }


    public function add()
    {
        $list_status = ['0' => '禁用', '1' => '开启'];
        return ZBuilder::make('form')
            ->setUrl(url('save'))
            ->setPageTitle('添加分类')
            ->addFormItems([
                ['hidden','id'],
                ['select','pid','父类','',  CateModel::getTreeList()],
                ['text','title','分类名称'],
                ['image','pic','分类图标'],
                ['number','sort','排序号（越大越排在前）'],
            ])
            ->addRadio('status', '启用与否', '', $list_status,0)
            ->fetch();
    }

}