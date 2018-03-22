package com.jsyh.onlineshopping.views;

import com.jsyh.onlineshopping.model.LoginModel;

/**
 * Created by Administrator on 2015/8/31.
 */
public interface LoginView {
    void to_register();
    void to_main();
    void to_forget();
    void login(LoginModel model);
}
