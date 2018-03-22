package com.jsyh.onlineshopping.views;

import com.jsyh.onlineshopping.model.AddressModel;
import com.jsyh.onlineshopping.model.BaseModel;

/**
 * Created by sks on 2015/9/24.
 */
public interface AddressView {
    void getAddressList(AddressModel response);
    void delete(BaseModel model);
}
