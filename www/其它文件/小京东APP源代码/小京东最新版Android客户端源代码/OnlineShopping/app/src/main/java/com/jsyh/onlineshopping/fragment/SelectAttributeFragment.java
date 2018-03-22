package com.jsyh.onlineshopping.fragment;

import android.content.Context;
import android.os.Bundle;
import android.support.annotation.CheckResult;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.jsyh.onlineshopping.model.GoodsInfoModel2.Attribute;
import com.jsyh.onlineshopping.model.GoodsInfoModel2.Attribute.Attr_Value;
import com.jsyh.shopping.uilibrary.R;
import com.jsyh.shopping.uilibrary.views.AddAndSubView;
import com.squareup.picasso.Picasso;
import com.zhy.view.flowlayout.FlowLayout;
import com.zhy.view.flowlayout.TagAdapter;
import com.zhy.view.flowlayout.TagFlowLayout;
import com.zhy.view.flowlayout.TagFlowLayout.OnSelectListener;
import com.zhy.view.flowlayout.TagFlowLayout.OnTagClickListener;

import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Set;

public class SelectAttributeFragment extends BaseFragment implements AddAndSubView.OnNumChangeListener {
    private String[] mVals = new String[]{"红色", "咖啡色", "酒红色", "蓝色", "绿色"};
    private String[] mSizes = new String[]{"上衣XL\\裤子L", "上衣XL\\裤子XL", "上衣XL\\裤子XLL", "上衣L\\裤子L"};
    private TagFlowLayout flowlayout_size;
    private ViewGroup layout_Attribute;


    // FIXME: 15/10/11 cao  cao  cao   cao

    private AddAndSubView mGoodsNums;            //选择的商品数量


    private OnAttributeSelectedListener mListener;  // 回调接口


    public Map<String, Attr_Value> selectAttrMap = new HashMap<>();// 选择的属性集合


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        // TODO Auto-generated method stub
        View view = inflater.inflate(R.layout.layout_select_attribute, null);
        layout_Attribute = (ViewGroup) view.findViewById(R.id.layout_Attribute);


        // FIXME: 15/10/11
        mGoodsNums = (AddAndSubView) view.findViewById(R.id.goodsNum);
        mGoodsNums.setOnNumChangeListener(this);
        return view;
    }

    @Override
    protected void initView() {
        TextView mTextViewAddToCart = (TextView) getView().findViewById(R.id.addCard);
        mTextViewAddToCart.setOnClickListener(this);
    }

    @Override
    protected void initTitle() {
        //super.initTitle();
    }

    @Override
    public void onActivityCreated(Bundle savedInstanceState) {
        // TODO Auto-generated method stub
        super.onActivityCreated(savedInstanceState);
        // mFlowLayout.setOnTagClickListener(new TagFlowLayout.OnTagClickListener() {
        // @Override
        // public boolean onTagClick(View view, int position, FlowLayout parent) {
        // Toast.makeText(getActivity(), mVals[position], Toast.LENGTH_SHORT).show();
        // // view.setVisibility(View.GONE);
        // return true;
        // }
        // });
        // mFlowLayout.setOnSelectListener(new TagFlowLayout.OnSelectListener() {
        // @Override
        // public void onSelected(Set<Integer> selectPosSet) {
        // // getActivity().setTitle("choose:" + selectPosSet.toString());
        // }
        // });
    }

    //商品缩略图
    public void initGoodsImage(String goods_img) {
        ImageView mImageViewGoodsImg = (ImageView) getView().findViewById(R.id.goodsImage);
        Picasso.with(getActivity()).load(goods_img).error(R.mipmap.ic_launcher).into(mImageViewGoodsImg);
    }

    //商品编号
    public void initGoodsSn(String goods_sn) {
        TextView mTextViewGoodsSn = (TextView) getView().findViewById(R.id.textId);
        mTextViewGoodsSn.setText("商品编号：" + goods_sn);
    }
    //商品价格

    public void initGoodsPrice(String goods_price) {
        TextView mTextViewGoodsPrice = (TextView) getView().findViewById(R.id.textPrice);
        mTextViewGoodsPrice.setText(goods_price);
    }

    //商品属性
    public void initAttributes(final List<Attribute> attributes) {
        // TODO Auto-generated method stub
        for (int i = 0; i < attributes.size(); i++) {
            View rootView = LayoutInflater.from(getActivity()).inflate(R.layout.fragment_single_choose, null);
            rootView.setId(10000 + i);
            layout_Attribute.addView(rootView);
            TextView tv_attribute = (TextView) rootView.findViewById(R.id.tv_attribute);
            tv_attribute.setText(attributes.get(i).attr_name);
            final TagFlowLayout tagFlowLayout_attribute_value = (TagFlowLayout) rootView.findViewById(R.id.tagFlowLayout_attribute_value);
            final int finalI = i;
            tagFlowLayout_attribute_value.setAdapter(new TagAdapter<Attr_Value>(attributes.get(i).attr_value) {
                @Override
                public View getView(FlowLayout parent, int position, Attr_Value t) {
                    TextView tv = (TextView) getActivity().getLayoutInflater().inflate(R.layout.select_attribute_item, tagFlowLayout_attribute_value, false);
//					TextView tv = new TextView(getActivity());
                    tv.setText(t.attr_value_name);

                    if (position == 0) {
                        selectAttrMap.put(attributes.get(finalI).attr_id, t);
                    }

                    return tv;
                }
            });
            //final int finalI = i;
            tagFlowLayout_attribute_value.setOnTagClickListener(new OnTagClickListener() {

                @Override
                public boolean onTagClick(View view, int position, FlowLayout parent) {
                    // TODO Auto-generated method stub
                    // Utils.showToast(getActivity(), position + "");
                    selectAttrMap.put(attributes.get(finalI).attr_id, attributes.get(finalI).attr_value.get(position));

                    mListener.onAttributedSelected(getGoodsNums(), selectAttrMap);
                    return true;
                }
            });

            tagFlowLayout_attribute_value.setOnSelectListener(new OnSelectListener() {

                @Override
                public void onSelected(Set<Integer> selectPosSet) {
                    // TODO Auto-generated method stub
                    //Utils.showToast(getActivity(), attributes.get(finalI).toString());


                }
            });
        }
    }


    /**
     * 得到选择的商品数量
     *
     * @return
     */
    @CheckResult
    public int getGoodsNums() {
        return mGoodsNums.getNum();
    }


    public void getAttrValue() {

        Set<Integer> selectedList = flowlayout_size.getSelectedList();

    }

    @Override
    public void onNumChange(View view, int num) {
        mListener.onAttributedSelected(num, selectAttrMap);
    }

    /**
     * 回调接口，用于选择属性传值给详情页
     */
    public interface OnAttributeSelectedListener {
        void onAttributedSelected(int goodsNum, Map<String, Attr_Value> selectedAttrMap);

        void onAddGoodsToCart(int goodsNum, Map<String, Attr_Value> selectedAttrMap);
    }


    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        try {
            mListener = (OnAttributeSelectedListener) context;

        } catch (ClassCastException e) {
            throw new ClassCastException(context.toString() + "must implement OnAttributeSelectListener");
        }
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()) {
            case R.id.addCard:
                mListener.onAddGoodsToCart(getGoodsNums(), selectAttrMap);

                break;
        }

    }
}
