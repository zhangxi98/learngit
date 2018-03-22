package com.jsyh.onlineshopping.presenter;

import android.content.Context;

import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.http.BaseDelegate;
import com.jsyh.onlineshopping.http.ExceptionHelper;
import com.jsyh.onlineshopping.http.OkHttpClientManager;
import com.jsyh.onlineshopping.model.BaseModel;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.SendCodeView;
import com.squareup.okhttp.Request;

import java.util.Map;

/**
 * Created by sks on 2015/9/29.
 * 发送验证码
 */
public class SendCodePresenter extends BasePresenter {
    private SendCodeView sendCodeView;
    public SendCodePresenter(SendCodeView sendCodeView){
        this.sendCodeView = sendCodeView;
    }
    public void setSendCodeView(final Context context,String name,String email){
        initLoadDialog(context);
        mLoadingDialog.show();
        Map<String,String> params = getDefaultMD5Params("user","send");
        params.put("username",name);
        params.put("email",email);
        OkHttpClientManager.postAsyn(context, ConfigValue.APP_IP + "user/send",
                params, new BaseDelegate.ResultCallback<BaseModel>() {
                    @Override
                    public void onError(Request request, Object tag, Exception e) {
                        mLoadingDialog.dismiss();
                        Utils.showToast(context, ExceptionHelper.getMessage(e, context));
                    }

                    @Override
                    public void onResponse(BaseModel response, Object tag) {
                        mLoadingDialog.dismiss();
                        sendCodeView.getCode(response);
                    }
                },true);
    }
}
