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
class Delivery extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__ADMIN_DELIVERY__';

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
        $data_list = self::view('admin_delivery', true)
            ->view('admin_order', 'id,order_sn', 'admin_order.id=admin_delivery.order_id', 'left')
            ->where($map)
            ->order($order)
            ->paginate();
        return $data_list;
    }

    public static function getList($id=0)
    {
        // 数据列表
        $map['admin_delivery.status'] = 1;
        if($id){
            $map['admin_order.goods_id']=$id;
        }
        $data_list = self::view('admin_delivery', true)
            ->view('admin_order', 'order_sn,wfname,wfmob,wfemail,order_time', 'admin_delivery.order_id=admin_order.id', 'left')
            ->view('admin_goods', 'name', 'admin_goods.id=admin_order.goods_id', 'left')
            ->where($map)
            ->select();
//        $data_list = self::where($map)->column(true);
        return $data_list;
    }

}