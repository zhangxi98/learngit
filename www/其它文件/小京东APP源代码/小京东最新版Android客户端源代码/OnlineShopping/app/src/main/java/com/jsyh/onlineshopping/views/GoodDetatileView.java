package com.jsyh.onlineshopping.views;

import android.support.annotation.Nullable;

import com.jsyh.onlineshopping.model.BaseModel;
import com.jsyh.onlineshopping.model.GoodsInfoModel2;
import com.jsyh.onlineshopping.model.GoodsInfoModel2.Attribute;

import java.util.List;

public interface GoodDetatileView extends BaseView {
    void albumData(String[] albums);// 商品相册信息

    void contentData(List<String> content);// 图文信息

    void attributeData(List<Attribute> attributes);// 属性信息

    void paramData(String param);// 基本参数


    void onLoadGoodsInfoDatas(@Nullable GoodsInfoModel2 datas);

    /**
     * 加入购物车回调
     *
     * @param data
     */
    void onAddCarShopping(@Nullable BaseModel data);

    /**
     * 收藏商品
     *
     * @param data
     */
    void onCollectGoods(BaseModel data);

    /**
     * 取消收藏商品
     *
     * @param data
     */
    void cancelCollectGoods(BaseModel data);
}
