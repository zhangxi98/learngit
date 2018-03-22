package com.jsyh.onlineshopping.views;

import com.jsyh.onlineshopping.model.CreateOrderModel;
import com.jsyh.onlineshopping.model.SubmitOrderModel;

/**
 * Created by sks on 2015/10/8.
 */
public interface CreateOrderView {
    void getOrderInfor(CreateOrderModel model);
    void result(SubmitOrderModel model);
}
