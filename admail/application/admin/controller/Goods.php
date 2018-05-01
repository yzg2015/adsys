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

use app\admin\model\Goods as GoodsModel;
use app\admin\model\Site as SiteModel;
/**
 * 后台默认控制器
 * @package app\admin\controller
 */
class Goods extends Admin
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
        $order = $this->getOrder('admin_goods.id desc');
        // 数据列表
        $data_list = GoodsModel::getAll($map, $order);
        // 分页数据
        $page = $data_list->render();

        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setPageTitle('商品管理列表') // 设置页面标题
            ->setSearch(['admin_goods.name' => '商品名称', 'admin_site.url' => '所选站点']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['name', '商品名称'],
                ['url', '所选站点'],
                ['price', '价格'],
                ['status', '上架状态', 'switch'],
                ['num', '库存'],
                ['add_time', '添加时间', 'datetime', '', 'Y-m-d H:i:s'],
                ['right_button', '操作', 'btn']
            ])
            ->addOrder(['name' => 'admin_goods', 'username' => 'admin_user','url' => 'admin_site'])
            ->addFilter(['admin_goods.name', 'admin_user.username', 'admin_site.url'])
            ->addTopButtons('add,enable,delete,disable')
            ->addRightButtons('edit,delete')
            ->setRowList($data_list) // 设置表格数据
            ->setPages($page) // 设置分页数据
            ->fetch(); // 渲染模板
    }

    public function details($id = 0){
        $this->fetch();
    }

    /**yang
     * @param int $id
     * @return mixed
     */
    public function edit($id = 0,$group='tab1')
    {
        if ($id === 0) $this->error('缺少参数');
        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post('', null, 'trim');
            // 验证
            $result = $this->validate($data, 'Goods');
            // 验证失败 输出错误信息
            if(true !== $result) $this->error($result);
            // 验证是否更改所属模块，如果是，则该节点的所有子孙节点的模块都要修改
            $map['id'] = $data['id'];
            if (GoodsModel::update($data)) {
                // 记录行为
                $this->success('编辑成功', cookie('__forward__'));
            } else {
                $this->error('编辑失败');
            }
        }


        $info = GoodsModel::get($id);
        $list_tab = [
            'tab1' => ['title' => '通用信息', 'url' => url('edit', ['id'=>$id,'group' => 'tab1'])],
            'tab2' => ['title' => '商品描述', 'url' => url('edit', ['id'=>$id,'group' => 'tab2'])],
            'tab3' => ['title' => '商品规格', 'url' => url('edit', ['id'=>$id,'group' => 'tab3'])],
            'tab4' => ['title' => '商品属性', 'url' => url('edit', ['id'=>$id,'group' => 'tab4'])],
            'tab5' => ['title' => '促销', 'url' => url('edit', ['id'=>$id,'group' => 'tab5'])],
        ];
        // 使用ZBuilder快速创建表单
        $list_status = ['0' => '下架', '1' => '上架'];
        switch ($group) {
            case 'tab1':
                return ZBuilder::make('form')
                    ->setTabNav($list_tab,  $group)
                    ->setUrl(url('save'))
                    ->setPageTitle('编辑商品')
                    ->addFormItems([
                        ['hidden','id'],
                        ['text','name','商品名称'],
                        ['text','spu','SPU'],
                        ['select','site_id','站点','',  SiteModel::getTreeList()],
                        ['text','who','负责人'],
                        ['number','num','商品库存'],
                        ['text','price','原价'],
                        ['text','z_price','折扣价'],
                        ['text','dao_time','活动倒计时'],
                        ['number','num','已搶購數量'],
                        ['image','pic','商品图片']
                    ])
                    ->addRadio('status', '上架状态', '', $list_status,0)
                    ->setFormData($info)
                    ->fetch();
                break;
            case 'tab2':
                return ZBuilder::make('form')
                    ->setTabNav($list_tab,  $group)
                    ->setUrl(url('save'))
                    ->setPageTitle('编辑商品')
                    ->addFormItems([
                        ['hidden','id'],
                        ['ueditor','content','产品详情'],
                    ])
                    ->addRadio('status', '上架状态', '', $list_status,0)
                    ->setFormData($info)
                    ->fetch();
                break;
            case 'tab3':
                return ZBuilder::make('form')
                    ->setTabNav($list_tab,  $group)
                    ->setUrl(url('save'))
                    ->setPageTitle('编辑商品')
                    ->addFormItems([
                        ['hidden','id'],
                        ['text','name','商品名称'],
                        ['text','spu','SPU'],
                        ['select','site_id','站点','',  SiteModel::getTreeList()],

                    ])
                    ->addRadio('status', '上架状态', '', $list_status,0)
                    ->setFormData($info)
                    ->fetch();
                break;
            case 'tab4':
                return ZBuilder::make('form')
                    ->setTabNav($list_tab,  $group)
                    ->addTextarea('summary', '摘要')
                    ->fetch();
                break;
            case 'tab5':
                return ZBuilder::make('form')
                    ->setTabNav($list_tab,  $group)
                    ->addTextarea('summary', '摘要')
                    ->fetch();
                break;
            default:
                return ZBuilder::make('form')
                    ->setTabNav($list_tab,  $group)
                    ->setUrl(url('save'))
                    ->setPageTitle('编辑商品')
                    ->addFormItems([
                        ['hidden','id'],
                        ['text','name','商品名称'],
                        ['text','spu','SPU'],
                        ['select','site_id','站点','',  SiteModel::getTreeList()],
                        ['text','who','负责人'],
                        ['number','num','商品库存'],
                        ['text','price','原价'],
                        ['text','z_price','折扣价'],
                        ['text','dao_time','活动倒计时'],
                        ['ueditor','content','商品内容'],
                        ['number','num','已搶購數量'],
                        ['image','pic','商品图片']
                    ])
                    ->addRadio('status', '上架状态', '', $list_status,0)
                    ->setFormData($info)
                    ->fetch();
                break;
        }


    }


    public function save()
    {        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if(!empty($data['id'])){
                $data['update_time'] = time();
                if (false !==GoodsModel::where('id', $data['id'])->update($data)) {
                    $this->success('保存成功','index');
                } else {
                    $this->error('保存失败，请重试');
                }
            }else{
                $data['add_time'] = time();
                if (false !== GoodsModel::create($data)) {
                    $this->success('新增成功','index');
                } else {
                    $this->error('新增失败，请重试');
                }
            }

        }
    }

    public function add($group='tab1')
    {
        $list_tab = [
            'tab1' => ['title' => '通用信息', 'url' => url('add', ['group' => 'tab1'])],
            'tab2' => ['title' => '商品描述', 'url' => url('add', ['group' => 'tab2'])],
            'tab3' => ['title' => '商品规格', 'url' => url('add', ['group' => 'tab3'])],
            'tab4' => ['title' => '商品属性', 'url' => url('add', ['group' => 'tab4'])],
            'tab5' => ['title' => '促销', 'url' => url('add', ['group' => 'tab5'])],
        ];
        switch ($group) {
            case 'tab1':
                $list_status = ['0' => '下架', '1' => '上架'];
                return ZBuilder::make('form')
                    ->setTabNav($list_tab,  $group)
                    ->setUrl(url('save'))
                    ->setPageTitle('新增商品')
                    ->addFormItems([
                        ['text','name','商品名称'],
                        ['text','spu','SPU'],
                        ['select','site_id','站点','',  SiteModel::getTreeList()],
                        ['text','who','负责人'],
                        ['number','num','商品库存'],
                        ['text','price','原价'],
                        ['text','z_price','折扣价'],
                        ['text','dao_time','活动倒计时'],
                        ['ueditor','content','商品内容'],
                        ['number','num','已搶購數量'],
                        ['image','pic','商品图片']
                    ])
                    ->addRadio('status', '上架状态', '', $list_status,0)
                    ->fetch();
                break;
            case 'tab2':
                return ZBuilder::make('form')
                    ->setTabNav($list_tab,  $group)
                    ->addTextarea('summary', '摘要')
                    ->fetch();
                break;
            case 'tab3':
                return ZBuilder::make('form')
                    ->setTabNav($list_tab,  $group)
                    ->addTextarea('summary', '摘要')
                    ->fetch();
                break;
            case 'tab4':
                return ZBuilder::make('form')
                    ->setTabNav($list_tab,  $group)
                    ->addTextarea('summary', '摘要')
                    ->fetch();
                break;
            case 'tab5':
                return ZBuilder::make('form')
                    ->setTabNav($list_tab,  $group)
                    ->addTextarea('summary', '摘要')
                    ->fetch();
                break;
        }

    }


    /**
     * 检查版本更新
     * @author 蔡伟明 <314013107@qq.com>
     * @return \think\response\Json
     */
    public function checkUpdate()
    {
        $params = config('dolphin');
        $params['domain']  = request()->domain();
        $params['website'] = config('web_site_title');
        $params['ip']      = $_SERVER['SERVER_ADDR'];
        $params['php_os']  = PHP_OS;
        $params['php_version'] = PHP_VERSION;
        $params['mysql_version'] = db()->query('select version() as version')[0]['version'];
        $params['server_software'] = $_SERVER['SERVER_SOFTWARE'];
        $params = http_build_query($params);

        $opts = [
            CURLOPT_TIMEOUT        => 20,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL            => config('dolphin.product_update'),
            CURLOPT_USERAGENT      => $_SERVER['HTTP_USER_AGENT'],
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => $params
        ];

        // 初始化并执行curl请求
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($data, true);

        if ($result['code'] == 1) {
            return json([
                'update' => '<a class="badge badge-primary" href="http://www.admail.com/download" target="_blank">有新版本：'.$result["version"].'</a>',
                'auth'   => $result['auth']
            ]);
        } else {
            return json([
                'update' => '',
                'auth'   => $result['auth']
            ]);
        }
    }
}