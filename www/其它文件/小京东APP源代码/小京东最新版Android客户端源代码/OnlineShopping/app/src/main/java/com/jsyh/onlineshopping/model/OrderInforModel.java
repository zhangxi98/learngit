package com.jsyh.onlineshopping.model;

import java.util.List;

/**
 * Created by sks on 2015/10/13.
 */
public class OrderInforModel extends BaseModel {
    private List<OrderInfor> data;

    public List<OrderInfor> getData() {
        return data;
    }

    public void setData(List<OrderInfor> data) {
        this.data = data;
    }
}
