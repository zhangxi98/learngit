package com.jsyh.onlineshopping.activity.me;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.BaseActivity;
import com.jsyh.onlineshopping.model.Address;
import com.jsyh.onlineshopping.model.AddressModel;
import com.jsyh.onlineshopping.model.BaseModel;
import com.jsyh.onlineshopping.presenter.AddressPresenter;
import com.jsyh.onlineshopping.presenter.DeleteAddressPresenter;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.AddressView;
import com.jsyh.shopping.uilibrary.adapter.listview.BaseAdapterHelper;
import com.jsyh.shopping.uilibrary.adapter.listview.QuickAdapter;

/**
 * Created by sks on 2015/9/24.
 *
 * 收货地址管理
 */
public class AddressListActivity extends BaseActivity implements View.OnClickListener,
        AdapterView.OnItemClickListener,AddressView{
    private Context context;
    TextView title;
    ImageView back;
    private ListView listView;
    private QuickAdapter<Address> quickAdapter;
    private AddressPresenter addressPresenter;
    private DeleteAddressPresenter daPresenter;
    private boolean flag;
    @Override
    public void initView() {
        super.initView();
        setContentView(R.layout.activity_addresslist);
        context = this;
        flag = getIntent().getBooleanExtra("order",false);
        addressPresenter = new AddressPresenter(this);
        daPresenter = new DeleteAddressPresenter(this);
        title=(TextView)findViewById(R.id.title);
        back = (ImageView)findViewById(R.id.back);
        findViewById(R.id.fl_Left).setOnClickListener(this);
        back.setBackgroundResource(R.mipmap.ic_back);
        title.setText("地址管理");
        findViewById(R.id.btnAdd).setOnClickListener(this);
        listView = (ListView)findViewById(R.id.listView);
        quickAdapter = new QuickAdapter<Address>(context,R.layout.address_item) {
            @Override
            protected void convert(BaseAdapterHelper helper, final Address item) {
                helper.setText(R.id.txtName,item.getUsername());
                helper.setText(R.id.txtPhone, item.getTelnumber());
                helper.setText(R.id.txtAddress, item.getAddress());
                //删除
                helper.setOnClickListener(R.id.txtDelete, new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        Utils.showDialog(AddressListActivity.this, "提示", "确定要删除地址吗？", "", "", new View.OnClickListener() {
                            @Override
                            public void onClick(View view) {
                                switch (view.getId()) {
                                    case R.id.txtDialogCancel:
                                        Utils.dismissDialog();
                                        break;
                                    case R.id.txtDialogSure:
                                        daPresenter.loadDelete(context, item.getAddress_id(), "deladdress");
                                        Utils.dismissDialog();
                                        break;
                                }
                            }
                        });
                    }
                });
                //编辑
                helper.setOnClickListener(R.id.txtEdit, new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        Intent itEdit = new Intent(context,NewAddressActivity.class);
                        itEdit.putExtra("address",item.getAddress_id());
                        startActivity(itEdit);
                    }
                });
                //设置默认地址
                helper.setOnClickListener(R.id.checkBox, new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        daPresenter.loadDelete(context, item.getAddress_id(),"addrdefault");
                    }
                });
                boolean check = false;
                if(item.getIs_default() == 1)
                    check = true;
                helper.setChecked(R.id.checkBox,check);
            }
        };
        listView.setAdapter(quickAdapter);
        if (flag)
            listView.setOnItemClickListener(this);
    }
    //地址列表返回
    @Override
    public void getAddressList(AddressModel response) {
        if(response.getCode().equals("1")){
            quickAdapter.clear();
            if(response.getData().size()>0){
                quickAdapter.addAll(response.getData());
            }else
                Utils.showToast(context,response.getMsg());
        }else if (response.getCode().equals("-220"))
            itLogin(this);
            Utils.showToast(context,response.getMsg());
    }
    //删除/设置默认  返回
    @Override
    public void delete(BaseModel model) {
        if(model.getCode().equals("1"))
            addressPresenter.setAddressData(context);
        else if(model.getCode().equals("-220")){
            itLogin(context);
        }
        Utils.showToast(context,model.getMsg());
    }

    @Override
    public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
        Address model = (Address)adapterView.getItemAtPosition(i);
        Intent intent = new Intent();
        Bundle bundle=new Bundle();
        bundle.putSerializable("orderaddress", model);
        intent.putExtras(bundle);
        setResult(CreateOrderActivity.ADDRESS,intent);
        finish();
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.fl_Left:
                finish();
                break;
            //新建地址
            case R.id.btnAdd:
                Intent itNewAddress = new Intent(context,NewAddressActivity.class);
                startActivity(itNewAddress);
                break;
        }
    }

    @Override
    protected void onPostResume() {
        addressPresenter.setAddressData(context);
        super.onPostResume();
    }
}
