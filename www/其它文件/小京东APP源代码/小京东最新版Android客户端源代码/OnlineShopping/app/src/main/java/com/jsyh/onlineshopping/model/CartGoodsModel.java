package com.jsyh.onlineshopping.model;

import java.util.List;

/**
 * Created by Pisces on 2015/10/9.
 */
public class CartGoodsModel extends BaseModel {
    private List<CartGoods> data;

    public List<CartGoods> getData() {
        return data;
    }

    public void setData(List<CartGoods> data) {
        this.data = data;
    }
}
