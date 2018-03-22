package com.jsyh.onlineshopping.activity.me;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.BaseActivity;
import com.jsyh.onlineshopping.model.Address;
import com.jsyh.onlineshopping.model.Bouns;
import com.jsyh.onlineshopping.model.CreateOrder;
import com.jsyh.onlineshopping.model.CreateOrderModel;
import com.jsyh.onlineshopping.model.Distribution;
import com.jsyh.onlineshopping.model.Goods;
import com.jsyh.onlineshopping.model.SubmitOrderModel;
import com.jsyh.onlineshopping.presenter.CreateOrderPresenter;
import com.jsyh.onlineshopping.presenter.SubmitOrderPresenter;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.CreateOrderView;
import com.jsyh.shopping.uilibrary.adapter.listview.BaseAdapterHelper;
import com.jsyh.shopping.uilibrary.adapter.listview.QuickAdapter;
import com.jsyh.shopping.uilibrary.uiutils.ListViewUtils;
import com.squareup.picasso.Picasso;

/**
 * Created by sks on 2015/10/8.
 *
 * 生成订单
 */
public class CreateOrderActivity extends BaseActivity implements View.OnClickListener,
        CreateOrderView {
    TextView title;
    ImageView back;
    private Context context;
    private Distribution dModel = new Distribution();
    private Address aModel = new Address();
    private Bouns bModel = new Bouns();
    private TextView txtDistribution, txtFee, txtName, txtPhone, txtAddress,
            txtGoodPrice, txtTotal, textCoupon, txtButton, txtSubmit, editIntegral,
            txtBonus;
    private EditText editContent,editIntegrala;
    public static final int DISTRIBUTION = 1;
    public static final int ADDRESS = 2;
    public static final int ENVELOPE = 3;
    public static final int CANCLE_ENVELOPE = 4;
    private CreateOrderPresenter coPresenter;
    private SubmitOrderPresenter soPresenter;
    private String goods;
    private String attribute;
    private ListView listView;
    private QuickAdapter<Goods> quickAdapter;
    private boolean freight = false;
    private String addressID = "";

    private String itType;
    //运费
    private double fee = 0;
    //红包
    private double bonus = 0;
    //积分
    private double integral = 0;
    @Override
    public void initView() {
        super.initView();
        setContentView(R.layout.activity_createorder);
        context = this;
        goods = getIntent().getStringExtra("goodsIdNumber");
        attribute = getIntent().getStringExtra("goodsAttStr");
        itType = getIntent().getStringExtra("intentType");
        coPresenter = new CreateOrderPresenter(this);
        soPresenter = new SubmitOrderPresenter(this);
        title=(TextView)findViewById(R.id.title);
        back = (ImageView)findViewById(R.id.back);
        back.setBackgroundResource(R.mipmap.ic_back);
        title.setText("确认订单");
        findViewById(R.id.fl_Left).setOnClickListener(this);
        txtDistribution = (TextView) findViewById(R.id.txtDistribution);
        txtFee = (TextView) findViewById(R.id.txtFee);
        txtName = (TextView) findViewById(R.id.txtName);
        txtPhone = (TextView) findViewById(R.id.txtPhone);
        txtAddress = (TextView) findViewById(R.id.txtAddress);
        textCoupon = (TextView) findViewById(R.id.textCoupon);
        txtButton = (TextView) findViewById(R.id.txtButton);
        txtSubmit = (TextView) findViewById(R.id.txtSubmit);
        txtBonus = (TextView) findViewById(R.id.txtBonus);
        editContent = (EditText) findViewById(R.id.editContent);
        editIntegral = (TextView) findViewById(R.id.editIntegral);
        editIntegrala = (EditText) findViewById(R.id.editIntegrala);
        editIntegrala.addTextChangedListener(new editChangeListener());
        listView = (ListView) findViewById(R.id.listView);
        quickAdapter = new QuickAdapter<Goods>(context,R.layout.order_good_item) {
            @Override
            protected void convert(BaseAdapterHelper helper, Goods item) {
                Picasso.with(context).load(item.getGoods_img())
                        .error(R.mipmap.ic_launcher)
                        .into((ImageView) helper.getView(R.id.imgGoods));
                helper.setText(R.id.txtTitle, item.getTitle());
                helper.setText(R.id.txtPrice, "￥" + item.getPrice());
                helper.setText(R.id.txtNumber,"数量：" + item.getShop_num());
                if (item.getShipping().equals("0"))
                    freight = true;
            }
        };
        listView.setAdapter(quickAdapter);
        txtGoodPrice = (TextView) findViewById(R.id.txtGoodPrice);
        txtTotal = (TextView) findViewById(R.id.txtTotal);
        findViewById(R.id.layoutAddress).setOnClickListener(this);
        findViewById(R.id.rlDistribution).setOnClickListener(this);
        findViewById(R.id.rlBouns).setOnClickListener(this);
        txtSubmit.setOnClickListener(this);
        coPresenter.loadOrderInfor(context,goods,"","");
    }
    class editChangeListener implements TextWatcher{
        @Override
        public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

        }

        @Override
        public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
            String chage = editIntegrala.getText().toString().trim();
            if(!chage.equals("")) {
                if (Double.parseDouble(chage) > Double.parseDouble(coModel.getIntegrala())) {
                    Utils.showToast(context, "不能超出抵用限额");
                    editIntegrala.setText("");
                }else if(Double.parseDouble(chage)> Double.parseDouble(coModel.getIntegral())){
                    Utils.showToast(context, "您的抵用金额不足");
                    editIntegrala.setText("");
                } else {
                    txtButton.setBackgroundResource(R.drawable.login_on_bg);
                    txtButton.setTextColor(getResources().getColor(R.color.white));
                    txtButton.setEnabled(true);
                    txtButton.setOnClickListener(CreateOrderActivity.this);
                }
            }else {
                integral = 0.00;
                count();
                txtButton.setBackgroundResource(R.drawable.login_off_bg);
                txtButton.setTextColor(getResources().getColor(R.color.bottom_bg));
                txtButton.setEnabled(false);
            }
        }

        @Override
        public void afterTextChanged(Editable editable) {

        }
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (resultCode != RESULT_OK){
            Bundle b = new Bundle();
            if(null == data) {
                return;
            }
            b = data.getExtras();
            switch (resultCode){
                //接收配送信息
                case DISTRIBUTION:
                    dModel = (Distribution)b.getSerializable("distribution");
                    txtDistribution.setText(dModel.getShipping_name());
                    if (freight){
                        txtFee.setText("+" + dModel.getShipp_fee());
                        fee = Double.parseDouble(dModel.getShipp_fee());
                    }
                    count();
                    break;
                //接收地址
                case ADDRESS:
                    aModel = (Address)b.getSerializable("orderaddress");
                    addressID = aModel.getAddress_id();
                    txtName.setText(aModel.getUsername());
                    txtPhone.setText(aModel.getTelnumber());
                    txtAddress.setText(aModel.getAddress());
                    break;
                //接收红包
                case ENVELOPE:
                    bModel = (Bouns)b.getSerializable("envelope");
                    textCoupon.setText(bModel.getType_name());
                    txtBonus.setText(bModel.getType_money());
                    bonus = Double.valueOf(bModel.getType_money());
                    count();
                    break;
                case CANCLE_ENVELOPE:
                    textCoupon.setText("选择红包");
                    txtBonus.setText("");
                    bonus = 0.00;
                    count();
                    break;
            }
        }
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.fl_Left:
                finish();
                break;
            //选择收货地址
            case R.id.layoutAddress:
                Intent itA = new Intent(context,AddressListActivity.class);
                itA.putExtra("order",true);
                startActivityForResult(itA, 1);
                break;
            //选择配送方式
            case R.id.rlDistribution:
                Intent itD = new Intent(context,DistributionActivity.class);
                startActivityForResult(itD, 1);
                break;
            //选择红包
            case R.id.rlBouns:
                Intent itE = new Intent(context,EnvelopeActivity.class);
                itE.putExtra("goodstotal",coModel.getTotal());
                startActivityForResult(itE, 1);
                break;
            case R.id.txtButton:
                integral = Double.parseDouble(editIntegrala.getText().toString().trim());
                count();
                break;
            //提交订单
            case R.id.txtSubmit:
                submitExamine();
                break;
        }
    }
    //计算实际花费
    private void count(){
        double now = Double.parseDouble(coModel.getTotal()) - bonus + fee - integral;
        if (now <= 0)
            txtTotal.setText("0.00");
        else
            txtTotal.setText(now + "");
    }
    private void submitExamine(){

        if(null == addressID || addressID.equals("")){
            Utils.showToast(context,"请选择收货地址");
            return;
        }
        if(null == dModel.getShipping_id() || dModel.getShipping_id().equals("")){
            Utils.showToast(context,"请选择配送方式");
            return;
        }

        String b_money = bModel.getType_money() == null?"":bModel.getType_money();
        String b_ID = bModel.getBonus_id() == null?"" : bModel.getBonus_id();
        String b_typeID = bModel.getBonus_type_id() == null?"":bModel.getBonus_type_id();
        String spend = txtTotal.getText().toString().trim();
        soPresenter.request(context, goods, addressID, coModel.getTotal(), spend,
                String.valueOf(fee), dModel.getShipping_id(), b_money, b_ID,
                b_typeID, editContent.getText().toString(),
                String.valueOf(integral), attribute, itType);
    }
    private CreateOrder coModel = new CreateOrder();
    //订单信息返回
    @Override
    public void getOrderInfor(CreateOrderModel model) {
        switch (Integer.parseInt(model.getCode())){
            case 0:
                Utils.showToast(context,model.getMsg());
                break;
            case 1:
                coModel = model.getData();
                txtAddress.setText(coModel.getAddress());
                txtPhone.setText(coModel.getMobile());
                txtName.setText(coModel.getUser_name());
                showData();
                break;
            case 3:
                Utils.showDialog(this, "提示", model.getMsg(), "", "", new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        finish();
                    }
                });
                break;
            //没有收货地址去选择
            case 4:
                coModel = model.getData();
                showData();
                Intent intent = new Intent(context,AddressListActivity.class);
                intent.putExtra("order",true);
                startActivityForResult(intent, 1);
                Utils.showToast(context,model.getMsg());
                break;
            case -220:
                Utils.showToast(context,model.getMsg());
                finish();
                break;
        }
    }
    private void showData(){
        addressID = coModel.getAddress_id();
        editIntegral.setText(coModel.getIntegral() + "可用");
        String integrala = coModel.getIntegrala() == null?"0":coModel.getIntegrala();
        editIntegrala.setHint("本订单可使用" + integrala);
        if(coModel.getIntegral().equals("0"))
            editIntegral.setEnabled(false);
        quickAdapter.addAll(coModel.getGoods());
        ListViewUtils.setListViewHeightBasedOnItems(listView);
        txtGoodPrice.setText(coModel.getTotal());
        txtTotal.setText(coModel.getTotal());
    }
    //提交订单返回
    @Override
    public void result(SubmitOrderModel model) {
        if(model.getCode().equals("1")){
            Intent intent = new Intent(context,PayActivity.class);
            intent.putExtra("class",0);
            intent.putExtra("ordernumber",model.getData().getOrder_sn());
            intent.putExtra("ordermoney",model.getData().getMoney_paid());
            startActivity(intent);
            finish();
        }
        Utils.showToast(context,model.getMsg());
    }
}
