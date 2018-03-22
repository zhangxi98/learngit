package com.jsyh.onlineshopping.activity.me;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.BaseActivity;
import com.jsyh.onlineshopping.utils.CacheManager;
import com.jsyh.onlineshopping.utils.Utils;

/**
 * Created by sks on 2015/9/16.
 */
public class MoreActicity extends BaseActivity implements View.OnClickListener{
    TextView title;
    ImageView back;
    private Context context;
    private TextView txtClear;
    String size = "";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_more);
        context = this;
        title=(TextView)findViewById(R.id.title);
        back = (ImageView)findViewById(R.id.back);
        back.setBackgroundResource(R.mipmap.ic_back);
        title.setText("更多");
        findViewById(R.id.fl_Left).setOnClickListener(this);
        String versions = "V" + Utils.longVersionName(context) + Utils.longVersionCode(context);
        TextView tv = (TextView)findViewById(R.id.txtVersions);
        tv.setText(versions);
        txtClear = (TextView) findViewById(R.id.txtClear);
        count();
        findViewById(R.id.rlClear).setOnClickListener(this);
        findViewById(R.id.rlAbout).setOnClickListener(this);
    }
    private void count(){
        try {
            size = CacheManager.getTotalCacheSize(context);
        } catch (Exception e) {
            e.printStackTrace();
        }
        txtClear.setText(size);
    }
    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.fl_Left:
                finish();
                break;
            case R.id.rlClear:
                Utils.showDialog(this, "提示", "确定清除本地缓存吗？", "", "", new View.OnClickListener() {

                    @Override
                    public void onClick(View view) {
                        switch (view.getId()) {
                            case R.id.txtDialogCancel:
                                Utils.dismissDialog();
                                break;
                            case R.id.txtDialogSure:
                                CacheManager.clearAllCache(context);
                                count();
                                Utils.dismissDialog();
                                break;
                        }
                    }
                });
                break;
            case R.id.rlAbout:
                Intent intent = new Intent(this,AboutActivity.class);
                startActivity(intent);
                break;
        }
    }
}
