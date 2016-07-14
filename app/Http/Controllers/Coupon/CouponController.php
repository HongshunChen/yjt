<?php

namespace App\Http\Controllers\Coupon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Plugins\Valid\Valid;
use App\Responsities\CouponResponsity;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Model\Exam\Paper;

class CouponController extends Controller
{

    //领取优惠券 (试卷相关)
    public function getCoupon (Request $request, Valid $valid, CouponResponsity $coupon_r) {
        $valid->rule($request, [
            'paper_id' => 'require|integer@试卷'
        ]);
        $paper_id = $request->input('paper_id');

        $paper = Paper::find($paper_id);

        if(!$paper) {
            throw new \Exception('试卷不存在');
        }
        $status = $paper->status;
        switch ($status) {
            case 0:
                throw new \Exception('该试卷还没交卷');
                break;
            case 1:
                $user = JWTAuth::parseToken()->authenticate();
                $userid = $user->userid;
                $coupon_r->getCoupon($userid, $paper_id);
                break;
            case 2:
                throw new \Exception('该试卷已领取过代金券');
                break;
            default:
                throw new \Exception('领取错误');
                break;
        }

        return $this->succ($request);

    }

    /**
     * 获取优惠券列表
     */
    public function getList (Request $request, CouponResponsity $coupon_r) {
        $user = JWTAuth::parseToken()->authenticate();
        $userid = $user->userid;

        $list = $coupon_r->getList($userid);

        return $this->succ($request, $list);

    }

    //领取优惠券
//	public function getCoupon (Request $request, Valid $valid) {
//		$valid->rule($request, [
//			'paper_id' => 'require|integer@试卷'
//		]);
//		$user = JWTAuth::parseToken()->authenticate();
//		$userid = $user->userid;
//
//		$paper = Paper::find($request->input('paper_id'));
//
//		$status = $paper->status;
//		switch ($status) {
//			case 0:
//				throw new \Exception('该试卷没有提交');
//				break;
//			case 1:
//				try {
//					DB::transaction(function () use ($userid, $paper) {
//						$paper->status = 2;
//						$paper->save();
//						$scored = $paper->scored;
//
//						$couponsn = date('dHis').rand(1000, 9999);
//						$couponvalue = $this->_countCoupon($scored);
//						$couponstatus = 0;
//						$couponaddtime = time();
//						$couponendtime = $couponaddtime + (10 * 24 * 60 * 60);
//						$paper_id = $paper->id;
//
//						$params = [$couponsn, $userid, $couponvalue, $couponstatus, $couponaddtime, $couponendtime, $paper_id];
//						DB::insert('insert into
//										x2_coupon
//									set
//										couponsn=?,userid=?,couponvalue=?,couponstatus=?,
//										couponaddtime=?,couponendtime=?,paper_id=?'
//									,$params
//						);
//					});
//
//					return $this->succ($request);
//
//				} catch (\Exception $e) {
//					throw new \Exception('领取失败');
//				}
//				break;
//			case 2:
//				throw new \Exception('已经领取过');
//				break;
//			default:
//				throw new \Exception('领取失败');
//				break;
//		}
//
//	}

}
