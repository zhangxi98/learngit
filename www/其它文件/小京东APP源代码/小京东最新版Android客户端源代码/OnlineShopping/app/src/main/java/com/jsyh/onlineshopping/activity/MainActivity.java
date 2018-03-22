package com.jsyh.onlineshopping.activity;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.RadioGroup.OnCheckedChangeListener;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.config.SPConfig;
import com.jsyh.onlineshopping.fragment.CategoryFragment;
import com.jsyh.onlineshopping.fragment.HomeFragment;
import com.jsyh.onlineshopping.fragment.MeFragment;
import com.jsyh.onlineshopping.fragment.ShoppingCartFragment;
import com.jsyh.onlineshopping.http.BaseDelegate;
import com.jsyh.onlineshopping.model.PersonalModel;
import com.jsyh.onlineshopping.presenter.PersonalPresenter;
import com.jsyh.onlineshopping.utils.SPUtils;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.PersonalView;
import com.jsyh.shopping.uilibrary.drawable.CartDrawable;
import com.squareup.okhttp.Request;
import com.umeng.message.IUmengRegisterCallback;
import com.umeng.message.PushAgent;

/**
 *
 */
public class MainActivity extends AppCompatActivity implements
        OnCheckedChangeListener, PersonalView {
    private static FragmentManager fMgr;
    private RadioButton rbHome;
    private RadioButton rbCategory;
    private RadioButton rbShoppingCart;
    private RadioButton rbMe;
    private RadioGroup radioGroup;

    private PushAgent mPushAgent;


    private PersonalPresenter mPresenter;//初始化个人信息

    private String goodsNum = "";

    private RefreshCallback rc;//定义一个接口

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        //初始化个人信息
        mPresenter = new PersonalPresenter(this);

        ConfigValue.DATA_KEY = (String) SPUtils.get(this, SPConfig.KEY,"");



        registerBroadcastReceiver();

        SPUtils.put(this, SPConfig.FRAGMENT, 0);
        // 获取FragmentManager实例
        fMgr = getSupportFragmentManager();
        dealBottomButtonsClickEvent();
        initFragment();
        //网络检查
        if (Utils.NO_NETWORK_STATE == Utils.isNetworkAvailable(this)) {
            Utils.showToast(this,"网络好像阻塞了哦，亲");
        }else
            mPresenter.getPersonalInfo(this);
        //开启推送服务
        mPushAgent = PushAgent.getInstance(this);
        mPushAgent.onAppStart();
        //开启推送并设置注册的回调处理
        mPushAgent.enable(mRegisterCallback);
        //添加别名
//		new AddAliasTask(ConfigValue.QQAPP_KEY, ALIAS_TYPE.QQ).execute();
    }

    @Override
    protected void onStart() {
        super.onStart();

    }

    @Override
    protected void onResume() {
        if (fMgr == null){
            int flag = (int) SPUtils.get(this,SPConfig.FRAGMENT,0);
            // 获取FragmentManager实例
            fMgr = getSupportFragmentManager();
            dealBottomButtonsClickEvent();
            startFragment(flag);
        }
        super.onResume();
        Log.d("resume", "resume.....................");
    }

    private void startFragment(int i){
        FragmentTransaction ft = fMgr.beginTransaction();
        switch (i){
            case 0:
                HomeFragment taskFragment = new HomeFragment();
                ft.replace(R.id.fragmentRoot, taskFragment, "homeFragment");
                ft.addToBackStack("homeFragment");
                ft.commit();
                break;
            case 1:
                CategoryFragment categoryFragment = new CategoryFragment();
                ft.replace(R.id.fragmentRoot, categoryFragment,
                        "categoryFragment");
                ft.addToBackStack("categoryFragment");
                ft.commit();
                break;
            case 2:
                ShoppingCartFragment shoppingCartFragment = new ShoppingCartFragment();
                ft.replace(R.id.fragmentRoot, shoppingCartFragment,
                        "shoppingCartFragment");
                ft.addToBackStack("shoppingCartFragment");
                ft.commit();
                break;
            case 3:
                MeFragment meFragment = new MeFragment();
                ft.replace(R.id.fragmentRoot, meFragment, "meFragment");
                ft.addToBackStack("meFragment");
                ft.commit();
                break;
        }
    }
    @Override
    protected void onDestroy() {
        super.onDestroy();

    }

    private void initData() {
    }

    /**
     * 初始化首个Fragment
     */
    private void initFragment() {
        FragmentTransaction ft = fMgr.beginTransaction();
        HomeFragment homeFragment = new HomeFragment();
        ft.add(R.id.fragmentRoot, homeFragment, "homeFragment");
        ft.addToBackStack("homeFragment");
        ft.commit();

    }

    /**
     * 处理底部点击事件
     */
    private void dealBottomButtonsClickEvent() {

        radioGroup = (RadioGroup) findViewById(R.id.radioGroup);
        rbHome = (RadioButton) findViewById(R.id.rbHome);
        rbCategory = (RadioButton) findViewById(R.id.rbCategory);
        rbShoppingCart = (RadioButton) findViewById(R.id.rbShoppingCart);
        rbMe = (RadioButton) findViewById(R.id.rbMe);
        radioGroup.setOnCheckedChangeListener(this);
    }

    /**
     * 从back stack弹出所有的fragment，保留首页的那个
     */
    public static boolean popAllFragments() {
        for (int i = 0; i < fMgr.getBackStackEntryCount(); i++) {
            fMgr.popBackStack();
        }
        return true;
    }

    // 点击返回按钮
    @Override
    public void onBackPressed() {
        if (fMgr.findFragmentByTag("homeFragment") != null
                && !fMgr.findFragmentByTag("homeFragment").isResumed()) {
            rbHome.toggle();
            SPUtils.put(this, SPConfig.FRAGMENT, 0);
        } else {
            // super.onBackPressed();
//            AppManager.getAppManager().finishAllActivity();
            this.finish();
        }
    }

    @Override
    public void onCheckedChanged(RadioGroup group, int checkedId) {
        FragmentTransaction ft;
        if (checkedId == R.id.rbHome)
            rc.isRefresh(false);
        else
            rc.isRefresh(true);
        switch (checkedId) {
            case R.id.rbHome:
                SPUtils.put(this, SPConfig.FRAGMENT, 0);
                ConfigValue.iconFlag = 0;
                CartDrawable cartDrawableH = new CartDrawable(this,ConfigValue.iconFlag);
                cartDrawableH.setCatNum(goodsNum);
                rbShoppingCart.setCompoundDrawablesWithIntrinsicBounds(null, cartDrawableH, null, null);
                ft = fMgr.beginTransaction();
                if (fMgr.findFragmentByTag("homeFragment") != null) {
                    ft.replace(R.id.fragmentRoot,
                            fMgr.findFragmentByTag("homeFragment"), "homeFragment");
                    ft.commitAllowingStateLoss();
                } else {
                    HomeFragment taskFragment = new HomeFragment();
                    ft.replace(R.id.fragmentRoot, taskFragment, "homeFragment");
                    ft.addToBackStack("homeFragment");
                    ft.commit();
                }
                break;
            case R.id.rbCategory:
                SPUtils.put(this, SPConfig.FRAGMENT, 1);
                ConfigValue.iconFlag = 0;
                CartDrawable cartDrawableC = new CartDrawable(this,ConfigValue.iconFlag);
                cartDrawableC.setCatNum(goodsNum);
                rbShoppingCart.setCompoundDrawablesWithIntrinsicBounds(null, cartDrawableC, null, null);
                ft = fMgr.beginTransaction();
                if (fMgr.findFragmentByTag("categoryFragment") != null) {
                    ft.replace(R.id.fragmentRoot,
                            fMgr.findFragmentByTag("categoryFragment"),
                            "categoryFragment");
                    ft.commitAllowingStateLoss();
                } else {
                    CategoryFragment categoryFragment = new CategoryFragment();
                    ft.replace(R.id.fragmentRoot, categoryFragment,
                            "categoryFragment");
                    ft.addToBackStack("categoryFragment");
                    ft.commit();
                }
                break;
            case R.id.rbShoppingCart:
                SPUtils.put(this, SPConfig.FRAGMENT, 2);
                ConfigValue.iconFlag = 1;
                CartDrawable cartDrawable = new CartDrawable(this,ConfigValue.iconFlag);
                cartDrawable.setCatNum(goodsNum);
                rbShoppingCart.setCompoundDrawablesWithIntrinsicBounds(null, cartDrawable, null, null);
                ft = fMgr.beginTransaction();
                if (fMgr.findFragmentByTag("shoppingCartFragment") != null) {
                    ft.replace(R.id.fragmentRoot,
                            fMgr.findFragmentByTag("shoppingCartFragment"),
                            "shoppingCartFragment");
                    ft.commitAllowingStateLoss();
                } else {
                    ShoppingCartFragment shoppingCartFragment = new ShoppingCartFragment();
                    ft.replace(R.id.fragmentRoot, shoppingCartFragment,
                            "shoppingCartFragment");
                    ft.addToBackStack("shoppingCartFragment");
                    ft.commit();
                }
                break;
            case R.id.rbMe:
                SPUtils.put(this,SPConfig.FRAGMENT,3);
                ConfigValue.iconFlag = 0;
                CartDrawable cartDrawableM = new CartDrawable(this,ConfigValue.iconFlag);
                cartDrawableM.setCatNum(goodsNum);
                rbShoppingCart.setCompoundDrawablesWithIntrinsicBounds(null, cartDrawableM, null, null);
                ft = fMgr.beginTransaction();
                if (fMgr.findFragmentByTag("meFragment") != null) {
                    ft.replace(R.id.fragmentRoot,
                            fMgr.findFragmentByTag("meFragment"), "meFragment");
                    ft.commitAllowingStateLoss();
                } else {
                    MeFragment meFragment = new MeFragment();
                    ft.replace(R.id.fragmentRoot, meFragment, "meFragment");
                    ft.addToBackStack("meFragment");
                    ft.commit();
                }
//                OkHttpClientManager.postAsyn(getApplicationContext(), "https://raw.githubusercontent.com/hongyangAndroid/okhttp-utils/master/user.gson", null, new MyResultCallback(), true, "1");
                break;
            default:
                break;
        }

    }

    public interface RefreshCallback{
        void isRefresh(boolean flag);
    }
    public void setRefresh(RefreshCallback rc){
        this.rc = rc;
    }

    public class MyResultCallback extends BaseDelegate.ResultCallback<User> {

        @Override
        public void onBefore(Request request) {
            super.onBefore(request);
            setTitle("loading...");
        }

        @Override
        public void onAfter() {
            super.onAfter();
            setTitle("Sample-okHttp");
        }

        @Override
        public void onError(Request request, Object tag, Exception e) {
            // TODO Auto-generated method stub

        }

        @Override
        public void onResponse(User u, Object tag) {
            // TODO Auto-generated method stub
            Log.d("test", u.password + "");
            Log.d("test", tag + "");
        }
    }

    public Handler handler = new Handler();
    //此处是注册的回调处理
    //参考集成文档的1.7.10
    //http://dev.umeng.com/push/android/integration#1_7_10
    public IUmengRegisterCallback mRegisterCallback = new IUmengRegisterCallback() {

        @Override
        public void onRegistered(String registrationId) {
            // TODO Auto-generated method stub
            handler.post(new Runnable() {

                @Override
                public void run() {
                    Log.e("token", mPushAgent.getRegistrationId());
                    // TODO Auto-generated method stub
                    if (mPushAgent.isRegistered()) {
                        //成功
                    }
                }
            });
        }
    };

    class AddAliasTask extends AsyncTask<Void, Void, Boolean> {

        String alias;
        String aliasType;

        public AddAliasTask(String aliasString, String aliasTypeString) {
            // TODO Auto-generated constructor stub
            this.alias = aliasString;
            this.aliasType = aliasTypeString;
        }

        protected Boolean doInBackground(Void... params) {
            try {
                return mPushAgent.addAlias(alias, aliasType);
            } catch (Exception e) {
                e.printStackTrace();
            }
            return false;
        }

        @Override
        protected void onPostExecute(Boolean result) {
            if (Boolean.TRUE.equals(result)) {

            }

        }

    }

    //获取个人信息
    @Override
    public void onPersonalInfo(PersonalModel response) {
        if (response.getCode().equals("1"))
        this.setCartGoodsNums(response.getData().getNumber());
    }

    //修改购物车角标回调
    @Override
    public void setCartGoodsNums(String nums) {
        goodsNum = nums;
        CartDrawable cartDrawable = new CartDrawable(this,ConfigValue.iconFlag);
        cartDrawable.setCatNum(nums);
        rbShoppingCart.setCompoundDrawablesWithIntrinsicBounds(null, cartDrawable, null, null);
    }

    //角标增加，用于在商品详情页增加商品至购物车时调用


    @Override
    public void addCartGoodsNums(int nums) {
        int now = Integer.parseInt(goodsNum) + nums;
        goodsNum = String.valueOf(now);
        CartDrawable cartDrawable = (CartDrawable) rbShoppingCart.getCompoundDrawables()[1];
        cartDrawable.addNums(nums);
        cartDrawable.start();
    }

    //注册广播接收商品详情页修改购物车数量之后发送的广播

    private BroadcastReceiver mBroadcastReseiver = new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
            String action = intent.getAction();
            if (action.equals(ConfigValue.ACTION_ALTER_CARTGOODS_NUMS)) {
                int addNum = intent.getIntExtra("addGoodsNums", 0);
                String total = intent.getStringExtra("cartgoodsnum");
                int homeFlag = intent.getIntExtra("home",0);
                if (addNum != 0)
                    addCartGoodsNums(addNum);
                if (null != total && !total.equals(""))
                    setCartGoodsNums(total);
                if(homeFlag != 0)
                    if (fMgr.findFragmentByTag("homeFragment") != null
                            && !fMgr.findFragmentByTag("homeFragment").isResumed()) {
                        rbHome.toggle();
                    }
            }
        }
    };

    public void registerBroadcastReceiver() {
        IntentFilter mIntentFilter = new IntentFilter();
        mIntentFilter.addAction(ConfigValue.ACTION_ALTER_CARTGOODS_NUMS);
        //注册广播
        registerReceiver(mBroadcastReseiver, mIntentFilter);
    }

}
