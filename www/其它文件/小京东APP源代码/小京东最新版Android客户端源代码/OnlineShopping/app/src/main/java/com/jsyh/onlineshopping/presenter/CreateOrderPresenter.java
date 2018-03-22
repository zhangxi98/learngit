package com.jsyh.onlineshopping.presenter;

import android.content.Context;

import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.http.BaseDelegate;
import com.jsyh.onlineshopping.http.ExceptionHelper;
import com.jsyh.onlineshopping.http.OkHttpClientManager;
import com.jsyh.onlineshopping.model.CreateOrderModel;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.CreateOrderView;
import com.squareup.okhttp.Request;

import java.util.Map;

/**
 * Created by sks on 2015/10/8.
 * 获取新的订单信息
 */
public class CreateOrderPresenter extends BasePresenter {
    private CreateOrderView createOrderView;

    public CreateOrderPresenter(CreateOrderView createOrderView){
        this.createOrderView = createOrderView;
    }

    public void loadOrderInfor(final Context context,String goods_id,String bonus_id,
                               String address_id){
        initLoadDialog(context);
        mLoadingDialog.show();
        Map<String, String> params = getDefaultMD5Params("order", "confirm");
        params.put("key", ConfigValue.DATA_KEY);
        params.put("goods_id",goods_id);
        params.put("bonus_id",bonus_id);
        params.put("address_id",address_id);
//        params.put("number", number);
        OkHttpClientManager.postAsyn(context, ConfigValue.APP_IP + "order/confirm",
                params, new BaseDelegate.ResultCallback<CreateOrderModel>() {
                    @Override
                    public void onError(Request request, Object tag, Exception e) {
                        mLoadingDialog.dismiss();
                        Utils.showToast(context, ExceptionHelper.getMessage(e, context));
                    }

                    @Override
                    public void onResponse(CreateOrderModel response, Object tag) {
                        mLoadingDialog.dismiss();
                        createOrderView.getOrderInfor(response);
                    }
                },true);
    }
}
