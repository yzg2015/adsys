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
                ['status', '状态', 'switch'],
                ['num', '库存'],
                ['add_time', '添加时间', 'datetime', '', 'Y-m-d H:i:s'],
                ['right_button', '操作', 'btn']
            ])
            ->addOrder(['name' => 'admin_goods', 'username' => 'admin_user'])
            ->addFilter(['admin_goods.name', 'admin_user.username'])
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
    public function edit($id = 0)
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

        // 获取数据
        $info = GoodsModel::get($id);

        // 使用ZBuilder快速创建表单
        return ZBuilder::make('form')
            ->setPageTitle('编辑节点')
            ->addFormItem('hidden', 'id')
            ->addFormItem('select', 'pid', '所属节点', '所属上级节点', [])
            ->addFormItem('text', 'title', '节点标题')
            ->addFormItem('radio', 'url_type', '链接类型', '', ['module_admin' => '模块链接(后台)', 'module_home' => '模块链接(前台)', 'link' => '普通链接'], 'module_admin')
            ->addFormItem(
                'text',
                'url_value',
                '节点链接',
                "可留空，如果是模块链接，请填写<code>模块/控制器/操作</code>，如：<code>admin/menu/add</code>。如果是普通链接，则直接填写url地址，如：<code>http://www.admail.com</code>"
            )
            ->addText('params', '参数', '如：a=1&b=2')

            ->addRadio('url_target', '打开方式', '', ['_self' => '当前窗口', '_blank' => '新窗口'], '_self')
            ->addIcon('icon', '图标', '导航图标')
            ->addRadio('online_hide', '网站上线后隐藏', '关闭开发模式后，则隐藏该菜单节点', ['否', '是'])
            ->addText('sort', '排序', '', 100)
            ->setFormData($info)
            ->fetch();
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
                $sel_site_list = SiteModel::getSelList();
                $arr = array();


                $list_status = ['0' => '下架', '1' => '上架'];
                return ZBuilder::make('form')
                    ->setTabNav($list_tab,  $group)
                    ->setPageTitle('新增商品')
                   // ->addSelect('city', '站点', '', ['gz' => '广州', 'sz' => '深圳', 'sh' => '上海'])
                    ->addFormItems([
                        ['text','title','商品名称'],
                        ['text','spu','SPU'],
                        ['select','site_id','站点','', ['gz' => '广州', 'sz' => '深圳', 'sh' => '上海']],
                        ['text','who','负责人'],
                        ['text','num','商品库存'],
                        ['text','price','原价'],
                        ['text','z_price','折扣价'],
                        ['text','dao_time','活动倒计时'],
                        ['ueditor','content','商品名称'],
                        ['image','pic','商品图片']
                    ])
                    ->addRadio('city', '上架状态', '', $list_status,0)
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