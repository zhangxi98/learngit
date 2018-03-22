package com.jsyh.onlineshopping.fragment;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.GoodsCollectActivity;
import com.jsyh.onlineshopping.activity.me.AddressListActivity;
import com.jsyh.onlineshopping.activity.me.FeedbackActivity;
import com.jsyh.onlineshopping.activity.me.LoginActivity;
import com.jsyh.onlineshopping.activity.me.MeAccountActivity;
import com.jsyh.onlineshopping.activity.me.MeBounsActivity;
import com.jsyh.onlineshopping.activity.me.MoreActicity;
import com.jsyh.onlineshopping.activity.me.MyOrderActivity;
import com.jsyh.onlineshopping.activity.me.RechargeActivity;
import com.jsyh.onlineshopping.activity.me.RegisterActivity;
import com.jsyh.onlineshopping.activity.me.TypeOrderActivity;
import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.config.SPConfig;
import com.jsyh.onlineshopping.model.MeIconModel;
import com.jsyh.onlineshopping.model.UserInforModel;
import com.jsyh.onlineshopping.presenter.UserInforPresenter;
import com.jsyh.onlineshopping.utils.SPUtils;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.PersonalView;
import com.jsyh.onlineshopping.views.UserInforView;
import com.jsyh.shopping.uilibrary.GridViewFixScroll;
import com.jsyh.shopping.uilibrary.adapter.listview.BaseAdapterHelper;
import com.jsyh.shopping.uilibrary.adapter.listview.QuickAdapter;
import com.jsyh.shopping.uilibrary.uiutils.ImageUtils;

import java.io.File;
import java.util.ArrayList;

/**
 * 个人中心
 */
public class MeFragment extends BaseFragment implements OnItemClickListener, View.OnClickListener,
        UserInforView {

    private QuickAdapter<MeIconModel> mQuickAdapter;
    private String[] items = {"待付款", "待发货", "待收货", "已完成"};
    private int[] icons = {R.mipmap.wait_payment, R.mipmap.wait_deliver,
            R.mipmap.wait_receive, R.mipmap.after_sale};
    private MeIconModel miModel;
    private ImageView headphoto;
    private LinearLayout lineLay_not_login;
    private RelativeLayout lineLay_login;
    private TextView txtNickname;
    private TextView txtIntegral;
    private TextView balance;            //余额
    private TextView attention;            //关注
    private UserInforPresenter uPresenter;

    private PersonalView mPersonalView;

    private View mView;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Log.d("TEST", "创建MeFragment");
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        mView = inflater.inflate(R.layout.fragment_me, container, false);
        return mView;
    }

//	@Override
//	protected void initTitle() {
//		super.initTitle();
//		title.setText(R.string.string_Me);
//		back.setVisibility(View.VISIBLE);
//		back.setBackgroundResource(R.mipmap.setting_icon);
//		back.setOnClickListener(this);
//		Drawable d = getResources().getDrawable(R.mipmap.setting_icon);
//		d.setBounds(0,0,50,50);
//		ensure.setCompoundDrawables(d, null, null, null);
//		ensure.setOnClickListener(this);
//	}

    @Override
    protected void initView() {
        mView.findViewById(R.id.titleView).setVisibility(View.GONE);
        //title_bar 背景色
//        mView.findViewById(R.id.custom_title_bar).setBackgroundColor(ContextCompat.getColor(getActivity(),R.color.nav_color));

        uPresenter = new UserInforPresenter(this);
        ArrayList<MeIconModel> list = new ArrayList<>();
        for (int i = 0; i < items.length; i++) {
            miModel = new MeIconModel();
            miModel.setItems(items[i]);
            miModel.setIcon(icons[i]);
            list.add(miModel);
        }
        GridViewFixScroll gridView = (GridViewFixScroll) mView.findViewById(R.id.gridview);
        mQuickAdapter = new QuickAdapter<MeIconModel>(getActivity(), R.layout.me_grid_item) {
            @Override
            protected void convert(BaseAdapterHelper helper, MeIconModel item) {
                helper.getView(R.id.imgIcon).setBackgroundResource(item.getIcon());
                helper.setText(R.id.txtItem, item.getItems());
                TextView txtOrderNum = helper.getView(R.id.txtOrderNum);
                TextView txtOrderFlag = helper.getView(R.id.txtOrderFlag);
                if (null != item.getNum() && !item.getNum().equals("")
                        && !item.getNum().equals("0")) {
                    txtOrderNum.setVisibility(View.VISIBLE);
                    if (Integer.parseInt(item.getNum()) > 99) {
                        txtOrderNum.setText("99");
                        txtOrderFlag.setVisibility(View.VISIBLE);
                    } else {
                        txtOrderNum.setText(item.getNum());
                        txtOrderFlag.setVisibility(View.GONE);
                    }
                } else
                    txtOrderNum.setVisibility(View.GONE);
            }
        };
        mQuickAdapter.addAll(list);
        gridView.setAdapter(mQuickAdapter);
        gridView.setOnItemClickListener(this);
        lineLay_not_login = (LinearLayout) mView.findViewById(R.id.lineLay_not_login);
        lineLay_login = (RelativeLayout) mView.findViewById(R.id.lineLay_login);
        headphoto = (ImageView) mView.findViewById(R.id.imgHead);
        txtNickname = (TextView) mView.findViewById(R.id.txtNickname);
        txtIntegral = (TextView) mView.findViewById(R.id.txtIntegral);
        attention = (TextView) mView.findViewById(R.id.txtAttention);
        balance = (TextView) mView.findViewById(R.id.txtBalance);
        mView.findViewById(R.id.lineLay_ll).setOnClickListener(this);
        mView.findViewById(R.id.txtLogin).setOnClickListener(this);
        mView.findViewById(R.id.txtRegister).setOnClickListener(this);
        mView.findViewById(R.id.rlOrder).setOnClickListener(this);
        mView.findViewById(R.id.rlIdea).setOnClickListener(this);
        mView.findViewById(R.id.F_right).setOnClickListener(this);
        mView.findViewById(R.id.rlQuit).setOnClickListener(this);
        mView.findViewById(R.id.lineLayAttention).setOnClickListener(this);
        mView.findViewById(R.id.lineLayBalance).setOnClickListener(this);
        mView.findViewById(R.id.rlAddress).setOnClickListener(this);
        mView.findViewById(R.id.rlBouns).setOnClickListener(this);
    }

    //图片保存在本地，查看本地有无头像，若有则显示，没有则不显示

    private void initHeadPhoto() {
        String filePath = ConfigValue.HEAD_PHOTO_DIR + File.separator + ConfigValue.uInfor.getNick_name() + ".jpg";
        File file = new File(filePath);
        if (file.exists()) {
            Bitmap bitmap = ImageUtils.compressBitmap(filePath, 320, 320);
            if (bitmap != null) {
                headphoto.setVisibility(View.VISIBLE);
                headphoto.setImageBitmap(bitmap);
                // bitmap.recycle();
            }

        }
    }

    @Override
    protected void initData() {
    }

    @Override
    public void onItemClick(AdapterView<?> adapterView, View view,
                            int position, long id) {
        if (network()) {
            if (!ConfigValue.DATA_KEY.equals("")) {
                switch (position) {
                    //待付款
                    case 0:
                        Intent intent = new Intent(context, TypeOrderActivity.class);
                        intent.putExtra("type", 0);
                        startActivity(intent);
                        break;
                    //待发货
                    case 1:
                        Intent intent1 = new Intent(context, TypeOrderActivity.class);
                        intent1.putExtra("type", 1);
                        startActivity(intent1);
                        break;
                    //待收货
                    case 2:
                        Intent intent2 = new Intent(context, TypeOrderActivity.class);
                        intent2.putExtra("type", 2);
                        startActivity(intent2);
                        break;
                    //已完成
                    case 3:
                        Intent intent3 = new Intent(context, TypeOrderActivity.class);
                        intent3.putExtra("type", 3);
                        startActivity(intent3);
                        break;
                }
            } else
                toLogin();
        }
    }

    private void toLogin() {
        Intent itLogin = new Intent(getActivity(), LoginActivity.class);
        startActivity(itLogin);
    }

    @Override
    public void onClick(View v) {
        super.onClick(v);
        switch (v.getId()) {
            //设置
            case R.id.F_right:
                Intent itMore = new Intent(getActivity(), MoreActicity.class);
                startActivity(itMore);
                break;
            //消息
//			case R.id.ensure:
//				if(!ConfigValue.DATA_KEY.equals("")) {
//					Intent itMessage = new Intent(getActivity(), MessageActivity.class);
//					startActivity(itMessage);
//				}else
//					toLogin();
//				break;
            //我的账户
            case R.id.lineLay_ll:
                if (network()) {
                    Intent intent = new Intent(getActivity(), MeAccountActivity.class);
                    startActivity(intent);
                }
                break;
            //登陆
            case R.id.txtLogin:
                toLogin();
                break;
            //注册
            case R.id.txtRegister:
                Intent itRegister = new Intent(getActivity(), RegisterActivity.class);
                startActivity(itRegister);
                break;
            //关注
            case R.id.lineLayAttention:
                if (network()) {
                    if (!ConfigValue.DATA_KEY.equals("")) {
                        Intent itOrder = new Intent(getActivity(), GoodsCollectActivity.class);
                        startActivity(itOrder);
                    } else
                        toLogin();
                }
                break;
            //充值
            case R.id.lineLayBalance:
                if (network()) {
                    if (!ConfigValue.DATA_KEY.equals("")) {
                        Intent itOrder = new Intent(getActivity(), RechargeActivity.class);
                        startActivity(itOrder);
                    } else
                        toLogin();
                }
                break;
            //订单
            case R.id.rlOrder:
                if (network()) {
                    if (!ConfigValue.DATA_KEY.equals("")) {
                        Intent itOrder = new Intent(getActivity(), MyOrderActivity.class);
                        startActivity(itOrder);
                    } else
                        toLogin();
                }
                break;
            //地址管理
            case R.id.rlAddress:
                if (network()) {
                    if (!ConfigValue.DATA_KEY.equals("")) {
                        Intent itAddress = new Intent(context, AddressListActivity.class);
                        startActivity(itAddress);
                    }else
                        toLogin();
                }
                break;
            //红包
            case R.id.rlBouns:
                if (network()) {
                    if (!ConfigValue.DATA_KEY.equals("")) {
                        Intent itAddress = new Intent(context, MeBounsActivity.class);
                        startActivity(itAddress);
                    }else
                        toLogin();
                }
                break;
            //意见
            case R.id.rlIdea:
                if (network()) {
                    Intent itFeedback = new Intent(context, FeedbackActivity.class);
                    startActivity(itFeedback);
                }
                break;
            //退出
            case R.id.rlQuit:
                if (!ConfigValue.DATA_KEY.equals("")) {
                    Utils.showDialog(getActivity(), "提示", "确定退出登陆吗？", "", "", new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            switch (view.getId()) {
                                case R.id.txtDialogCancel:
                                    Utils.dismissDialog();
                                    break;
                                case R.id.txtDialogSure:
                                    ConfigValue.uInfor = null;
                                    ConfigValue.DATA_KEY = "";
                                    SPUtils.remove(getActivity(), SPConfig.KEY);
                                    lineLay_not_login.setVisibility(View.VISIBLE);
                                    lineLay_login.setVisibility(View.GONE);
                                    mPersonalView.setCartGoodsNums("0");
                                    initGrid();
                                    headphoto.setVisibility(View.INVISIBLE);
                                    mView.findViewById(R.id.rlQuit).setVisibility(View.GONE);
                                    Utils.dismissDialog();
                                    break;
                            }
                        }
                    });
                }
                break;
        }
    }

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        //实例化mPersonalView
        mPersonalView = (PersonalView) context;
    }

    @Override
    public void inforData(UserInforModel model) {
        if (model.getCode().equals("1")) {
            ConfigValue.uInfor = model.getData().get(0);
            showInfor();
        } else {
            if (model.getCode().equals("-220")) {
                SPUtils.remove(getActivity(), SPConfig.KEY);
            }
            Utils.showToast(context, model.getMsg());
        }

    }

    private void showInfor() {
        lineLay_not_login.setVisibility(View.GONE);
        lineLay_login.setVisibility(View.VISIBLE);
        mView.findViewById(R.id.rlQuit).setVisibility(View.VISIBLE);
        txtNickname.setText(ConfigValue.uInfor.getNick_name());
        txtIntegral.setText(ConfigValue.uInfor.getIntegration());
        attention.setText(ConfigValue.uInfor.getAttention());
        balance.setText(ConfigValue.uInfor.getUser_money());
        ArrayList<MeIconModel> list = new ArrayList<>();
        for (int i = 0; i < items.length; i++) {
            miModel = new MeIconModel();
            miModel.setItems(items[i]);
            miModel.setIcon(icons[i]);
            switch (i) {
                case 0:
                    miModel.setNum(ConfigValue.uInfor.getPay());
                    break;
                case 1:
                    miModel.setNum(ConfigValue.uInfor.getShipping_send());
                    break;
                case 2:
                    miModel.setNum(ConfigValue.uInfor.getShipping());
                    break;
            }
            list.add(miModel);
        }
        mQuickAdapter.clear();
        mQuickAdapter.addAll(list);
        initHeadPhoto();
    }

    private void initGrid() {
        ArrayList<MeIconModel> list = new ArrayList<>();
        for (int i = 0; i < items.length; i++) {
            miModel = new MeIconModel();
            miModel.setItems(items[i]);
            miModel.setIcon(icons[i]);
            list.add(miModel);
        }
        mQuickAdapter.clear();
        mQuickAdapter.addAll(list);
    }

    private boolean network() {
        if (Utils.NO_NETWORK_STATE == Utils.isNetworkAvailable(getContext())) {
            Utils.showDialog(getActivity(), "提示", "您现在的网络不是太好哦！", "", "重试", new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    switch (view.getId()) {
                        case R.id.txtDialogCancel:
                            Utils.dismissDialog();
                            break;
                        case R.id.txtDialogSure:
                            Utils.dismissDialog();
                            onResume();
                            break;
                    }
                }
            });
            return false;
        }
        return true;
    }

    private void initUserData() {
//		if(null != ConfigValue.uInfor){
//			showInfor();
//		}else{
        ConfigValue.DATA_KEY = (String) SPUtils.get(getActivity(), SPConfig.KEY, "");
        if (ConfigValue.DATA_KEY != null && !ConfigValue.DATA_KEY.equals("")) {
            uPresenter.loadInfor(getActivity());
        } else {
            lineLay_not_login.setVisibility(View.VISIBLE);
            lineLay_login.setVisibility(View.GONE);
            mView.findViewById(R.id.rlQuit).setVisibility(View.GONE);
        }
//		}
    }

    @Override
    public void onResume() {
        if (network())
            initUserData();
        super.onResume();
    }

}
