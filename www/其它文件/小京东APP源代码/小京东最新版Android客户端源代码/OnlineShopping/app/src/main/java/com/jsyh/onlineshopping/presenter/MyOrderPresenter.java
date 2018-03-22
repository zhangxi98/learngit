package com.jsyh.onlineshopping.presenter;

import android.content.Context;

import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.http.BaseDelegate;
import com.jsyh.onlineshopping.http.ExceptionHelper;
import com.jsyh.onlineshopping.http.OkHttpClientManager;
import com.jsyh.onlineshopping.model.OrderModel;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.MyOrderView;
import com.squareup.okhttp.Request;

import java.util.Map;

/**
 * Created by sks on 2015/9/29.
 */
public class MyOrderPresenter extends BasePresenter {
    private MyOrderView myOrderView;
    public MyOrderPresenter(MyOrderView myOrderView){
        this.myOrderView = myOrderView;
    }

    public void loadOrder(final Context context,String model,String action){
        initLoadDialog(context);
        mLoadingDialog.show();
        Map<String, String> params = getDefaultMD5Params(model, action);
        params.put("key", ConfigValue.DATA_KEY);
        OkHttpClientManager.postAsyn(context, ConfigValue.APP_IP + model+"/" + action,
                params, new BaseDelegate.ResultCallback<OrderModel>() {
                    @Override
                    public void onError(Request request, Object tag, Exception e) {
                        mLoadingDialog.dismiss();
                        Utils.showToast(context, ExceptionHelper.getMessage(e,context));
                        myOrderView.error();
                    }

                    @Override
                    public void onResponse(OrderModel response, Object tag) {
                        mLoadingDialog.dismiss();
                        myOrderView.orderList(response);
                    }
                },true);
    }
}
