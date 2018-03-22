package com.jsyh.onlineshopping.presenter;

import android.content.Context;

import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.http.BaseDelegate;
import com.jsyh.onlineshopping.http.ExceptionHelper;
import com.jsyh.onlineshopping.http.OkHttpClientManager;
import com.jsyh.onlineshopping.model.BaseModel;
import com.jsyh.onlineshopping.utils.Utils;
import com.squareup.okhttp.Request;

import java.util.Map;

/**
 * Created by sks on 2015/9/24.
 */
public class ChangePasswordPresenter extends BasePresenter {
    private Context context;
    public ChangePasswordPresenter(Context context){
        this.context = context;
    }

    public void submitChangeInfor(String name,String oldpass,String pass){
        initLoadDialog(context);
        mLoadingDialog.show();
        Map<String, String> params = getDefaultMD5Params("user", "modifypasswd");
        params.put("key", ConfigValue.DATA_KEY);
        params.put("username",name);
        params.put("user_pwd",oldpass);
        params.put("new_pwd",pass);
        OkHttpClientManager.postAsyn(context, ConfigValue.APP_IP + "user/modifypasswd",
                params, new BaseDelegate.ResultCallback<BaseModel>() {
                    @Override
                    public void onError(Request request, Object tag, Exception e) {
                        mLoadingDialog.dismiss();
                        Utils.showToast(context, ExceptionHelper.getMessage(e, context));
                    }

                    @Override
                    public void onResponse(BaseModel response, Object tag) {
                        mLoadingDialog.dismiss();
                        Utils.showToast(context,response.getMsg());
                    }
                },true);
    }
}
