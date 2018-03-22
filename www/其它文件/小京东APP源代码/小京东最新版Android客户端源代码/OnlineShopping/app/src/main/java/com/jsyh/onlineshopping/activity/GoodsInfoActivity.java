package com.jsyh.onlineshopping.activity;

import android.content.Intent;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.support.annotation.CheckResult;
import android.support.annotation.Nullable;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.widget.DrawerLayout;
import android.text.TextUtils;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewStub;
import android.widget.AbsListView.LayoutParams;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.jsyh.onlineshopping.activity.me.CreateOrderActivity;
import com.jsyh.onlineshopping.activity.me.LoginActivity;
import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.fragment.DetaileTileFragment;
import com.jsyh.onlineshopping.fragment.DetatileFragment;
import com.jsyh.onlineshopping.fragment.SelectAttributeFragment;
import com.jsyh.onlineshopping.model.BaseModel;
import com.jsyh.onlineshopping.model.GoodsInfoModel2;
import com.jsyh.onlineshopping.model.GoodsInfoModel2.Attribute;
import com.jsyh.onlineshopping.model.PersonalModel;
import com.jsyh.onlineshopping.presenter.DetatilePresenter;
import com.jsyh.onlineshopping.presenter.PersonalPresenter;
import com.jsyh.onlineshopping.qrzxing.CreateQRCode;
import com.jsyh.onlineshopping.umeng.share.Share;
import com.jsyh.onlineshopping.utils.AppManager;
import com.jsyh.onlineshopping.utils.SPUtils;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.GoodDetatileView;
import com.jsyh.onlineshopping.views.PersonalView;
import com.jsyh.shopping.uilibrary.R;
import com.jsyh.shopping.uilibrary.adapter.listview.QuickAdapter;
import com.jsyh.shopping.uilibrary.bannerview.BannerView;
import com.jsyh.shopping.uilibrary.drawable.CartDrawable;
import com.jsyh.shopping.uilibrary.popuwindow.QRCodePopupwindow;
import com.jsyh.shopping.uilibrary.popuwindow.ShareSelectPopupwindow;

import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class GoodsInfoActivity extends BaseActivity implements GoodDetatileView, OnClickListener,
        SelectAttributeFragment.OnAttributeSelectedListener, DetaileTileFragment.ClickCallback,
        CompoundButton.OnCheckedChangeListener, PersonalView {

    private ListView list_baseContent;
    private DrawerLayout drawerlayout;

    private RelativeLayout rlContentView;
    private CheckBox mCheckBoxCollection;
    private TextView text_cart;
    private Button btn_addCart;   //加入购物车
    private Button btn_buy;   //立即购买

    private ImageButton right_imbt;
    private ImageButton left_imbt;
    private DetaileTileFragment detail_MenuFragment;        //用这个弹出的？？？？？
    private BannerView head_View;
    private SelectAttributeFragment selectAttributeFragment;


    //// FIXME: 2015/10/10 wo cao shang mian dai ma bu shi  wo xie de !!!!!

    private QuickAdapter<String> quickAdapter;
    private DetatilePresenter mPresenter;

    private GoodsInfoModel2 mDatas;             //商品详情数据
    private DetatileFragment detatileFragment;   //详情界面

    private List<String> content;

    private CartDrawable cartDrawable;
    //分享的popupwindow
    private ShareSelectPopupwindow shareSelectPopupwindow;
    //二维码的popupwindow
    private QRCodePopupwindow qrCodePopupwindow;

    private TextView mTextViewGoodsName;
    private TextView mTextViewGoodsPrice;
    private TextView mTextViewGoodsAttr;

    //网络错误用到的view
    private ViewStub mNetworStub;
    private View mNetworkErrorLayout;
    private Button mReloadRequest;

    @Override
    public void initView() {
        super.initView();
        setContentView(R.layout.activity_goodsinfo);

        AppManager.getAppManager().addActivity(this);
        mNetworStub = (ViewStub) findViewById(com.jsyh.onlineshopping.R.id.vsNetworkError);
        mNetworkErrorLayout = mNetworStub.inflate();
        mReloadRequest = (Button) mNetworkErrorLayout.findViewById(com.jsyh.onlineshopping.R.id.btnReloadNetwork);
        mReloadRequest.setOnClickListener(this);
        mNetworkErrorLayout.setVisibility(View.GONE);

        rlContentView = (RelativeLayout)findViewById(R.id.rlContentView);
        //头部
        head_View = new BannerView(this);
        head_View.setLayoutParams(new LayoutParams(LayoutParams.MATCH_PARENT, Utils.dip2px(this, 300)));
        head_View.setDrawerMode(head_View.STYLE_Circular);
        head_View.setLocationMode(head_View.MODE_RIGHT);
        list_baseContent = (ListView) findViewById(R.id.list_baseContent);
        //内容部分
        View foot_View = LayoutInflater.from(mContext).inflate(R.layout.goodinfo_foot_view, null);
        mTextViewGoodsName = (TextView) foot_View.findViewById(R.id.goodsinfo_name);
        mTextViewGoodsPrice = (TextView) foot_View.findViewById(R.id.goodsinfo_price);
        mTextViewGoodsAttr = (TextView) foot_View.findViewById(R.id.goodsinfo_attr);
        mTextViewGoodsAttr.setOnClickListener(this);


        list_baseContent.addHeaderView(head_View);
        list_baseContent.addFooterView(foot_View);

        /*quickAdapter = new QuickAdapter<String>(mContext, R.layout.goodinfo_list_item) {
            @Override
            protected void convert(BaseAdapterHelper helper, String item) {
//                helper.setText(R.id.text, Html.fromHtml(item));
                if (!TextUtils.isEmpty(item))
                    ((TextView) helper.getView(R.id.text)).setText(Html.fromHtml(item));
            }
        };*/
        list_baseContent.setAdapter(null);
        //
        drawerlayout = (DrawerLayout) findViewById(R.id.drawerlayout);
        drawerlayout.setDrawerLockMode(DrawerLayout.LOCK_MODE_LOCKED_CLOSED); // 关闭
        drawerlayout.setDrawerListener(new DrawerLayout.DrawerListener() {
            @Override
            public void onDrawerStateChanged(int arg0) {
                // TODO Auto-generated method stub

            }

            @Override
            public void onDrawerSlide(View arg0, float arg1) {
                // TODO Auto-generated method stub

            }

            @Override
            public void onDrawerOpened(View arg0) {
                // TODO Auto-generated method stub
                drawerlayout.setDrawerLockMode(DrawerLayout.LOCK_MODE_UNLOCKED); // 关闭
            }

            @Override
            public void onDrawerClosed(View arg0) {
                // TODO Auto-generated method stub
                drawerlayout.setDrawerLockMode(DrawerLayout.LOCK_MODE_LOCKED_CLOSED); // 关闭

            }
        });

        text_cart = (TextView) findViewById(R.id.text_cart);
        setCartGoodsNums("");
        btn_addCart = (Button) findViewById(R.id.btn_addCart);
        btn_buy = (Button) findViewById(R.id.btn_buy);
        mCheckBoxCollection = (CheckBox) findViewById(R.id.txt_collection);


        //进入购物车
        text_cart.setOnClickListener(this);
        //加入购物车
        btn_addCart.setOnClickListener(this);
        //立即购买
        btn_buy.setOnClickListener(this);


        View title = findViewById(R.id.detail_title);
        FragmentManager fragmentManager = getSupportFragmentManager();
        FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();
        detatileFragment = new DetatileFragment();
        fragmentTransaction.add(R.id.detatileFrame, detatileFragment, "detatileFragment");
        detail_MenuFragment = new DetaileTileFragment();
        detail_MenuFragment.shareClick(this);
        fragmentTransaction.add(R.id.detail_MenuFragment, detail_MenuFragment, "detail_MenuFragment");
        shareSelectPopupwindow = new ShareSelectPopupwindow(this, this);
        qrCodePopupwindow = new QRCodePopupwindow(this);
        selectAttributeFragment = new SelectAttributeFragment();
        fragmentTransaction.add(R.id.SelectAttributeFragment, selectAttributeFragment, "selectAttributeFragment");
        fragmentTransaction.commit();
        right_imbt = (ImageButton) title.findViewById(R.id.right_imbt);
        right_imbt.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View arg0) {
                if (Utils.NO_NETWORK_STATE != Utils.isNetworkAvailable(GoodsInfoActivity.this)) {
                    if (detail_MenuFragment.isShow()) {
                        detail_MenuFragment.hide();
                    } else {
                        detail_MenuFragment.show();
                    }
                }
            }
        });
        left_imbt = (ImageButton) title.findViewById(R.id.left_imbt);
        left_imbt.setImageDrawable(getResources().getDrawable(R.mipmap.ic_back));
        left_imbt.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

    }

    @Override
    public void initData() {

        super.initData();

        mPresenter = new DetatilePresenter(mContext);
        if (Utils.NO_NETWORK_STATE != Utils.isNetworkAvailable(this)){
            mPresenter.LoadDetatileData(getGoodsId());
        }
    }


    @Override
    public void albumData(String[] albums) {

        head_View.initAdapterData(albums);

    }

    @Override
    public void contentData(List<String> content) {

    }

    @Override
    public void paramData(String param) {
        //商品编号
        selectAttributeFragment.initGoodsSn(param);
    }

    @Override
    public void onLoadGoodsInfoDatas(@Nullable GoodsInfoModel2 datas) {

        if (datas != null) {
            mDatas = datas;
            albumData(datas.data.album);
            attributeData(datas.data.attribute);
            paramData(datas.data.goods_sn);
            detatileFragment.setDataToFragment(datas.data.content, datas.data.param);
            //属性界面商品缩略图
            selectAttributeFragment.initGoodsImage(datas.data.album[0]);
            //属性界面商品价格
//            selectAttributeFragment.initGoodsPrice("￥" + getSelectedAttr(selectAttributeFragment.selectAttrMap).get("selectedAttrPrice"));

            mTextViewGoodsName.setText(datas.data.goods_name);
//            mTextViewGoodsPrice.setText("￥" + getSelectedAttr(selectAttributeFragment.selectAttrMap).get("selectedAttrPrice"));
            if(datas.data.attribute.size() > 0) {
                mTextViewGoodsPrice.setText("￥" + getSelectedAttr(selectAttributeFragment.selectAttrMap).get("selectedAttrPrice"));
                //属性界面商品价格
                selectAttributeFragment.initGoodsPrice("￥" + getSelectedAttr(selectAttributeFragment.selectAttrMap).get("selectedAttrPrice"));
                mTextViewGoodsAttr.setText("已选：" + selectAttributeFragment.getGoodsNums() + "件" + "," + getSelectedAttr(selectAttributeFragment.selectAttrMap).get("selectedStr"));
            }else {
                //属性界面商品价格
                selectAttributeFragment.initGoodsPrice("￥" + datas.data.total_price);
                mTextViewGoodsAttr.setText("已选：" + selectAttributeFragment.getGoodsNums() + "件");
                mTextViewGoodsPrice.setText("￥" + datas.data.total_price);
            }
            //判断是否为已经关注

            if (datas.data.is_attention == 1)
                mCheckBoxCollection.setChecked(true);

            //关注
            mCheckBoxCollection.setOnCheckedChangeListener(this);
        }


    }

    @Override
    public void onAddCarShopping(@Nullable BaseModel data) {

        Utils.showToast(this, data.getMsg());
        if (data != null && data.getCode().equals(ConfigValue.Success_Code)) {
            //加入成功
            //1. 修改 购物车图片 圆点增加
            int goodsNums = selectAttributeFragment.getGoodsNums();
            cartDrawable = (CartDrawable) text_cart.getCompoundDrawables()[1];
            cartDrawable.addNums(goodsNums);
            cartDrawable.start();

            Intent mIntent = new Intent(ConfigValue.ACTION_ALTER_CARTGOODS_NUMS);
            mIntent.putExtra("addGoodsNums", goodsNums);
            //发送广播
            sendBroadcast(mIntent);

        }

    }

    //收藏回调
    @Override
    public void onCollectGoods(BaseModel data) {
        Utils.showToast(this, data.getMsg());
        if (data.getCode().equals("1"))
            mCheckBoxCollection.setChecked(true);
        else
            mCheckBoxCollection.setChecked(false);
    }

    //取消商品回调
    @Override
    public void cancelCollectGoods(BaseModel data) {
        Utils.showToast(this, data.getMsg());
        if (data.getCode().equals("1"))
            mCheckBoxCollection.setChecked(false);
        else
            mCheckBoxCollection.setChecked(true);
    }

    @Override
    public void error(String msg, Object tag) {


    }

    @Override
    public void attributeData(List<Attribute> attributes) {

        if(attributes.size() > 0)
        selectAttributeFragment.initAttributes(attributes);

    }


    // FIXME: 2015/10/10  wo  cao  cao

    /**
     * 获取传递的 商品 ID
     *
     * @return
     */
    @CheckResult
    private String getGoodsId() {

        Bundle extras = getIntent().getExtras();
        if (extras == null) {
            throw new IllegalArgumentException("必须传递数据");
        }

        String goodsId = extras.getString("goodsId");
        if (TextUtils.isEmpty(goodsId)) {
            throw new NullPointerException();
        }

        return goodsId;

    }


    @Override
    public void onClick(View v) {
        if (Utils.NO_NETWORK_STATE == Utils.isNetworkAvailable(this)) {
            switchLayout();
            Utils.showToast(this, getResources().getString(R.string.network_errot_toast));
            return;
        } else {
            mNetworkErrorLayout.setVisibility(View.GONE);

            rlContentView.setVisibility(View.VISIBLE);

            int goodsNums = selectAttributeFragment.getGoodsNums();
            switch (v.getId()) {
                case R.id.goodsinfo_attr:
                    drawerlayout.openDrawer(findViewById(R.id.SelectAttributeFragment));
                    break;
                case R.id.text_cart:
                    //Utils.showToast(GoodsInfoActivity.this, "进入购物车");
                    Intent intentCart = new Intent(this, ShoppingCartActivity.class);
                    startActivity(intentCart);
                    break;
                case R.id.btn_addCart:

                    onAddGoodsToCart(goodsNums, selectAttributeFragment.selectAttrMap);

                    break;
                case R.id.btn_buy:

                    //Utils.showToast(GoodsInfoActivity.this, getGoodsId() + mDatas.data.goods_name + "立即购买");
                    if (!SPUtils.get(this, "key", "").equals("")) {
                        if (goodsNums > 0) {
                            Intent intent = new Intent(this, CreateOrderActivity.class);

                            Log.d("goodsidnumber", getGoodsId() + "-" + goodsNums);
                            intent.putExtra("goodsIdNumber", getGoodsId() + "-" + selectAttributeFragment.getGoodsNums());
                            if(selectAttributeFragment.selectAttrMap.size()>0)
                            intent.putExtra("goodsAttStr", getSelectedAttr(selectAttributeFragment.selectAttrMap).get("selectedAttrId"));
                            else
                            intent.putExtra("goodsAttStr","");
                            intent.putExtra("intentType","1");
                            startActivity(intent);

                        } else Utils.showToast(this, "请填写商品数量！");

                    } else {
                        Intent itLogin = new Intent(this, LoginActivity.class);
                        startActivity(itLogin);
                    }
                    break;

                //从这里掉友盟的分享
                case R.id.txtFriend:
                    //分享的标题
                    //分享的内容
                    //跳转的url
                    //分享时显示的图片
                    new Share(this, mDatas.data.goods_name, mDatas.data.goods_name, "http://shopapi.99-k.com/index.php/goods_index", mDatas.data.album[0]);
                    break;
                //二维码图片
                case R.id.txtQRCode:
                    qrCodePopupwindow.showAtLocation(drawerlayout, Gravity.CENTER, 0, 0);
                    //这里传入商品的id  格式：goods_id:id
                    Bitmap bitmap = CreateQRCode.getQRCode(this, "goods_id:" + getGoodsId());
                    qrCodePopupwindow.getCode(bitmap);
                    break;
                case R.id.btnReloadNetwork:
                    mPresenter.LoadDetatileData(getGoodsId());
                    onResume();
                    break;
            }
        }
    }

    //已选商品的属性
    public Map<String, String> getSelectedAttr(Map<String, Attribute.Attr_Value> attrValueMap) {
        Map<String, String> map = new HashMap<>();
        String selectedStr = "";
        //所选属性价格之和
        BigDecimal bigDecimal = new BigDecimal(0.00);
        //所选属性id
        List<String> selectedAttrList = new ArrayList<>();
        for (Map.Entry<String, Attribute.Attr_Value> entry : attrValueMap.entrySet()) {
            selectedStr += entry.getValue().attr_value_name + ",";

            bigDecimal = bigDecimal.add(new BigDecimal(entry.getValue().attr_value_price));

            selectedAttrList.add(entry.getValue().attr_value_id);
        }
        //属性的价格之和加上商品原价
        bigDecimal = bigDecimal.add(new BigDecimal(mDatas.data.shop_price));
        //商品属性的名称字符串，用于前台显示
        map.put("selectedStr", selectedStr.substring(0, selectedStr.length() - 1));

        map.put("selectedAttrPrice", bigDecimal.toString());
        //属性集合字符串
        map.put("selectedAttrId", selectedAttrList.toString());

        return map;
    }

    //选择的属性回调接口
    @Override
    public void onAttributedSelected(int goodsNum, Map<String, Attribute.Attr_Value> attrValueMap) {

        if(attrValueMap.size()>0) {
            mTextViewGoodsPrice.setText("￥" + getSelectedAttr(attrValueMap).get("selectedAttrPrice"));

            mTextViewGoodsAttr.setText("已选：" + goodsNum + "件" + "," + getSelectedAttr(attrValueMap).get("selectedStr"));

            //属性界面商品价格
            selectAttributeFragment.initGoodsPrice("￥" + getSelectedAttr(selectAttributeFragment.selectAttrMap).get("selectedAttrPrice"));
            //  Utils.showToast(this, selectedStr.substring(0, selectedStr.length() - 1));

            // contentData(content);
        }else{
            mTextViewGoodsAttr.setText("已选：" + goodsNum + "件");
        }
    }

    //加入购物车
    @Override
    public void onAddGoodsToCart(int goodsNum, Map<String, Attribute.Attr_Value> attrValueMap) {
        if (!SPUtils.get(this, "key", "").equals("")) {
            if (goodsNum > 0) {
                boolean res;
                if (mDatas.data.attribute.size() > 0)
                    res = mPresenter.addShoppingCar(String.valueOf(goodsNum), getGoodsId(), getSelectedAttr(attrValueMap).get("selectedAttrId"));
                else
                    res = mPresenter.addShoppingCar(String.valueOf(goodsNum), getGoodsId(), "");
            } else Utils.showToast(this, "请填写商品数量！");
        } else {
            Intent itLogin = new Intent(this, LoginActivity.class);
            startActivity(itLogin);
        }
    }

    @Override
    public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
        if(Utils.NO_NETWORK_STATE != Utils.isNetworkAvailable(this)) {
            if (!SPUtils.get(this, "key", "").equals("")) {
                if (isChecked)
                    mPresenter.addCollect(getGoodsId());
                else
                    mPresenter.cancelCollect(getGoodsId());
            } else {
                if (isChecked)
                    mCheckBoxCollection.setChecked(false);
                else
                    mCheckBoxCollection.setChecked(true);
                Intent itLogin = new Intent(this, LoginActivity.class);
                startActivity(itLogin);
            }
        }else{
            if (isChecked)
                mCheckBoxCollection.setChecked(false);
            else
            mCheckBoxCollection.setChecked(true);
            switchLayout();
        }
    }

    @Override
    public void searchClick() {
        //Utils.showToast(this, "搜索");
        startActivity(new Intent(this, SearchActivity.class));
    }

    @Override
    public void homeClick() {
        ConfigValue.iconFlag = 0;
        Intent mIntent = new Intent(ConfigValue.ACTION_ALTER_CARTGOODS_NUMS);
        mIntent.putExtra("home", 1);
        //发送广播
        sendBroadcast(mIntent);
        AppManager.getAppManager().finishAllActivity();
//        startActivity(new Intent(this, MainActivity.class));
//        finish();
    }

    //标题栏点击搜索分享以及主页
    @Override
    public void shareClick() {
        detail_MenuFragment.hide();
        shareSelectPopupwindow.showAtLocation(drawerlayout, Gravity.BOTTOM | Gravity.CENTER_HORIZONTAL, 0, 0);
    }

    //此处加载购物车商品数量

    @Override
    protected void onResume() {
        super.onResume();
        if (Utils.NO_NETWORK_STATE == Utils.isNetworkAvailable(this)) {
            switchLayout();
        }else{
            PersonalPresenter mPersonalPresenter = new PersonalPresenter(this);
            mPersonalPresenter.getPersonalInfo(this);
        }
    }

    //获取个人信息回调
    @Override
    public void onPersonalInfo(PersonalModel response) {
        this.setCartGoodsNums(response.getData().getNumber());
    }

    @Override
    public void setCartGoodsNums(String nums) {
        CartDrawable cartDrawable = new CartDrawable(this,0);
        cartDrawable.setCatNum(nums);
        text_cart.setCompoundDrawablesWithIntrinsicBounds(null, cartDrawable, null, null);

    }

    @Override
    public void addCartGoodsNums(int nums) {

    }

    public void switchLayout() {

        mNetworkErrorLayout.setVisibility(View.VISIBLE);

        rlContentView.setVisibility(View.GONE);

    }
}

