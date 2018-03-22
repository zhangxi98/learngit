package com.jsyh.onlineshopping.presenter;

import android.content.Context;

import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.config.SPConfig;
import com.jsyh.onlineshopping.http.BaseDelegate;
import com.jsyh.onlineshopping.http.OkHttpClientManager;
import com.jsyh.onlineshopping.model.PersonalModel;
import com.jsyh.onlineshopping.utils.SPUtils;
import com.jsyh.onlineshopping.views.PersonalView;
import com.squareup.okhttp.Request;

import java.util.Map;

/**
 * Created by Su on 2015/10/23.
 */
public class PersonalPresenter extends BasePresenter {
    private PersonalView mPersonalView;

    public PersonalPresenter(PersonalView mPersonalView) {
        this.mPersonalView = mPersonalView;
    }
    //获取个人初始化信息

    public void getPersonalInfo(Context context) {
        Map<String, String> params = getDefaultMD5Params("goods", "cartnum");
        String key = (String) SPUtils.get(context, "key", "");
        params.put(SPConfig.KEY, key);
        OkHttpClientManager.postAsyn(context, ConfigValue.InitPersonalInfo, params, new BaseDelegate.ResultCallback<PersonalModel>() {
            @Override
            public void onError(Request request, Object tag, Exception e) {

            }

            @Override
            public void onResponse(PersonalModel response, Object tag) {
                mPersonalView.onPersonalInfo(response);
            }
        });
    }
}
