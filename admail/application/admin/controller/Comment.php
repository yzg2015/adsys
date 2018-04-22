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
use app\admin\model\Comment as CommentModel;

use think\Cache;
use think\helper\Hash;
use think\Db;
use app\common\builder\ZBuilder;
use app\user\model\User as UserModel;
use app\admin\model\Goods as GoodsModel;

/**
 * 后台默认控制器
 * @package app\admin\controller
 */
class Comment extends Admin
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
        $order = $this->getOrder('admin_comment.id desc');
        // 数据列表
        $data_list = CommentModel::getAll($map, $order);
        // 分页数据
        $page = $data_list->render();

        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setPageTitle('评论管理') // 设置页面标题
            ->setSearch(['admin_goods.name' => '商品名称', 'admin_comment.content' => '评论内容']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['__INDEX__', '#'],
                ['id', 'ID'],
                ['name', '商品名称'],
                ['content', '评论内容'],
                ['star', '星级'],
                ['status', '显示', 'switch'],
                ['add_time', '添加时间', 'time', '', 'Y-m-d H:i:s'],
                ['right_button', '操作', 'btn']
            ])
            ->addOrder(['name' => 'admin_goods', 'username' => 'admin_user'])
            ->addFilter(['admin_goods.name', 'admin_user.username'])
            ->addTopButtons('add,delete')
            ->addRightButtons('edit,delete')
            ->setRowList($data_list) // 设置表格数据
            ->setPages($page) // 设置分页数据

            ->fetch(); // 渲染模板
    }


    public function save()
    {        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if(!empty($data['id'])){
                if (false !==CommentModel::where('id', $data['id'])->update($data)) {
                    $this->success('保存成功','index');
                } else {
                    $this->error('保存失败，请重试');
                }
            }else{
                if (false !== CommentModel::create($data)) {
                    $this->success('新增成功','index');
                } else {
                    $this->error('新增失败，请重试');
                }
            }

//            ConfigModel::where('name', $name)->update(['value' => $data[$name]]);
        }
    }

    public function add()
    {
        $list_status = ['0' => '隐藏', '1' => '显示'];
        return ZBuilder::make('form')
            ->setUrl(url('save'))
            ->setPageTitle('新增评论')
            ->addFormItems([
                ['select','goods_id','商品名称','', GoodsModel::getTreeList()],
                ['number','star','星级'],
                ['ueditor','content','商品评论'],
                ['text','email','郵箱']
            ])
            ->addRadio('status', '是否显示', '', $list_status,0)
            ->fetch();

    }


    public function edit($id=0)
    {
        if(!$id){
            $this->error('id为空','index');
        }
        $info =  Db::name('admin_comment')->where('id',$id)->find();
        // 显示编辑页面
        return ZBuilder::make('form')
            ->setUrl(url('save'))
            ->setPageTitle('编辑评论')
            ->addFormItems([
                ['hidden', 'id'],
                ['select', 'goods_id', '商品名称', '<span class="text-danger">必选</span>', GoodsModel::getTreeList()],
                ['number','star','星级'],
                ['ueditor','content','商品评论'],
                ['text','email','郵箱']
            ])
            ->setFormData($info)
            ->fetch();

    }





}