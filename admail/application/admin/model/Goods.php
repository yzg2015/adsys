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

namespace app\admin\model;
use think\Model;
/**
 * 日志记录模型
 * @package app\admin\model
 */
class Goods extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__ADMIN_GOODS__';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    /**
     * 获取所有日志
     * @param array $map 条件
     * @param string $order 排序
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public static function getAll($map = [], $order = '')
    {
        $data_list = self::view('admin_goods', true)
            ->view('admin_site', 'url,title', 'admin_site.id=admin_goods.site_id', 'left')
            ->where($map)
            ->order($order)
            ->paginate();

        return $data_list;
    }

    public static function getTreeList()
    {
        $map['status']=1;
        $data_list = self::where($map)
            ->column('id,name');
        return  $data_list;
    }



    public static function getAllList($cate_id=0)
    {
        $map['status']=1;
        if($cate_id){
            $map['cid'] = $cate_id;
        }
        $data_list = self::where($map)
            ->column('id,name,price,z_price,num,pic,cid');
        return  $data_list;
    }

    public static function getSeaList($key)
    {
        if(empty($key)){
            return array();
        }
        $data_list = self::where('name','like',"%$key%")
            ->column('id,name,price,z_price,num,pic,cid');
        return  $data_list;
    }
}