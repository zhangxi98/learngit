package com.jsyh.onlineshopping.activity.me;

import android.content.Context;
import android.content.Intent;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import com.baoyz.widget.PullRefreshLayout;
import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.BaseActivity;
import com.jsyh.onlineshopping.activity.ShoppingCartActivity;
import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.model.BaseModel;
import com.jsyh.onlineshopping.model.Order;
import com.jsyh.onlineshopping.model.OrderGoods;
import com.jsyh.onlineshopping.model.OrderModel;
import com.jsyh.onlineshopping.presenter.MyOrderPresenter;
import com.jsyh.onlineshopping.presenter.OrderManagerPresenter;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.MyOrderView;
import com.jsyh.onlineshopping.views.OrderManagerView;
import com.jsyh.shopping.uilibrary.adapter.listview.BaseAdapterHelper;
import com.jsyh.shopping.uilibrary.adapter.listview.QuickAdapter;
import com.jsyh.shopping.uilibrary.uiutils.ListViewUtils;
import com.squareup.picasso.Picasso;

/**
 * Created by sks on 2015/9/29.
 * 我的订单
 */
public class MyOrderActivity extends BaseActivity implements View.OnClickListener,
        AdapterView.OnItemClickListener,MyOrderView,OrderManagerView{
    private Context context;
    TextView title;
    ImageView back;
    private ListView listView;
    private QuickAdapter<Order> quickAdapter;
    private MyOrderPresenter presenter;
    private PullRefreshLayout pullRefreshLayout;
    private OrderManagerPresenter omPresenter;
    private boolean cartFlag = false;//放回购物车标识
    @Override
    public void initView() {
        super.initView();
        setContentView(R.layout.activity_myorder);
        context = this;
        presenter = new MyOrderPresenter(this);
        omPresenter = new OrderManagerPresenter(this);
        title=(TextView)findViewById(R.id.title);
        back = (ImageView)findViewById(R.id.back);
        back.setBackgroundResource(R.mipmap.ic_back);
        title.setText("全部订单");
        findViewById(R.id.fl_Left).setOnClickListener(this);
        pullRefreshLayout = (PullRefreshLayout) findViewById(R.id.pullRefreshLayout);
        pullRefreshLayout.setRefreshStyle(PullRefreshLayout.STYLE_Bitmap);
        pullRefreshLayout.setOnRefreshListener(onRefreshListener);
        listView = (ListView) findViewById(R.id.listView);
        quickAdapter = new QuickAdapter<Order>(context,R.layout.myorder_item) {
            @Override
            protected void convert(BaseAdapterHelper helper, final Order item) {
                ListView view = helper.getView(R.id.goodListView);
                QuickAdapter<OrderGoods> quickAdapter1 = new QuickAdapter<OrderGoods>(context,
                        R.layout.order_good_item) {
                    @Override
                    protected void convert(BaseAdapterHelper helper, OrderGoods item) {
                        Picasso.with(context).load(ConfigValue.IMG_IP
                                + item.getGoods_thumb()).error(R.mipmap.ic_launcher)
                                .into((ImageView) helper.getView(R.id.imgGoods));
                        helper.setText(R.id.txtTitle, item.getGoods_name());
                        helper.setText(R.id.txtPrice, "￥" + item.getGoods_price());
                        helper.setText(R.id.txtNumber,"数量：" + item.getGoods_number());
                    }
                };
                quickAdapter1.addAll(item.getGoods());
                view.setAdapter(quickAdapter1);
                ListViewUtils.setListViewHeightBasedOnItems(view);
                helper.setText(R.id.txtAmount, "￥" + item.getTotal());
                TextView txtState = helper.getView(R.id.txtState);
                TextView txtButton = helper.getView(R.id.txtButton);
                TextView txtButton2 = helper.getView(R.id.txtButton2);
                switch (Integer.parseInt(item.getStatus())){
                    case 1:
                        txtState.setText("待付款");
                        txtButton.setText("去支付");
                        txtButton.setVisibility(View.VISIBLE);
                        txtButton2.setVisibility(View.VISIBLE);
                        txtButton2.setText("取    消");
                        break;
                    case 2:
                        txtState.setText("已取消");
                        txtButton.setText("放回购物车");
                        txtButton.setVisibility(View.VISIBLE);
                        txtButton2.setVisibility(View.GONE);
                        break;
                    case 3:
                        txtState.setText("待发货");
                        txtButton.setVisibility(View.INVISIBLE);
                        txtButton2.setVisibility(View.GONE);
                        break;
                    case 4:
                        txtState.setText("已发货");
                        txtButton.setText("确认收货");
                        txtButton.setVisibility(View.VISIBLE);
                        txtButton2.setVisibility(View.GONE);
                        break;
                    case 5:
                        txtState.setText("已完成");
                        txtButton.setText("再次购买");
                        txtButton.setVisibility(View.VISIBLE);
                        txtButton2.setVisibility(View.GONE);
                        break;

                }
                txtButton.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        switch (Integer.parseInt(item.getStatus())){

                            case 1:
                                //跳转支付
                                pay(item);
                                break;
                            case 2:
                            case 5:
                                //再次购买
                                //继续购买
                                Utils.showDialog(MyOrderActivity.this, "提示", "是否重新放回购物车？", "", "", new View.OnClickListener() {

                                    @Override
                                    public void onClick(View view) {
                                        switch (view.getId()) {
                                            case R.id.txtDialogCancel:
                                                Utils.dismissDialog();
                                                break;
                                            case R.id.txtDialogSure:
                                                cartFlag = true;
                                                omPresenter.cartOrder(context, item.getOrder_id());
                                                Utils.dismissDialog();
                                                break;
                                        }
                                    }
                                });

                                break;
                            case 4:
                                Utils.showDialog(MyOrderActivity.this, "提示", "是否确认收货？", "", "", new View.OnClickListener() {
                                    @Override
                                    public void onClick(View view) {
                                        switch (view.getId()) {
                                            case R.id.txtDialogCancel:
                                                Utils.dismissDialog();
                                                break;
                                            case R.id.txtDialogSure:
                                                //确认收货
                                                omPresenter.sureOrder(context, item.getOrder_id());
                                                Utils.dismissDialog();
                                                break;
                                        }
                                    }
                                });
                                break;
                        }
                    }
                });
                txtButton2.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        switch (Integer.parseInt(item.getStatus())){
                            case 1:
                                Utils.showDialog(MyOrderActivity.this, "提示", "确认要取消订单吗？", "", "", new View.OnClickListener() {
                                    @Override
                                    public void onClick(View view) {
                                        switch (view.getId()) {
                                            case R.id.txtDialogCancel:
                                                Utils.dismissDialog();
                                                break;
                                            case R.id.txtDialogSure:
                                                omPresenter.cancelOrder(context, item.getOrder_id());
                                                Utils.dismissDialog();
                                                break;
                                        }
                                    }
                                });
                                break;
                            case 3:
                                //退款
                                break;
                            case 5:
                                //退货
                                Utils.showDialog(MyOrderActivity.this, "提示", "确认要退货吗？", "", "", new View.OnClickListener() {
                                    @Override
                                    public void onClick(View view) {
                                        switch (view.getId()) {
                                            case R.id.txtDialogCancel:
                                                Utils.dismissDialog();
                                                break;
                                            case R.id.txtDialogSure:
                                                omPresenter.returnOrder(context, item.getOrder_id());
                                                Utils.dismissDialog();
                                                break;
                                        }
                                    }
                                });
                                break;
                        }
                    }
                });
            }
        };
        listView.setAdapter(quickAdapter);
        listView.setOnItemClickListener(this);
    }

    private void pay(Order item){
        Intent intent = new Intent(context,PayActivity.class);
        intent.putExtra("class",1);
        intent.putExtra("ordernumber",item.getOrder_sn());
        intent.putExtra("ordermoney",item.getTotal());
        startActivity(intent);
    }
    private PullRefreshLayout.OnRefreshListener onRefreshListener = new PullRefreshLayout.OnRefreshListener() {
        @Override
        public void onRefresh() {
            pullRefreshLayout.post(new Runnable() {
                @Override
                public void run() {
                    presenter.loadOrder(context,"user","order");
                }
            });
        }

        @Override
        public void onMove(boolean ismove) {

        }
    };

    @Override
    public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
        Order model = (Order)adapterView.getItemAtPosition(i);
        Intent intent = new Intent(context,LookOrderActivity.class);
        intent.putExtra("orderid",model.getOrder_id());
        startActivity(intent);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.fl_Left:
                finish();
                break;
        }
    }

    @Override
    protected void onResume() {
        super.onResume();
        presenter.loadOrder(context, "user", "order");
    }

    //获取订单列表的结果
    @Override
    public void orderList(OrderModel model) {
        pullRefreshLayout.setRefreshing(false);
        if(model.getCode().equals("1")){
            if(model.getData().size()>0) {
                quickAdapter.clear();
                quickAdapter.addAll(model.getData());
            }else
                Utils.showToast(context,"没有订单");
        } else if (model.getCode().equals("-220"))
            itLogin(this);
            Utils.showToast(context, model.getMsg());

    }

    @Override
    public void error() {
        pullRefreshLayout.setRefreshing(false);
    }

    //对订单操作的返回
    @Override
    public void result(BaseModel model) {
        if(model.getCode().equals("1")){
            if(cartFlag){
                cartFlag = false;
                Intent intent = new Intent(this, ShoppingCartActivity.class);
                startActivity(intent);
            }else
                presenter.loadOrder(context,"user","order");
        }else if (model.getCode().equals("200"))
            itLogin(this);
        Utils.showToast(context,model.getMsg());
    }
}
