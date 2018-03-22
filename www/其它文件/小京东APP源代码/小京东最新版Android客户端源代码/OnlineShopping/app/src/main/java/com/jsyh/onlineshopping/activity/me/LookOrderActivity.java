package com.jsyh.onlineshopping.activity.me;

import android.content.Context;
import android.content.Intent;
import android.view.View;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.BaseActivity;
import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.model.BaseModel;
import com.jsyh.onlineshopping.model.OrderGoods;
import com.jsyh.onlineshopping.model.OrderInfor;
import com.jsyh.onlineshopping.model.OrderInforModel;
import com.jsyh.onlineshopping.presenter.OrderInforPresenter;
import com.jsyh.onlineshopping.presenter.OrderManagerPresenter;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.OrderInforView;
import com.jsyh.onlineshopping.views.OrderManagerView;
import com.jsyh.shopping.uilibrary.adapter.listview.BaseAdapterHelper;
import com.jsyh.shopping.uilibrary.adapter.listview.QuickAdapter;
import com.jsyh.shopping.uilibrary.uiutils.ListViewUtils;
import com.squareup.picasso.Picasso;

/**
 * Created by sks on 2015/9/30.
 * 查看订单信息
 */
public class LookOrderActivity extends BaseActivity implements View.OnClickListener,
        OrderInforView,OrderManagerView{
    TextView title;
    ImageView back;
    FrameLayout left;
    private Context context;
    private String orderID;
    private OrderInforPresenter oiPresenter;
    private TextView txtOrderNum,txtName,txtPhone,txtAddress,txtPayMode,txtDistribution,
            txtTotal,txtFee,txtTime,txtActual,txtPay,txtCancel,txtBonus,txtIntegralMoney;
    private RelativeLayout rlOrderBottom;
    private ListView listView;
    private QuickAdapter<OrderGoods> quickAdapter;
    private OrderInfor oiModel;
    private OrderManagerPresenter omPresenter;
    @Override
    public void initView() {
        super.initView();
        setContentView(R.layout.activity_lookorder);
        context = this;
        oiPresenter = new OrderInforPresenter(this);
        omPresenter = new OrderManagerPresenter(this);
        orderID = getIntent().getStringExtra("orderid");
        title=(TextView)findViewById(R.id.title);
        back = (ImageView)findViewById(R.id.back);
        left = (FrameLayout) findViewById(R.id.fl_Left);
        back.setBackgroundResource(R.mipmap.ic_back);
        title.setText("订单详情");
        left.setOnClickListener(this);
        txtOrderNum = (TextView) findViewById(R.id.txtOrderNum);
        txtName = (TextView) findViewById(R.id.txtName);
        txtPhone = (TextView) findViewById(R.id.txtPhone);
        txtAddress = (TextView) findViewById(R.id.txtAddress);
        txtPayMode = (TextView) findViewById(R.id.txtPayMode);
        txtBonus = (TextView) findViewById(R.id.txtBonus);
        txtIntegralMoney = (TextView) findViewById(R.id.txtIntegralMoney);
        txtDistribution = (TextView) findViewById(R.id.txtDistribution);
        txtTotal = (TextView) findViewById(R.id.txtTotal);
        txtFee = (TextView) findViewById(R.id.txtFee);
        txtTime = (TextView) findViewById(R.id.txtTime);
        txtActual = (TextView) findViewById(R.id.txtActual);
        listView = (ListView) findViewById(R.id.listView);
        quickAdapter = new QuickAdapter<OrderGoods>(context,R.layout.order_good_item) {
            @Override
            protected void convert(BaseAdapterHelper helper, OrderGoods item) {
                Picasso.with(context).load(ConfigValue.IMG_IP
                        + item.getGoods_thumb())
                        .error(R.mipmap.ic_launcher)
                        .into((ImageView) helper.getView(R.id.imgGoods));
                helper.setText(R.id.txtTitle, item.getGoods_name());
                helper.setText(R.id.txtPrice, "￥" + item.getGoods_price());
                helper.setText(R.id.txtNumber,"数量：" + item.getGoods_number());
            }
        };
        rlOrderBottom = (RelativeLayout) findViewById(R.id.rlOrderBottom);
        listView.setAdapter(quickAdapter);
        txtPay = (TextView) findViewById(R.id.txtPay);
        txtCancel = (TextView) findViewById(R.id.txtCancel);
        txtPay.setOnClickListener(this);
        txtCancel.setOnClickListener(this);
        oiPresenter.loadOrderInfor(context,orderID);
    }
    private void showData(OrderInfor model){
        txtOrderNum.setText("订单号：" + model.getOrder_sn());
        txtName.setText(model.getConsignee());
        txtPhone.setText(model.getMobile());
        txtAddress.setText(model.getAddress());
        txtPayMode.setText(model.getPay_name());
        txtDistribution.setText(model.getShipping_name());
        if (!model.getBonus().equals("0.00") && !model.getBonus().equals(""))
            txtBonus.setText("￥" + model.getBonus());
        if (!model.getIntegral_money().equals("0.00") && !model.getIntegral_money().equals(""))
            txtIntegralMoney.setText("￥" + model.getIntegral_money());
        txtTotal.setText("￥" + model.getTotal());
        txtFee.setText("+￥" + model.getShipping_fee());
        txtTime.setText(Utils.time(context, Long.parseLong(model.getAdd_time())));
        txtActual.setText("实付款：￥" + model.getMoney_paid());
        quickAdapter.clear();
        quickAdapter.addAll(model.getGoods());
        ListViewUtils.setListViewHeightBasedOnItems(listView);
        switch (Integer.parseInt(model.getOrder_status())){
            case 1:
                title.setText("待付款");
                break;
            case 2:
                title.setText("已取消");
                txtPay.setText("放回购物车");
//                txtCancel.setText("删除");
                txtCancel.setVisibility(View.GONE);
                break;
            case 3:
                title.setText("待发货");
                rlOrderBottom.setVisibility(View.GONE);
                break;
            case 4:
                title.setText("已发货");
                txtPay.setText("确认收货");
                txtCancel.setVisibility(View.GONE);
                break;
            case 5:
                title.setText("已完成");
                txtPay.setText("再次购买");
                txtCancel.setVisibility(View.GONE);
                break;
        }
    }
    //订单详情返回
    @Override
    public void result(OrderInforModel model) {
        if (model.getCode().equals("1")){
            oiModel = model.getData().get(0);
            showData(model.getData().get(0));
        }else
            Utils.showToast(context,model.getMsg());
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.fl_Left:
                finish();
                break;
            case R.id.txtPay:
                switch (Integer.parseInt(oiModel.getOrder_status())){
                    case 1:
                        //支付
                        pay();
                        break;
                    case 2:
                    case 5:
                        Utils.showDialog(LookOrderActivity.this, "提示", "是否重新放回购物车？", "", "", new View.OnClickListener() {

                            @Override
                            public void onClick(View view) {
                                switch (view.getId()) {
                                    case R.id.txtDialogCancel:
                                        Utils.dismissDialog();
                                        break;
                                    case R.id.txtDialogSure:
                                        omPresenter.cartOrder(context, orderID);
                                        Utils.dismissDialog();
                                        break;
                                }
                            }
                        });
                        break;
                    case 4:
                        Utils.showDialog(LookOrderActivity.this, "提示", "是否确认收货？", "", "", new View.OnClickListener() {
                            @Override
                            public void onClick(View view) {
                                switch (view.getId()) {
                                    case R.id.txtDialogCancel:
                                        Utils.dismissDialog();
                                        break;
                                    case R.id.txtDialogSure:
                                        //确认收货
                                        omPresenter.sureOrder(context, orderID);
                                        Utils.dismissDialog();
                                        break;
                                }
                            }
                        });
                        break;
                }
                break;
            case R.id.txtCancel:
                switch (Integer.parseInt(oiModel.getOrder_status())){
                    case 1:
                        cancelOrder();
                        break;
                }
                break;
        }
    }
    private void cancelOrder(){
        Utils.showDialog(LookOrderActivity.this, "提示", "确认要取消订单吗？", "", "", new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                switch (view.getId()) {
                    case R.id.txtDialogCancel:
                        Utils.dismissDialog();
                        break;
                    case R.id.txtDialogSure:
                        omPresenter.cancelOrder(context,orderID);
                        Utils.dismissDialog();
                        break;
                }
            }
        });
    }
    private void pay(){
        Intent intent = new Intent(context,PayActivity.class);
        intent.putExtra("class",1);
        intent.putExtra("ordernumber",oiModel.getOrder_sn());
        intent.putExtra("ordermoney",oiModel.getMoney_paid());
        startActivity(intent);
    }
    //对订单操作的返回
    @Override
    public void result(BaseModel model) {
        if(model.getCode().equals("1"))
            oiPresenter.loadOrderInfor(context, orderID);
        Utils.showToast(context,model.getMsg());
    }
}
