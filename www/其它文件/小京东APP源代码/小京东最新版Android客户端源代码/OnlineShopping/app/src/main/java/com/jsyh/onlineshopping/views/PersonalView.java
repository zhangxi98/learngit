package com.jsyh.onlineshopping.views;

import com.jsyh.onlineshopping.model.PersonalModel;

/**
 * Created by Su on 2015/10/23.
 */
public interface PersonalView {

    void onPersonalInfo(PersonalModel response);
    //设置购物车角标数量
    void setCartGoodsNums(String nums);
    //角标增加
    void addCartGoodsNums(int nums);
}
