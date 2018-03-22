package com.jsyh.onlineshopping.activity.me;

import android.content.Context;
import android.os.Handler;
import android.os.Message;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import com.alipay.sdk.app.PayTask;
import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.BaseActivity;
import com.jsyh.onlineshopping.alipay.PayResult;
import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.model.PayModel;
import com.jsyh.onlineshopping.presenter.RechargePresenter;
import com.jsyh.onlineshopping.utils.KeyBoardUtils;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.PayView;

/**
 * Created by sks on 2015/10/28.
 * 账户充值
 */
public class RechargeActivity extends BaseActivity implements View.OnClickListener,PayView {

    TextView title;
    ImageView back;
    private Context context;
    private EditText editMoney;
    private TextView btnEnsure;
    private TextView txtBalance;
    private String money;
    private RechargePresenter rPresenter;

    private static final int SDK_PAY_FLAG = 1;

    private static final int SDK_CHECK_FLAG = 2;

    private Handler mHandler = new Handler() {
        public void handleMessage(Message msg) {
            switch (msg.what) {
                case SDK_PAY_FLAG: {
                    PayResult payResult = new PayResult((String) msg.obj);

                    // 支付宝返回此次支付结果及加签，建议对支付宝签名信息拿签约时支付宝提供的公钥做验签
                    String resultInfo = payResult.getResult();

                    String resultStatus = payResult.getResultStatus();

                    // 判断resultStatus 为“9000”则代表支付成功，具体状态码代表含义可参考接口文档
                    if (TextUtils.equals(resultStatus, "9000")) {
                        finish();
                        Utils.showToast(context, "支付成功");
                    } else {
                        // 判断resultStatus 为非“9000”则代表可能支付失败
                        // “8000”代表支付结果因为支付渠道原因或者系统原因还在等待支付结果确认，最终交易是否成功以服务端异步通知为准（小概率状态）
                        if (TextUtils.equals(resultStatus, "8000")) {
                            Utils.showToast(context,"支付结果确认中");
                        } else {
                            // 其他值就可以判断为支付失败，包括用户主动取消支付，或者系统返回的错误
                            Utils.showToast(context, "支付失败");
                        }
                    }
                    break;
                }
                case SDK_CHECK_FLAG: {
                    if (!(boolean) msg.obj)
                        Utils.showToast(context, "检查结果为：" + msg.obj);
                    else
                        rPresenter.request(context, money);
                    break;
                }
                default:
                    break;
            }
        };
    };
    @Override
    public void initView() {
        super.initView();
        setContentView(R.layout.activity_recharge);
        context = this;
        rPresenter = new RechargePresenter(this);
        title=(TextView)findViewById(R.id.title);
        back = (ImageView)findViewById(R.id.back);
        back.setBackgroundResource(R.mipmap.ic_back);
        title.setText("账户充值");
        findViewById(R.id.fl_Left).setOnClickListener(this);
        txtBalance = (TextView) findViewById(R.id.txtBalance);
        txtBalance.setText("账户余额：￥" + ConfigValue.uInfor.getUser_money());
        editMoney = (EditText) findViewById(R.id.editMoney);
        btnEnsure = (TextView) findViewById(R.id.btnSure);
        editMoney.addTextChangedListener(textWatcher);
    }

    private TextWatcher textWatcher = new TextWatcher() {
        @Override
        public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

        }

        @Override
        public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
            money = editMoney.getText().toString().trim();
            if(!money.equals("")){
                btnEnsure.setTextColor(getResources().getColor(R.color.white));
                btnEnsure.setBackgroundResource(R.drawable.login_on_bg);
                btnEnsure.setClickable(true);
                btnEnsure.setOnClickListener(RechargeActivity.this);
            } else{
                btnEnsure.setTextColor(getResources().getColor(R.color.gary_text));
                btnEnsure.setBackgroundResource(R.drawable.login_off_bg);
                btnEnsure.setClickable(false);
            }
        }

        @Override
        public void afterTextChanged(Editable editable) {

        }
    };
    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.fl_Left:
                KeyBoardUtils.closeKeybord(this);
                break;
            case R.id.btnSure:
//                check();
                rPresenter.request(context, money);
                break;
        }
    }

    @Override
    public void result(PayModel model) {
        if(model.getCode().equals("1")){
            pay(model.getData());
        }else
            Utils.showToast(context,model.getMsg());
    }

    public void pay(final String payInfo) {

        Runnable payRunnable = new Runnable() {

            @Override
            public void run() {
                // 构造PayTask 对象
                PayTask alipay = new PayTask(RechargeActivity.this);
                // 调用支付接口，获取支付结果
                String result = alipay.pay(payInfo);

                Message msg = new Message();
                msg.what = SDK_PAY_FLAG;
                msg.obj = result;
                mHandler.sendMessage(msg);
            }
        };

        // 必须异步调用
        Thread payThread = new Thread(payRunnable);
        payThread.start();
    }

    /**
     * check whether the device has authentication alipay account.
     * 查询终端设备是否存在支付宝认证账户
     *
     */
    public void check() {
        Runnable checkRunnable = new Runnable() {

            @Override
            public void run() {
                // 构造PayTask 对象
                PayTask payTask = new PayTask(RechargeActivity.this);
                // 调用查询接口，获取查询结果
                boolean isExist = payTask.checkAccountIfExist();

                Message msg = new Message();
                msg.what = SDK_CHECK_FLAG;
                msg.obj = isExist;
                mHandler.sendMessage(msg);
            }
        };

        Thread checkThread = new Thread(checkRunnable);
        checkThread.start();

    }
}
