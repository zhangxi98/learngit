package com.jsyh.onlineshopping.config;

import android.os.Environment;

import com.jsyh.onlineshopping.model.UserInfor;

import java.io.File;

/**
 * Created by sks on 2015/9/17.
 */
public class ConfigValue {
    // 请求服务器 成功code
    public static final String Success_Code = "1";
    // 请求服务器失败code
    public static final String Error_Code = "0";

    /**
     * 商品详情页修改购物车数量发送广播
     */
    public static final String ACTION_ALTER_CARTGOODS_NUMS = "com.jsyh.onlineshopping.activity.mainactivity";

    //        public static final String APP_IP = "http://shopapi.99-k.com/shopapi/index.php/";
//    public static final String APP_IP = "http://192.168.1.134/jingdong/index.php/";
//    public static final String IMG_IP = "http://shopapi.99-k.com/ecshop/";
    //请求服务器地址
    public static final String APP_IP = "http://demo1.ishopv.com/shopapi/index.php/";
    //app中图片获取的地址，和得到的数据拼接使用
    public static final String IMG_IP = "http://demo1.ishopv.com/";
    //首页html5的地址
    public static final String MAIN_URL = "http://demo1.ishopv.com/shopapi/index.php/goods_index";

    public static final String DESCRIPTOR = "com.jsyh.onlineshopping";

    //腾讯appid
    public static final String QQAPP_ID = "1104912240";
    //腾讯appkey
    public static final String QQAPP_KEY = "dWfNU8NjY99GJ2y9";
    //微信appid
    public static final String WXAPP_ID = "wx1aa1a833d7810a8f";
    //微信appsecret
    public static final String WXAPP_SECRET = "ea9fe2139c93560cebecfa0ca85e6e69";
    //用户个人资料
    public static UserInfor uInfor = null;
    //请求数据用到的key
    public static String DATA_KEY = "";
    public static final String GoodsInfo = APP_IP + "goods/goodsInfo";

    /**
     * 热搜
     */
    public static final String HOT_SEARCH = APP_IP + "first/keywords";
    /**
     * 加入购物车
     */
    public static final String ADD_CART_SHOPPING = APP_IP + "goods/addcart";
    /**
     * 收藏商品
     */
    public static final String COLLECT_GOODS = APP_IP + "goods/collect";
    /**
     * 取消收藏商品
     */
    public static final String NOCOLLECT_GOODS = APP_IP + "goods/qcollect";

    //购物车列表
    public static final String CartGoodsList = APP_IP + "goods/cartlist";
    //修改商品数量
    public static final String AlterGoodsNumber = APP_IP + "goods/charnum";
    //购物车中删除商品
    public static final String DeleteCartGoods = APP_IP + "goods/delcart";
    //关注商品列表
    public static final String CollectGoodsList = APP_IP + "goods/collectlist";
    //初始化个人信息
    public static final String InitPersonalInfo = APP_IP + "goods/cartnum";
    /**
     * 分类
     */
    public static final String CATEGORY = APP_IP + "first/classify";


    /**
     * 筛选 filter
     */
    public static final String CATEGORY_FILTER = APP_IP + "first/index";

    public static int iconFlag = 0;//用来改变购物车图片的标识，0：未选中，1：选中

    public static final String HEAD_PHOTO_DIR = Environment.getExternalStorageDirectory()
            .getPath() + File.separator + "onlineshopping" + File.separator + "avatar";

}
