package com.jsyh.onlineshopping.activity;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AlertDialog;
import android.view.View;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.model.BaseModel;
import com.jsyh.onlineshopping.model.CartGoods;
import com.jsyh.onlineshopping.model.CartGoodsModel;
import com.jsyh.onlineshopping.model.GoodsInfoModel2;
import com.jsyh.onlineshopping.presenter.CollectGoodsPresenter;
import com.jsyh.onlineshopping.presenter.DetatilePresenter;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.CollectGoodsView;
import com.jsyh.onlineshopping.views.GoodDetatileView;
import com.jsyh.shopping.uilibrary.adapter.listview.BaseAdapterHelper;
import com.jsyh.shopping.uilibrary.adapter.listview.QuickAdapter;
import com.liang.library.RoundedTransformationBuilder;
import com.squareup.picasso.Picasso;
import com.squareup.picasso.Transformation;

import java.util.List;

/**
 * Created by Su on 2015/10/20.
 */
public class GoodsCollectActivity extends BaseActivity implements CollectGoodsView, GoodDetatileView {
    private CollectGoodsPresenter mPresenter;
    private View mViewTitle;
    private ImageButton mImageButtonLeft;
    private ImageButton mImageButtonRight;
    private TextView mTextViewTitle;
    private QuickAdapter<CartGoods> mQuickAdapter;

    private ListView mListView;
    /**
     * 关注表中没有商品相关属性字段，所以不能再关注表中直接加入购物车。
     */
    private String[] mOperates = new String[]{"取消关注"};

    private DetatilePresenter mCancelCollectPresenter;

    private Transformation mTransformation;

    @Override
    protected void onResume() {
        super.onResume();
        initTransformation();
        mPresenter = new CollectGoodsPresenter(this);
        mPresenter.getCollectList();

        mCancelCollectPresenter = new DetatilePresenter(this);
    }

    private void initTransformation() {
        mTransformation = new RoundedTransformationBuilder()
                .cornerRadiusDp(5)
                .borderColor(Color.TRANSPARENT)
                .borderWidthDp(1)
                .oval(false)
                .build();

    }

    @Override
    public void initView() {
        super.initView();
        setContentView(R.layout.activity_collect_goods);
        mViewTitle = findViewById(R.id.collectTitle);

        mImageButtonLeft = (ImageButton) mViewTitle.findViewById(R.id.left_imbt);
        mImageButtonLeft.setImageDrawable(getResources().getDrawable(R.mipmap.ic_back));
        mImageButtonLeft.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        mImageButtonRight = (ImageButton) mViewTitle.findViewById(R.id.right_imbt);
        mImageButtonRight.setVisibility(View.INVISIBLE);
        mTextViewTitle = (TextView) mViewTitle.findViewById(R.id.title);
        mTextViewTitle.setText("关注商品");

        mListView = (ListView) findViewById(R.id.collectList);
        RelativeLayout mLayoutEmpty = (RelativeLayout) findViewById(R.id.mLayoutEmpty);
        mListView.setEmptyView(mLayoutEmpty);
        mListView.setAdapter(mQuickAdapter);

    }

    @Override
    public void initData() {

        mQuickAdapter = new QuickAdapter<CartGoods>(this, R.layout.goods_show_model_one_item) {

            @Override
            protected void convert(BaseAdapterHelper helper, final CartGoods item) {
                helper.setText(R.id.tvGoodsNameMode1, item.getGoods_name());
                helper.setText(R.id.tvGoodsPrice1, "￥" + item.getGoods_price());
                Picasso.with(GoodsCollectActivity.this).load(item.getGoods_img()).fit().transform(mTransformation).error(R.mipmap.ic_launcher).
                        into((ImageView) helper.getView(R.id.ivGoodsIconMode1));

                helper.setVisible(R.id.tvSaleFlag, false);
                helper.setVisible(R.id.tvCommentPercentile, false);
                helper.setVisible(R.id.tvSaleNums, false);

                helper.getView().setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        toGoodsDetail(item);
                    }
                });

                helper.getView().setOnLongClickListener(new View.OnLongClickListener() {
                    @Override
                    public boolean onLongClick(View v) {
                        AlertDialog.Builder mBuilder = new AlertDialog.Builder(GoodsCollectActivity.this);

                        mBuilder.setTitle("操作").setItems(mOperates, new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                switch (which) {
                                    case 0:
                                        mCancelCollectPresenter.cancelCollect(item.getGoods_id());
                                        break;
                                }
                            }
                        }).show();

                        return true;
                    }
                });
            }
        };

    }

    //跳转到详情页
    private void toGoodsDetail(CartGoods item) {
        Intent intent = new Intent(this, GoodsInfoActivity.class);
        Bundle bundle = new Bundle();
        bundle.putString("goodsId", item.getGoods_id());
        intent.putExtras(bundle);
        startActivity(intent);
    }

    //获取关注商品结果监听
    @Override
    public void getCollectList(CartGoodsModel cartGoodsModel) {
        mQuickAdapter.clear();
        mQuickAdapter.addAll(cartGoodsModel.getData());
    }

    @Override
    public void albumData(String[] albums) {

    }

    @Override
    public void contentData(List<String> content) {

    }

    @Override
    public void attributeData(List<GoodsInfoModel2.Attribute> attributes) {

    }

    @Override
    public void paramData(String param) {

    }

    @Override
    public void onLoadGoodsInfoDatas(@Nullable GoodsInfoModel2 datas) {

    }

    @Override
    public void onAddCarShopping(@Nullable BaseModel data) {

    }

    @Override
    public void onCollectGoods(BaseModel data) {

    }

    @Override
    public void cancelCollectGoods(BaseModel data) {
        Utils.showToast(this, data.getMsg());
        if (data.getCode().equals("1"))
            onResume();
    }

    @Override
    public void error(String msg, Object tag) {

    }
}
