package com.jsyh.onlineshopping.presenter;

import android.content.Context;
import android.support.annotation.Nullable;

import com.google.gson.JsonParseException;
import com.google.gson.JsonSyntaxException;
import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.http.BaseDelegate;
import com.jsyh.onlineshopping.http.OkHttpClientManager;
import com.jsyh.onlineshopping.model.CategoryInfoModel;
import com.jsyh.onlineshopping.utils.L;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.CategoryView;
import com.squareup.okhttp.Request;

import java.net.ConnectException;
import java.util.Map;

/**
 * 分类 P layer
 */
public class CategoryPresenter extends BasePresenter{



    public static final int one_level = 0;
    public static final int two_level = 1;


    private CategoryView mCategoryView;

    private String tag;


    public CategoryPresenter(CategoryView mCategoryView) {
        this.mCategoryView = mCategoryView;
    }


    /**
     * 获得分类信息，
     *
     * @param level
     *              <p>0顶级分了，1子分类</p>
     *
     * @param parentId
     *             <p> 当type=1时必须传递</p>
     */
    public void loadCategoryByType(Context context , final int level ,@Nullable Integer parentId ) {


        if (Utils.NO_NETWORK_STATE == Utils.isNetworkAvailable(context)) {

            switch (level) {
                case one_level:
                    mCategoryView.onOneLevelData(null,new ConnectException());

                    break;

                case two_level:
                    mCategoryView.onTwoLevelData(null,new ConnectException());
                    break;

            }

            return;
        }


        if (level == 1 && parentId < 0) {

            return;
        }


        Map<String, String> params = getDefaultMD5Params("first", "classify");
        if (params == null) return;

        params.put("type", level + "");
        if (level == 1 && parentId != null) {

            params.put("prent_id", parentId+"");

        }
        if (mLoadingDialog == null) {
            initLoadDialog(context);
        }

        if (two_level == level) {

            mLoadingDialog.show();
        }

        setTag("category" + level);
        OkHttpClientManager.postAsyn(context, ConfigValue.CATEGORY, params, new BaseDelegate.ResultCallback<CategoryInfoModel>() {
            @Override
            public void onError(Request request, Object tag, Exception e) {
                if (e instanceof JsonParseException) {

                    mLoadingDialog.dismiss();

                    L.d("parse error");
                }else if (e instanceof JsonSyntaxException) {
                    L.d("syntax error");

                }
            }

            @Override
            public void onResponse(CategoryInfoModel response, Object tag) {


                switch (level) {
                    case one_level:

                        mCategoryView.onOneLevelData(response,null);
                        break;

                    case two_level:


                        mLoadingDialog.dismiss();

                        mCategoryView.onTwoLevelData(response,null);

                        break;
                }
            }


        },"category"+level);
//"category"+level
    }


    public String getTag() {
        return tag;
    }

    public void setTag(String tag) {
        this.tag = tag;
    }
}
