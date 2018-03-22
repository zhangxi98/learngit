package com.jsyh.onlineshopping.fragment;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.ViewStub;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TableRow;
import android.widget.TextView;

import com.baoyz.widget.PullRefreshLayout;
import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.GoodsCollectActivity;
import com.jsyh.onlineshopping.activity.GoodsInfoActivity;
import com.jsyh.onlineshopping.activity.me.CreateOrderActivity;
import com.jsyh.onlineshopping.activity.me.LoginActivity;
import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.config.SPConfig;
import com.jsyh.onlineshopping.model.BaseModel;
import com.jsyh.onlineshopping.model.CartGoods;
import com.jsyh.onlineshopping.model.CartGoodsModel;
import com.jsyh.onlineshopping.presenter.CartGoodsPresenter;
import com.jsyh.onlineshopping.utils.SPUtils;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.CartGoodsView;
import com.jsyh.onlineshopping.views.PersonalView;
import com.jsyh.shopping.uilibrary.adapter.listview.BaseAdapterHelper;
import com.jsyh.shopping.uilibrary.adapter.listview.QuickAdapter;
import com.jsyh.shopping.uilibrary.dialog.AlterGoodsNumDialog;
import com.liang.library.RoundedTransformationBuilder;
import com.squareup.picasso.Picasso;
import com.squareup.picasso.Transformation;

import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.List;


public class ShoppingCartFragment extends BaseFragment implements CartGoodsView, CompoundButton.OnCheckedChangeListener {

    private PullRefreshLayout pullRefreshLayout;
    private PullRefreshLayout pullRefreshLayout2;

    private QuickAdapter<CartGoods> mCartGoodsAdapter;

    private CartGoodsPresenter cartGoodsPresenter;
    //购物车列表
    private ListView mListView;
    //已登录并且购物车中有数据
    private FrameLayout mFrameLayoutLogin;
    //购物车为空，提示登录窗口
    private TableRow mTableRowToLogin;
    //所有的商品集合
    private List<CartGoods> allCartGoodsList;
    //已经选择的商品集合
    private List<CartGoods> selectCartGoodsList;
    private Button mButtonToLogin;
    private Button mButtonFocus;
    private Button mButtonSettleAccounts;
    private Button mButtonMoveFocus;
    private Button mButtonDelete;

    private TableRow mTableRowGoodsSettle;
    private TableRow mTableRowGoodsDelete;

    //去结算
    private TextView mTextViewTotalPrice;
    private TextView mTextViewTotalAccounts;

    private CheckBox mCheckBoxSelectAll;
    private CheckBox mCheckBoxDeleteAll;

    //商品id与数量,传入确认订单页
    private String goodsIdNumber;
    //商品属性，传入确认订单页
    private String goodsAttStr;
    //商品唯一标识rec_id，删除商品
    private String goodsRecId;
    private View view;

    private boolean flag = true;//用来区分是首次加载还是刷新的标识

    private Transformation mTransformation;

    private PersonalView mPersonalView;

    //网络错误用到的view
    private ViewStub mNetworStub;
    private View mNetworkErrorLayout;
    private Button mReloadRequest;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Log.d("TEST", "创建MessageFragment");
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        view = inflater.inflate(R.layout.fragment_message, container, false);

        cartGoodsPresenter = new CartGoodsPresenter(this);

        selectCartGoodsList = new ArrayList<>();
        allCartGoodsList = new ArrayList<>();
        initTransformation();
        return view;
    }

    @Override
    protected void initView() {

        Log.d("order", "initView");

        initPullRefreshLayout();
        initPullRefreshLayout2();

        mNetworStub = (ViewStub) view.findViewById(R.id.vsNetworkError);
        mNetworkErrorLayout = mNetworStub.inflate();
        mReloadRequest = (Button) mNetworkErrorLayout.findViewById(R.id.btnReloadNetwork);
        mReloadRequest.setOnClickListener(this);

        mFrameLayoutLogin = (FrameLayout) view.findViewById(R.id.loginLayout);
        mListView = (ListView) view.findViewById(R.id.list);


        mTableRowToLogin = (TableRow) view.findViewById(R.id.login);
        mTableRowGoodsSettle = (TableRow) view.findViewById(R.id.goods_settle);
        mTableRowGoodsDelete = (TableRow) view.findViewById(R.id.goods_delete);

        mButtonToLogin = (Button) view.findViewById(R.id.toLogin);
        mButtonFocus = (Button) view.findViewById(R.id.focus);
        mButtonSettleAccounts = (Button) view.findViewById(R.id.settle_accounts);
        mButtonMoveFocus = (Button) view.findViewById(R.id.movefocus);
        mButtonMoveFocus.setVisibility(View.INVISIBLE);
        mButtonDelete = (Button) view.findViewById(R.id.delete);


        mTextViewTotalPrice = (TextView) view.findViewById(R.id.total_sum);
        mTextViewTotalAccounts = (TextView) view.findViewById(R.id.total_accounts);

        mCheckBoxSelectAll = (CheckBox) view.findViewById(R.id.select_all);
        mCheckBoxDeleteAll = (CheckBox) view.findViewById(R.id.select_all_delete);

        mButtonToLogin.setOnClickListener(this);
        mButtonFocus.setOnClickListener(this);
        mButtonSettleAccounts.setOnClickListener(this);
//        mButtonMoveFocus.setOnClickListener(this);
        mButtonDelete.setOnClickListener(this);

        mCheckBoxSelectAll.setOnCheckedChangeListener(this);
        mCheckBoxDeleteAll.setOnCheckedChangeListener(this);
    }


    //商品列表下拉刷新
    private void initPullRefreshLayout() {
        pullRefreshLayout = (PullRefreshLayout) getView().findViewById(R.id.pullRefreshLayout);
        pullRefreshLayout.setRefreshStyle(PullRefreshLayout.STYLE_Bitmap);
        pullRefreshLayout.setOnRefreshListener(new PullRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                pullRefreshLayout.postDelayed(new Runnable() {
                    @Override
                    public void run() {

                        flag = false;
                        onResume();

                        pullRefreshLayout.setRefreshing(false);
                    }
                }, 1000);
            }

            @Override
            public void onMove(boolean ismove) {

            }
        });
    }

    //商品列表为空，下拉刷新
    private void initPullRefreshLayout2() {
        pullRefreshLayout2 = (PullRefreshLayout) getView().findViewById(R.id.pullRefreshLayout2);
        pullRefreshLayout2.setRefreshStyle(PullRefreshLayout.STYLE_Bitmap);
        pullRefreshLayout2.setOnRefreshListener(new PullRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                pullRefreshLayout2.postDelayed(new Runnable() {
                    @Override
                    public void run() {

                        flag = false;
                        onResume();
                        pullRefreshLayout2.setRefreshing(false);
                    }
                }, 1000);
            }

            @Override
            public void onMove(boolean ismove) {

            }
        });
    }

    @Override
    protected void initData() {

        Log.d("order", "initData");
        mCartGoodsAdapter = new QuickAdapter<CartGoods>(getActivity(), R.layout.cart_goods_item) {
            @Override
            protected void convert(final BaseAdapterHelper helper, final CartGoods item) {
                helper.setText(R.id.goods_name, item.getGoods_name());
                helper.setText(R.id.goods_price, "￥" + item.getGoods_price());
                Picasso.with(getActivity()).load(item.getGoods_img()).fit().transform(mTransformation)
                        .error(R.mipmap.ic_launcher).into((ImageView) helper.getView(R.id.goods_image));

                final int goods_number = item.getNumber();
                final String rec_id = item.getRec_id();
                String goods_price = item.getGoods_price();
                helper.setText(R.id.goods_number, goods_number + "");
                //计算金钱
                BigDecimal total_price = getTotalPrice(goods_number, goods_price);

                helper.setText(R.id.goods_total_price, total_price.toString());
                //修改商品数量
                alterGoodsNumber(helper, goods_number, rec_id);


                //选择商品
                CheckBox mCheckBoxSelect = (CheckBox) helper.getView().findViewById(R.id.select_goods);
                mCheckBoxSelect.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
                    @Override
                    public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                        //Utils.showToast(getActivity(), item.getGoods_name() + isChecked);
                        if (isChecked && !selectCartGoodsList.contains(item))
                            selectCartGoodsList.add(item);
                        else if (!isChecked && selectCartGoodsList.contains(item))
                            selectCartGoodsList.remove(item);
                        alterTotalPrice(selectCartGoodsList);
                    }
                });

                if (selectCartGoods(item)) mCheckBoxSelect.setChecked(true);
                else mCheckBoxSelect.setChecked(false);

                //跳转到商品详情页,点击图片以及商品名称
                helper.getView().setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        toGoodsDetail(item);
                    }
                });

            }
        };


        mListView.setAdapter(mCartGoodsAdapter);
    }

    private void toGoodsDetail(CartGoods item) {
        Intent intent = new Intent(getActivity(), GoodsInfoActivity.class);
        Bundle bundle = new Bundle();
        bundle.putString("goodsId", item.getGoods_id());
        intent.putExtras(bundle);
        startActivity(intent);
    }

    //增加修改商品数量
    private void alterGoodsNumber(BaseAdapterHelper helper, final int goods_number, final String rec_id) {
        //减少商品
        helper.setOnClickListener(R.id.number_sub, new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (goods_number > 1)
                    cartGoodsPresenter.alterCartGoodsNumber(getActivity(), rec_id, goods_number - 1);

            }
        });
        //增加商品
        helper.setOnClickListener(R.id.number_add, new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                cartGoodsPresenter.alterCartGoodsNumber(getActivity(), rec_id, goods_number + 1);
            }
        });
        //自定义商品数量

        helper.setOnClickListener(R.id.goods_number, new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //Utils.showToast(getActivity(), "自定义商品数量弹出框");
                AlterGoodsNumDialog dialog = new AlterGoodsNumDialog(getActivity(), goods_number, new AlterGoodsNumDialog.OnAlertGoodsNumDialogListener() {
                    @Override
                    public void cancel() {
                        //Toast.makeText(context, "取消", Toast.LENGTH_SHORT).show();
                    }

                    @Override
                    public void confirm(String newNums) {
                        // Toast.makeText(context, "确定" + newNums, Toast.LENGTH_SHORT).show();

                        cartGoodsPresenter.alterCartGoodsNumber(getActivity(), rec_id, Integer.parseInt(newNums));
                    }
                });
                dialog.show();
            }
        });
    }

    private boolean selectCartGoods(CartGoods item) {
        for (CartGoods cartGoods : selectCartGoodsList) {
            if (cartGoods.getRec_id().equals(item.getRec_id())) {

                //当一个商品被选择，并且修改数量时，将已选集合中的更改数量之前的商品删除，添加新数据并重新计算价格
                selectCartGoodsList.remove(cartGoods);
                selectCartGoodsList.add(item);
                alterTotalPrice(selectCartGoodsList);

                return true;
            }
        }
        return false;
    }

    //根据单价跟数量计算钱数
    private BigDecimal getTotalPrice(int goods_number, String goods_price) {
        BigDecimal one_price = new BigDecimal(goods_price);
        return one_price.multiply(new BigDecimal(goods_number));
    }


    @Override
    protected void initTitle() {

        Log.d("order", "inittitle");

        super.initTitle();
        title.setText(R.string.string_shoppingCart);
        if (this.getTag().equals("cartFragment")) {

            back.setVisibility(View.VISIBLE);
            back.setImageDrawable(getResources().getDrawable(R.mipmap.ic_back));
            back.setOnClickListener(this);
        }

    }

    @Override
    public void onResume() {

        Log.d("order", "onResume");

        if (Utils.NO_NETWORK_STATE == Utils.isNetworkAvailable(getContext())) {
            switchLayout();
        }else {
            if (mNetworkErrorLayout != null) {
                mNetworkErrorLayout.setVisibility(View.GONE);
            }
            ConfigValue.DATA_KEY = (String) SPUtils.get(getActivity(), SPConfig.KEY, "");
            if (ConfigValue.DATA_KEY != null && !ConfigValue.DATA_KEY.equals("")) {
                //本地存在key
            /*mFrameLayoutLogin.setVisibility(View.VISIBLE);
            pullRefreshLayout2.setVisibility(View.GONE);*/
                cartGoodsPresenter.getCartGoodsData(getActivity(),flag);

            } else {
                //不存在key，提示需要登录
                mFrameLayoutLogin.setVisibility(View.GONE);
                pullRefreshLayout2.setVisibility(View.VISIBLE);

                mTableRowToLogin.setVisibility(View.VISIBLE);
            }
        }


        super.onResume();
    }

    @Override
    public void getCartGoodsList(CartGoodsModel cartGoodsModel) {

        Log.d("order", "getCartGoodsList");
        //已登录并且购物车为空
        if (cartGoodsModel.getData().size() == 0) {
            //隐藏商品列表布局与登录按钮，显示空商品布局
            mFrameLayoutLogin.setVisibility(View.GONE);
            pullRefreshLayout2.setVisibility(View.VISIBLE);
            mTableRowToLogin.setVisibility(View.GONE);

            ensure.setText("");

            allCartGoodsList.clear();
        } else {

            //显示商品列表，隐藏空商品布局
            mFrameLayoutLogin.setVisibility(View.VISIBLE);
            pullRefreshLayout2.setVisibility(View.GONE);

            if (!ensure.getText().equals("完成")) {
                ensure.setText("编辑");
                mTableRowGoodsSettle.setVisibility(View.VISIBLE);
                mTableRowGoodsDelete.setVisibility(View.GONE);
            }

            right.setOnClickListener(this);


            //每次刷新查询购物车商品时都将全部商品集合清空重新赋值
            allCartGoodsList.clear();
            allCartGoodsList.addAll(cartGoodsModel.getData());

            mCartGoodsAdapter.clear();
            mCartGoodsAdapter.addAll(allCartGoodsList);

        }


        mPersonalView.setCartGoodsNums(getCartGoodsNums());
        Intent mIntent = new Intent(ConfigValue.ACTION_ALTER_CARTGOODS_NUMS);
        mIntent.putExtra("cartgoodsnum", getCartGoodsNums());
        //发送广播
        getActivity().sendBroadcast(mIntent);

        Log.d("cart", cartGoodsModel.getData().toString() + "/" + cartGoodsModel.getMsg() + "/" + cartGoodsModel.getCode());

    }

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        //实例化mPersonalView
        mPersonalView = (PersonalView) context;
    }

    /**
     * 暂时根据请求获得的商品计算数量在购物车角标显示
     */
    private String getCartGoodsNums() {
        int nums = 0;
        for (CartGoods cartGoods : allCartGoodsList)
            nums += cartGoods.getNumber();
        return String.valueOf(nums);
    }


    //修改购物车商品数量回调
    @Override
    public void alterCartGoodsNumber(BaseModel baseModel) {
        if (baseModel.getCode().equals("1")) {
            // Utils.showToast(getActivity(), baseModel.getMsg());

            cartGoodsPresenter.getCartGoodsData(getActivity(),false);
        } else

            Utils.showToast(getActivity(), baseModel.getMsg());
    }

    //删除购物车中商品回调

    @Override
    public void deleteCartGoods(BaseModel baseModel) {
        Utils.showToast(getActivity(), baseModel.getMsg());
        if (baseModel.getCode().equals("1")) {
            //删除商品成功之后将已选择商品集合清空并重新设置总值

            selectCartGoodsList.clear();
            alterTotalPrice(selectCartGoodsList);


            cartGoodsPresenter.getCartGoodsData(getActivity(),false);
        }

    }

    //修改结算合计金额与商品数量
    private void alterTotalPrice(List<CartGoods> selectCartGoodsList) {

        BigDecimal totalPrice = new BigDecimal(0.00);
        int totalNumber = 0;
        goodsIdNumber = "";
        goodsRecId = "";
        goodsAttStr = "";
        //获取商品id与数量传到确认订单页
        for (int i = 0; i < selectCartGoodsList.size(); i++) {
            totalNumber += selectCartGoodsList.get(i).getNumber();

            BigDecimal bigDecimal = getTotalPrice(selectCartGoodsList.get(i).getNumber(), selectCartGoodsList.get(i).getGoods_price());

            totalPrice = totalPrice.add(bigDecimal);
            goodsIdNumber += selectCartGoodsList.get(i).getGoods_id() + "-" + selectCartGoodsList.get(i).getNumber() + ",";

            goodsAttStr += String.valueOf(selectCartGoodsList.get(i).getAttrvalue_id()) + "-";

            goodsRecId += selectCartGoodsList.get(i).getRec_id() + ",";
        }
        //去掉最后一位逗号
        if (!TextUtils.isEmpty(goodsIdNumber) && goodsIdNumber != null)
            goodsIdNumber = goodsIdNumber.substring(0, goodsIdNumber.length() - 1);
        if (!TextUtils.isEmpty(goodsRecId) && goodsRecId != null)
            goodsRecId = goodsRecId.substring(0, goodsRecId.length() - 1);
        if (!TextUtils.isEmpty(goodsAttStr) && goodsAttStr != null)
            goodsAttStr = goodsAttStr.substring(0, goodsAttStr.length() - 1);
        mTextViewTotalPrice.setText(String.format(getResources().getString(R.string.cart_goods_total_sum), totalPrice.toString()));

        mTextViewTotalAccounts.setText(String.format(getResources().getString(R.string.cart_goods_total_accounts), totalPrice.toString()));

        mButtonSettleAccounts.setText(String.format(getResources().getString(R.string.cart_goods_settle_accounts), totalNumber));


    }

    public void switchLayout() {

        mNetworkErrorLayout.setVisibility(View.VISIBLE);

        pullRefreshLayout.setVisibility(View.GONE);
        pullRefreshLayout2.setVisibility(View.GONE);

    }

    @Override
    public void onClick(View v) {

        Log.d("order", "OnClick");
        if (Utils.NO_NETWORK_STATE == Utils.isNetworkAvailable(getContext())) {
            switchLayout();
            return;
        }
        switch (v.getId()) {
            case R.id.toLogin:
                Intent itLogin = new Intent(getActivity(), LoginActivity.class);
                startActivity(itLogin);
                break;
            case R.id.focus:
                //获取关注商品列表
                String key = (String) SPUtils.get(getActivity(), "key", "");
                if (!TextUtils.isEmpty(key)) {
                    // Utils.showToast(getActivity(), "看看关注");
                    startActivity(new Intent(getActivity(), GoodsCollectActivity.class));
                } else {
                    startActivity(new Intent(getActivity(), LoginActivity.class));
                }
                break;
            //去结算
            case R.id.settle_accounts:
                if (!TextUtils.isEmpty(goodsIdNumber) && goodsIdNumber != null) {
                    Intent intent = new Intent(getActivity(), CreateOrderActivity.class);

                    Log.d("goodsidnumber", goodsIdNumber);
                    intent.putExtra("goodsIdNumber", goodsIdNumber);
                    intent.putExtra("goodsAttStr", goodsAttStr);
                    intent.putExtra("intentType","0");
                    startActivity(intent);

                }
                break;
            //编辑购物车中商品
            case R.id.right:

                if (ensure.getText().equals("编辑")) {
                    ensure.setText("完成");
                    mTableRowGoodsSettle.setVisibility(View.GONE);
                    mTableRowGoodsDelete.setVisibility(View.VISIBLE);
                } else if (ensure.getText().equals("完成")) {
                    ensure.setText("编辑");
                    mTableRowGoodsSettle.setVisibility(View.VISIBLE);
                    mTableRowGoodsDelete.setVisibility(View.GONE);
                }

                break;
            //移入关注
            case R.id.movefocus:
                Utils.showToast(getActivity(), "移入关注");
                break;
            //删除商品
            case R.id.delete:
                if (!TextUtils.isEmpty(goodsRecId) && goodsRecId != null) {
                    AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
                    builder.setMessage("确认要删除所选商品吗？").setPositiveButton("确定", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            cartGoodsPresenter.deleteCartGoods(getActivity(), goodsRecId);
                        }
                    }).setNegativeButton("取消", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                        }
                    }).show();


                } else
                    Utils.showToast(getActivity(), "您还没有选择商品哦！");

                break;
            case R.id.btnReloadNetwork:
                onResume();
                break;
            case R.id.back:
                getActivity().finish();
                break;
        }


    }

    @Override
    public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {

        if (isChecked) {
            //Utils.showToast(getActivity(), "全选");
            selectCartGoodsList.clear();
            selectCartGoodsList.addAll(allCartGoodsList);

        } else {
            // Utils.showToast(getActivity(), "全不选");
            selectCartGoodsList.clear();
        }
        mCartGoodsAdapter.notifyDataSetChanged();
        alterTotalPrice(selectCartGoodsList);

    }

    private void initTransformation() {
        mTransformation = new RoundedTransformationBuilder()
                .cornerRadiusDp(5)
                .borderColor(Color.TRANSPARENT)
                .borderWidthDp(1)
                .oval(false)
                .build();

    }
}
