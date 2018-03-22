package com.jsyh.onlineshopping.presenter;

import android.content.Context;

import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.http.BaseDelegate;
import com.jsyh.onlineshopping.http.ExceptionHelper;
import com.jsyh.onlineshopping.http.OkHttpClientManager;
import com.jsyh.onlineshopping.model.SubmitOrderModel;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.CreateOrderView;
import com.squareup.okhttp.Request;

import java.util.Map;

/**
 * Created by sks on 2015/10/12.
 */
public class SubmitOrderPresenter extends BasePresenter {
    private CreateOrderView createOrderView;
    public SubmitOrderPresenter(CreateOrderView createOrderView){
        this.createOrderView = createOrderView;
    }

    /**
     *
     * @param context
     * @param goods_id       商品id
     * @param address_id     收获地址id
     * @param amount         商品总金额
     * @param money_paid     实际付费
     * @param shipping_fee   配送费用
     * @param expressage_id  配送方式id
     * @param redpacket      使用红包类型金额
     * @param bonus_id       红包id
     * @param bonus_type_id  红包类型id
     * @param message        订单留言
     * @param integral       积分可抵的金额
     * @param goods_attr_id  产品属性id
     * @param type           区分是直接购买还是从购物车购买 0：购物车，1：直接购买
     */
    public void request(final Context context,String goods_id,String address_id,String amount,
                        String money_paid,String shipping_fee,String expressage_id,
                        String redpacket,String bonus_id,String bonus_type_id,
                        String message,String integral,String goods_attr_id,String type){
        Map<String, String> params = getDefaultMD5Params("order", "create");
        params.put("key", ConfigValue.DATA_KEY);
        params.put("goods_id",goods_id);
        params.put("address_id",address_id);
        params.put("amount",amount);
        params.put("money_paid",money_paid);
        params.put("shipping_fee",shipping_fee);
        params.put("expressage_id",expressage_id);
        params.put("redpacket",redpacket);
        params.put("bonus_id",bonus_id);
        params.put("bonus_type_id",bonus_type_id);
        params.put("message",message);
        params.put("integral",integral);
        params.put("goods_attr_id",goods_attr_id);
        params.put("type",type);
        OkHttpClientManager.postAsyn(context, ConfigValue.APP_IP + "order/create",
                params, new BaseDelegate.ResultCallback<SubmitOrderModel>() {
                    @Override
                    public void onError(Request request, Object tag, Exception e) {
                        Utils.showToast(context, ExceptionHelper.getMessage(e, context));
                    }

                    @Override
                    public void onResponse(SubmitOrderModel response, Object tag) {
                        createOrderView.result(response);
                    }
                },true);
    }
}
