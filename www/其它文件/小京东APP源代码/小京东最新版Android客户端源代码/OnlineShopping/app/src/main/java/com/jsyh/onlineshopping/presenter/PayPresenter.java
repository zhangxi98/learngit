package com.jsyh.onlineshopping.presenter;

import android.content.Context;

import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.http.BaseDelegate;
import com.jsyh.onlineshopping.http.ExceptionHelper;
import com.jsyh.onlineshopping.http.OkHttpClientManager;
import com.jsyh.onlineshopping.model.PayModel;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.PayView;
import com.squareup.okhttp.Request;

import java.util.Map;

/**
 * Created by sks on 2015/10/22.
 * 支付
 */
public class PayPresenter extends BasePresenter {
    
    private PayView payView;

    public PayPresenter(PayView payView){
        this.payView = payView;
    }

    /**
     *
     * @param context
     * @param type          //支付类型
     * @param orderId       //订单id
     */
    public void setPay(final Context context,String type,String orderId){
        initLoadDialog(context);
        mLoadingDialog.show();
        Map<String,String> params = getDefaultMD5Params("order", "pay");
        params.put("key", ConfigValue.DATA_KEY);
        params.put("order_id",orderId);
        params.put("type",type);
        OkHttpClientManager.postAsyn(context, ConfigValue.APP_IP + "order/pay", params,
                new BaseDelegate.ResultCallback<PayModel>() {
                    @Override
                    public void onError(Request request, Object tag, Exception e) {
                        mLoadingDialog.dismiss();
                        Utils.showToast(context, ExceptionHelper.getMessage(e, context));
                    }

                    @Override
                    public void onResponse(PayModel response, Object tag) {
                        mLoadingDialog.dismiss();
                        payView.result(response);
                    }
                });
    }
}
