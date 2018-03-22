package com.jsyh.onlineshopping.fragment;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.GoodsFilterActivity;
import com.jsyh.onlineshopping.adapter.category.CategorySubAdapter;
import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.model.CategoryAdvInfo;
import com.jsyh.onlineshopping.model.CategoryInfo;
import com.jsyh.onlineshopping.model.CategoryInfoModel;
import com.jsyh.shopping.uilibrary.button.FloatingActionButton;
import com.jsyh.shopping.uilibrary.recycler.RecyclerViewHeader;

import java.util.List;

import cn.lightsky.infiniteindicator.InfiniteIndicatorLayout;
import cn.lightsky.infiniteindicator.slideview.BaseSliderView;
import cn.lightsky.infiniteindicator.slideview.DefaultSliderView;


public class CategorySubFragment extends Fragment implements
        View.OnClickListener, BaseSliderView.OnSliderClickListener {

    private static final String         ARG_PARAM1 = "param1";
    private CategoryInfoModel           mDatas;         //数据


    private View                        mRootView;
    private RecyclerView                mRecycler;      //商品列表
    private RecyclerViewHeader          mRecyclerHeader;
    private CategorySubAdapter          mCategoryAdapter;
    private List<CategoryInfo>          mCategoryInfos;


    private InfiniteIndicatorLayout     mAdvlayout;
    private List<CategoryAdvInfo>       mUrls;



    private FloatingActionButton mFab;



    public static CategorySubFragment newInstance(CategoryInfoModel data) {
        CategorySubFragment fragment = new CategorySubFragment();
        Bundle args = new Bundle();
        args.putParcelable(ARG_PARAM1, data);
        fragment.setArguments(args);
        return fragment;
    }

    public CategorySubFragment() {
        // Required empty public constructor
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            mDatas = getArguments().getParcelable(ARG_PARAM1);
            mUrls = mDatas.getData().getProduct();
            mCategoryInfos = mDatas.getData().getClassify();
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        mRootView = inflater.inflate(R.layout.category_sub_fragment, container, false);
        mFab = (FloatingActionButton) mRootView.findViewById(R.id.fabCategory);
        mFab.hide();
        mFab.setOnClickListener(this);


        setupViews(mRootView);

        mFab.attachToRecyclerView(mRecycler);


        mAdvlayout = (InfiniteIndicatorLayout) mRootView.findViewById(R.id.indicatorLayout);

        if (mUrls != null && mUrls.size() > 0){

            for (CategoryAdvInfo url : mUrls) {
                if (!TextUtils.isEmpty(url.getGoods_thumb())){

                    DefaultSliderView textSliderView = new DefaultSliderView(getContext());
                    textSliderView
                            .image(ConfigValue.IMG_IP+url.getGoods_thumb())
                            .setScaleType(BaseSliderView.ScaleType.Fit)
                            .setOnSliderClickListener(this);
                    textSliderView.getBundle()
                            .putString("extra",url.getGoods_name());

                    mAdvlayout.addSlider(textSliderView);
                }
            }
            mAdvlayout.setDirection(5000);
            mAdvlayout.setIndicatorPosition(InfiniteIndicatorLayout.IndicatorPosition.Right_Bottom);
        }



        return mRootView;
    }

    @Override
    public void onResume() {
        super.onResume();
        if (mAdvlayout != null) {
            mAdvlayout.startAutoScroll();
        }
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        if (mAdvlayout != null) {
            mAdvlayout.stopAutoScroll();
        }
    }

    @Override
    public void onDestroy() {
        super.onDestroy();

    }

    private void setupViews(View view) {
        mRecycler = (RecyclerView) view.findViewById(R.id.rvSubCategory);
        GridLayoutManager layoutManager = new GridLayoutManager(getActivity(), 3);
        mRecycler.setLayoutManager(layoutManager);

        mCategoryAdapter = new CategorySubAdapter(getContext(),
                R.layout.category_two_level_item_temporary, mCategoryInfos);

        mRecycler.setAdapter(mCategoryAdapter);

        if (mUrls != null && !mUrls.isEmpty()) {

            mRecyclerHeader = RecyclerViewHeader.fromXml(getActivity(), R.layout.category_sub_header_layout);
            mRecyclerHeader.attachTo(mRecycler);
        }



    }

    private void dispatch(String keyword){
        Intent intent = new Intent(getContext(), GoodsFilterActivity.class);

        Bundle extras = new Bundle();
        extras.putString("keyword", keyword);
        intent.putExtras(extras);

        startActivity(intent);
    }





    @Override
    public void onDetach() {
        super.onDetach();
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()) {

            case R.id.fabCategory:

                mRecycler.smoothScrollToPosition(0);
                mFab.hide();

                break;

        }
    }

    @Override
    public void onSliderClick(BaseSliderView slider) {
        dispatch(slider.getBundle().getString("extra"));
    }




}
