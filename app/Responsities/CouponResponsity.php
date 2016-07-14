<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/21
 * Time: 9:26
 */
namespace App\Responsities;

use DB;

class CouponResponsity {

    /**
     * 获取优惠卷 ()
     */
    public function getCoupon ($userid, $paper_id, $for_reg = false) {
        //获取优惠券池里剩余数量
        $left_num = $this->_getLeftNum();

        if($left_num < 10) {
            $this->_create();
        }

        $coupon = DB::table('x2_coupon')->whereNull('userid')
                                        ->where('couponstatus', 0)
                                        ->first();

        $couponsn = $coupon->couponsn;


        try {
            DB::transaction (function () use ($userid, $paper_id, $couponsn, $for_reg) {

                $ttl = config('yjt.coupon.ttl');
                $couponaddtime = time();
                $couponendtime = $couponaddtime + $ttl;

                if ($for_reg) {
                    if (config('yjt.coupon.reg')) {
                        $res = DB::table('x2_coupon')->where('couponsn', $couponsn)
                                    ->update([
                                        'userid' => $userid,
                                        'paper_id' => 0,
                                        'couponaddtime' => $couponaddtime,
                                        'couponendtime' => $couponendtime
                                    ]);
                    }
                } else {
                    $paper = DB::table('x2_paper')->find($paper_id);
                    $scored = $paper->scored;
                    if ($scored >= config('yjt.coupon.min_scored')) {
                        DB::table('x2_paper')->where('id', $paper_id)->update(['status' => 2]);
                        $res = DB::table('x2_coupon')->where('couponsn', $couponsn)
                            ->update([
                                'userid' => $userid,
                                'paper_id' => $paper_id,
                                'couponaddtime' => $couponaddtime,
                                'couponendtime' => $couponendtime
                            ]);
                    }
                }

                if(!$res) {
                    throw new \Exception('领取失败');
                }

            });
        } catch (\Exception $e) {
            throw new \Exception('领取失败, 稍后重试');
        }

    }

    /**
     * 优惠券列表
     */
    public function getList ($userid) {
        $list = DB::table('x2_coupon')->where([
            ['userid', $userid],
            ['couponstatus', 0]
        ])->get();

        return $list;

    }

    /**
     * 试题练习应该获取的优惠券额度
     */
    public function countCoupon ($score) {
        if ($score >= config('yjt.coupon.min_scored')) {
            return config('yjt.coupon.value');
        } else {
            return 0;
        }
    }

    /**
     * 优惠券剩余数量
     */
    private function _getLeftNum () {
        $coupon = DB::table('x2_coupon')->select(DB::raw('count(*) as left_num'))
                                    ->whereNull('userid')
                                    ->where('couponstatus', 0)
                                    ->first();
        $left_num = $coupon->left_num;
        return $left_num;
    }

    /**
     * 在优惠券池中生成新数据
     */
    private function _create () {

    }

}