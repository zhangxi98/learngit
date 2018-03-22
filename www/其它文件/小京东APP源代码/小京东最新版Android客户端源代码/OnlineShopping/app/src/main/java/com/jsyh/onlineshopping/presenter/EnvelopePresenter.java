package com.jsyh.onlineshopping.presenter;

import android.content.Context;

import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.http.BaseDelegate;
import com.jsyh.onlineshopping.http.ExceptionHelper;
import com.jsyh.onlineshopping.http.OkHttpClientManager;
import com.jsyh.onlineshopping.model.BounsModel;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.EnvelopeView;
import com.squareup.okhttp.Request;

import java.util.Map;

/**
 * Created by sks on 2015/10/12.
 * 获取红包列表
 */
public class EnvelopePresenter extends BasePresenter {
    private EnvelopeView envelopeView;
    public EnvelopePresenter(EnvelopeView envelopeView){
        this.envelopeView = envelopeView;
    }

    /**
     *
     * @param context
     * @param money   订单的总价格
     */
    public void request(final Context context,String money){
        initLoadDialog(context);
        mLoadingDialog.show();
        Map<String, String> params = getDefaultMD5Params("order", "bouns");
        params.put("key", ConfigValue.DATA_KEY);
        params.put("money",money);
        OkHttpClientManager.postAsyn(context, ConfigValue.APP_IP + "order/bouns",
                params, new BaseDelegate.ResultCallback<BounsModel>() {
                    @Override
                    public void onError(Request request, Object tag, Exception e) {
                        mLoadingDialog.dismiss();
                        Utils.showToast(context, ExceptionHelper.getMessage(e, context));
                    }

                    @Override
                    public void onResponse(BounsModel response, Object tag) {
                        mLoadingDialog.dismiss();
                        envelopeView.result(response);
                    }
                },true);
    }
}
