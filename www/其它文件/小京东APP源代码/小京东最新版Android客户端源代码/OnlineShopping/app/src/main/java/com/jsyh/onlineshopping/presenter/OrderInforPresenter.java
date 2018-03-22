package com.jsyh.onlineshopping.presenter;

import android.content.Context;

import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.http.BaseDelegate;
import com.jsyh.onlineshopping.http.ExceptionHelper;
import com.jsyh.onlineshopping.http.OkHttpClientManager;
import com.jsyh.onlineshopping.model.OrderInforModel;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.OrderInforView;
import com.squareup.okhttp.Request;

import java.util.Map;

/**
 * Created by sks on 2015/10/13.
 * 订单详情网络请求
 */
public class OrderInforPresenter extends BasePresenter {
    private OrderInforView orderInforView;
    public OrderInforPresenter(OrderInforView orderInforView){
        this.orderInforView = orderInforView;
    }
    public void loadOrderInfor(final Context context,String orderID){
        initLoadDialog(context);
        mLoadingDialog.show();
        Map<String, String> params = getDefaultMD5Params("order", "lorder");
        params.put("key", ConfigValue.DATA_KEY);
        params.put("order_id",orderID);
        OkHttpClientManager.postAsyn(context, ConfigValue.APP_IP + "order/lorder",
                params, new BaseDelegate.ResultCallback<OrderInforModel>() {
                    @Override
                    public void onError(Request request, Object tag, Exception e) {
                        mLoadingDialog.dismiss();
                        Utils.showToast(context, ExceptionHelper.getMessage(e, context));
                    }

                    @Override
                    public void onResponse(OrderInforModel response, Object tag) {
                        mLoadingDialog.dismiss();
                        orderInforView.result(response);
                    }
                },true);
    }
}
