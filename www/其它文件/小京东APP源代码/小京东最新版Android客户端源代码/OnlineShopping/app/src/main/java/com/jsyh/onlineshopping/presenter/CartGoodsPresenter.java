package com.jsyh.onlineshopping.presenter;

import android.content.Context;
import android.util.Log;

import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.config.SPConfig;
import com.jsyh.onlineshopping.http.BaseDelegate;
import com.jsyh.onlineshopping.http.ExceptionHelper;
import com.jsyh.onlineshopping.http.OkHttpClientManager;
import com.jsyh.onlineshopping.model.BaseModel;
import com.jsyh.onlineshopping.model.CartGoodsModel;
import com.jsyh.onlineshopping.utils.SPUtils;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.CartGoodsView;
import com.squareup.okhttp.Request;

import java.util.Map;

/**
 * Created by Su on 2015/10/9.
 * 获取购物车商品列表
 */
public class CartGoodsPresenter extends BasePresenter {
    private CartGoodsView cartGoodsView;

    public CartGoodsPresenter(CartGoodsView cartGoodsView) {
        this.cartGoodsView = cartGoodsView;
    }

    /**
     * 获取购物车列表
     *
     * @param context
     */
    public void getCartGoodsData(final Context context,boolean flag) {
        initLoadDialog(context);
        if(flag){
            mLoadingDialog.show();
        }
        Map<String, String> params = getDefaultMD5Params("goods", "cartlist");
        String key = (String) SPUtils.get(context, "key", "");
        params.put(SPConfig.KEY, key);

        OkHttpClientManager.postAsyn(context, ConfigValue.CartGoodsList, params,
                new BaseDelegate.ResultCallback<CartGoodsModel>() {
                    @Override
                    public void onError(Request request, Object tag, Exception e) {
                        if(mLoadingDialog.isShowing())
                        mLoadingDialog.dismiss();
                        Utils.showToast(context, "getCartGoodsDataError" + ExceptionHelper.getMessage(e, context));
                    }

                    @Override
                    public void onResponse(CartGoodsModel response, Object tag) {
                        if(mLoadingDialog.isShowing())
                        mLoadingDialog.dismiss();
                        cartGoodsView.getCartGoodsList(response);
                    }
                });

    }

    /**
     * 修改商品数量
     *
     * @param context
     * @param recId       购物车商品唯一标识
     * @param goodsNumber 商品数量
     */
    public void alterCartGoodsNumber(final Context context, String recId, int goodsNumber) {
        Map<String, String> params = getDefaultMD5Params("goods", "charnum");
        String key = (String) SPUtils.get(context, "key", "");
        params.put(SPConfig.KEY, key);
        params.put("rec_id", recId);
        params.put("num", String.valueOf(goodsNumber));

        OkHttpClientManager.postAsyn(context, ConfigValue.AlterGoodsNumber, params,
                new BaseDelegate.ResultCallback<BaseModel>() {
                    @Override
                    public void onError(Request request, Object tag, Exception e) {
                        Utils.showToast(context, "alterCartGoodsNumberError" + e);
                    }

                    @Override
                    public void onResponse(BaseModel response, Object tag) {
                        Log.d("altergoodsnumber", response.toString());
                        cartGoodsView.alterCartGoodsNumber(response);
                    }
                });

    }

    /**
     * 购物车中删除商品
     *
     * @param context
     * @param recId
     */
    public void deleteCartGoods(final Context context, String recId) {
        initLoadDialog(context);
        mLoadingDialog.show();
        Map<String, String> params = getDefaultMD5Params("goods", "delcart");
        String key = (String) SPUtils.get(context, "key", "");
        params.put(SPConfig.KEY, key);
        params.put("rec_id", recId);

        OkHttpClientManager.postAsyn(context, ConfigValue.DeleteCartGoods, params,
                new BaseDelegate.ResultCallback<BaseModel>() {
                    @Override
                    public void onError(Request request, Object tag, Exception e) {
                        mLoadingDialog.dismiss();
                        Utils.showToast(context, "deleteCartGoodsNumberError" + ExceptionHelper.getMessage(e, context));
                    }

                    @Override
                    public void onResponse(BaseModel response, Object tag) {
                        Log.d("deleteCartGoods", response.toString());
                        mLoadingDialog.dismiss();
                        cartGoodsView.deleteCartGoods(response);
                    }
                });
    }


}
