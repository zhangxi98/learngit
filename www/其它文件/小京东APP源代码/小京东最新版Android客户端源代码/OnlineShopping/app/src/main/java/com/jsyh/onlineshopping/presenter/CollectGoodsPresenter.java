package com.jsyh.onlineshopping.presenter;

import android.content.Context;

import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.config.SPConfig;
import com.jsyh.onlineshopping.http.BaseDelegate;
import com.jsyh.onlineshopping.http.OkHttpClientManager;
import com.jsyh.onlineshopping.model.CartGoodsModel;
import com.jsyh.onlineshopping.utils.SPUtils;
import com.jsyh.onlineshopping.views.CollectGoodsView;
import com.squareup.okhttp.Request;

import java.util.Map;

/**
 * Created by Su on 2015/10/20.
 */
public class CollectGoodsPresenter extends BasePresenter {

    private CollectGoodsView mCollectGoodsView;

    private Context mContext;


    public CollectGoodsPresenter(Context mContext) {
        this.mContext = mContext;
        this.mCollectGoodsView = (CollectGoodsView) mContext;
    }


    /**
     * 关注商品列表
     */
    public void getCollectList() {
        Map<String, String> params = getDefaultMD5Params("goods", "collectlist");
        String key = (String) SPUtils.get(mContext, "key", "");

        params.put(SPConfig.KEY, key);

        OkHttpClientManager.postAsyn(mContext, ConfigValue.CollectGoodsList, params,
                new BaseDelegate.ResultCallback<CartGoodsModel>() {
                    @Override
                    public void onError(Request request, Object tag, Exception e) {

                    }

                    @Override
                    public void onResponse(CartGoodsModel response, Object tag) {
                        mCollectGoodsView.getCollectList(response);
                    }
                });
    }
}
