package com.jsyh.onlineshopping.adapter.category;

import android.content.Context;
import android.view.View;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.model.CategoryInfo;
import com.jsyh.shopping.uilibrary.adapter.listview.BaseAdapterHelper;
import com.jsyh.shopping.uilibrary.adapter.listview.MultiItemTypeSupport;
import com.jsyh.shopping.uilibrary.adapter.listview.QuickAdapter;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by momo on 2015/10/21.
 *
 * 一级分类  adapter
 */
public class CategoryTopAdapter extends QuickAdapter<CategoryInfo> {

    public CategoryTopAdapter(Context context, ArrayList<CategoryInfo> data, MultiItemTypeSupport<CategoryInfo> multiItemSupport) {
        super(context, data, multiItemSupport);
    }

    public CategoryTopAdapter(Context context, int layoutResId) {
        super(context, layoutResId);
    }

    public CategoryTopAdapter(Context context, int layoutResId, List<CategoryInfo> data) {
        super(context, layoutResId, data);
    }

    @Override
    protected void convert(BaseAdapterHelper helper, CategoryInfo item) {
        if (item.isChecked()) {
            helper.getView(R.id.ivRightLine).setVisibility(View.VISIBLE);
        }else {
            helper.getView(R.id.ivRightLine).setVisibility(View.GONE);

        }

        helper.getView(R.id.tvOneLevelName).setSelected(item.isChecked());

        helper.setText(R.id.tvOneLevelName, item.getClassify_name());
    }
}
