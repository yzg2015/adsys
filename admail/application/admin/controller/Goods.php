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
use app\admin\model\Goodscode as GoodscodeModel;
use app\admin\model\Goods as GoodsModel;
use app\admin\model\Site as SiteModel;
use app\admin\model\Cate as CateModel;

use app\admin\model\Buysend as BuysendModel;
use app\admin\model\Fullminus as FullminusModel;
use app\admin\model\Discount as DiscountModel;
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
        foreach ($data_list as &$v){
            $v['name'] = "<a  target='_blank' href='".$v['go_url']."'>". $v['name'] ."</a>";
        }

        // 分页数据
        $page = $data_list->render();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setPageTitle('商品管理列表') // 设置页面标题
            ->setSearch(['admin_goods.name' => '商品名称','admin_goods.who' => '负责人', 'admin_goods.go_url' => '所选站点']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['name', '商品名称'],
                ['go_url', '所选站点'],
                ['who', '负责人'],
                ['price', '价格'],
                ['status', '状态', 'switch'],
                ['num', '库存'],
                ['buy_num', '已购数量'],
                ['add_time', '添加时间', 'datetime', '', 'Y-m-d H:i:s'],
                ['right_button', '操作', 'btn']
            ])
            ->addOrder(['name' => 'admin_goods', 'username' => 'admin_user','go_url' => 'admin_goods'])
            ->addFilter(['admin_goods.name', 'admin_goods.who', 'admin_site.go_url'])
            ->addTopButtons('add,enable,delete,disable')
            ->addRightButtons('edit,delete')
            ->setRowList($data_list) // 设置表格数据
            ->setPages($page) // 设置分页数据
            ->fetch(); // 渲染模板
    }

    public function add()
    {
        $info['cid'] =0;
        $info['site_id'] =0;
        $info['who'] ='';
        $info['name'] ='';
        $info['num'] =0;
        $info['price'] ='';
        $info['z_price'] ='';
        $info['content'] ='';
        $info['status'] =1;
        $info['id'] =0;
        $info['spu'] ='';
        $info['remark'] ='';
        $info['pic'] =0;
        $info['pics'] ='';
        $info['dao_time'] ='';
        $info['buy_num'] =0;
        $info['prom_type'] =0;
        $info['prom_id'] =0;
        $info['spec'] ='';
        $info['shuxing'] ='';
        $info['prom_id_list'] = BuysendModel::getList();
        return ZBuilder::make('form')
            ->assign('id',0)
            ->assign('info',$info)
            ->assign('cate_list',CateModel::getAllList())
            ->assign('site_list',SiteModel::getAllList())
            ->assign('spec_list',array())
            ->assign('shuxing_list',array())
            ->setTemplate('edit')
            ->fetch();

    }


    public function add_gg(){
        return $this->fetch();
    }

    public function add_sx(){
        return $this->fetch();
    }

    /**yang
     * @param int $id
     * @return mixed
     */
    public function edit($id = 0)
    {
        if ($id == 0) {
            $this->error('缺少参数');
        }
        $info['prom_type'] =0;
        $info['prom_id'] =0;
        $info['pic'] =0;
        $info['pics'] ='';
        $info = array();
        $info['spec']='';
        if($id){
            $info = GoodsModel::get($id);
            if(!empty($info)) {
                if ($info['prom_id'] == 1 || $info['prom_id'] == 0) {
                    $info['prom_id_list'] = BuysendModel::getList();
                }
                if ($info['prom_id'] == 2) {
                    $info['prom_id_list'] = FullminusModel::getList();
                }
                if ($info['prom_id'] == 3) {
                    $info['prom_id_list'] = DiscountModel::getList();
                }
            }
        }else{
            $info['prom_id_list'] = BuysendModel::getList();
        }
        $guige_list=array();
        if(!empty($info['spec'])) {
            $g_list = explode(';', $info['spec']);

            foreach ($g_list as $v) {
                if (empty($v)) {
                    continue;
                }
                $item = array();
                $arr = explode('#', $v);
                $item['name'] = $arr[0];
                $arr_list = explode('|', $arr[1]);
                $item['s_list'] = array();
                foreach ($arr_list as $vi) {
                    if (!empty($vi)) {
                        $arr1 = explode(',', $vi);
                        $e['name'] = $arr1[0];
                        $e['gg_pic'] = isset($arr1[1]) ? intval($arr1[1]) : 0;
                        $item['s_list'][] = $e;
                    }
                }
                $guige_list[] = $item;
            }
        }



        $s_list = explode(';',$info['shuxing']);
        $shuxing_list =array();
        foreach ($s_list as  $v){
            if(empty($v)){
                continue;
            }
            $item = array();
            $arr = explode('|',$v);
            $item['sx_name'] = $arr[0];
            $item['sx_price'] = $arr[1];
            $item['sx_zhekou'] = $arr[2];
            $item['sx_sku'] = $arr[3];
            $item['sx_pic'] = $arr[4];
            $shuxing_list[]=$item;
        }

        return ZBuilder::make('form')
            ->assign('info',$info)
            ->assign('id',$id)
            ->assign('cate_list',CateModel::getAllList())
            ->assign('site_list',SiteModel::getAllList())
            ->assign('spec_list',$guige_list)
            ->assign('shuxing_list',$shuxing_list)
            ->setTemplate('edit')
            ->fetch();
    }


    /**产生不重复code
     * @param $goods_id
     * @return string
     */
    private function create_nums_str($goods_id){
        $code = GoodscodeModel::getCode($goods_id);
        if(!$code){
            if($goods_id<1000){
                $code = rand_str(2).$goods_id;
            }else{
                while (empty($code)){
                    $code = rand_str(5);
                    $code = GoodscodeModel::getCodeCount($code);
                }
            }
            $d['goods_id'] = $goods_id;
            $d['code'] = $code;
            GoodscodeModel::create($d);
        }
        return $code;
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


    public function save()
    {

        //保存数据
        $arr=array(
            'u6.gg',
            'c7.gg',
            'suo.im',
            'soso.bz'
        );
        //保存数据
        $ben_arr=array(
            'goodluck-3guys.com',
            'lucky3guys.com',
               'www.goodluck-3guys.com',
            'www.lucky3guys.com'
        );

        if ($this->request->isPost()) {
            $data = $this->request->post();
            if(empty($data['cid'])){
                $this->error('请选择分类');
            }
            if(empty($data['pics'])){
                $this->error('请上传商品图片');
            }
            $data['num'] = isset($data['num'])?intval($data['num']):0;
            if(empty($data['site_id'])){
                $this->error('请选站点');
            }
            $info = SiteModel::get($data['site_id']);
            if(empty($info)){
                $this->error('请先配置站点');
            }

            if(!in_array($info['url'],$arr)&&!in_array($info['url'],$ben_arr)){
                $this->error($info['url'].'暂时没有对接接口信息，无法使用');
            }
            if(!empty($data['id'])){
                $data['update_time'] = time();
                $data['pic'] = explode(',',$data['pics']);
                $data['pic'] = $data['pic'][0];
                $str_num = $this->create_nums_str($data['id']);
                $data['go_url']  = get_short_url($info['url'],$data['id'],$str_num);
                if(empty($data['go_url'])){
                    $this->error('url api error');
                }
                if($data['go_url']==-100){
                    $this->error('站点配置不能用');
                }

                if (false !==GoodsModel::where('id', $data['id'])->update($data)) {
                    $this->success('保存成功','index');
                } else {
                    $this->error('保存失败，请重试');
                }
            }else{
                $data['add_time'] = time();
                $data['pic'] = explode(',',$data['pics']);
                $data['pic'] = $data['pic'][0];
                $gid = GoodsModel::create($data);
                if (false !==$gid) {
                    $str_num = $this->create_nums_str($gid);
                    $go_url  = get_short_url($info['url'],$gid,$str_num);
                    $up['update_time'] = time();
                    $up['go_url'] =$go_url;
                    $res = GoodsModel::where('id',$gid)->update(array('update_time'=>time(),'go_url'=>$go_url));
                    if($res){
                        $this->success('新增成功','index');
                    }else{
                        $this->success('新增成功但是接口推广地址生成失败','index');
                    }

                } else {
                    $this->error('新增失败，请重试');
                }
            }
        }
    }





}